<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Cache\CacheRepository;
use Illuminate\Support\Facades\Mail;
use Spatie\SSLCertificate\SSLCertificate;
use App\Model\Post;
use App\Mail\CertificateAlert;

/**
 * SSL Certificate validity checks for client sites.
 *
 * @author  Kelly Mears <developers@tinypixel.dev>
 * @license MIT
 */
class SSL
{
    /**
     * Cache
     *
     * @var Illuminate\Cache\CacheRepository
     */
    protected static $cache;

    /**
     * Mail
     *
     * @var Illuminate\Mail
     */
    protected static $mail;

    /**
     * SSL
     *
     * @var \Spatie\SSLCertificate\SSLCertificate
     */
    protected static $ssl;

    /**
     * Post model
     *
     * @var \App\Model\Post
     */
    protected static $post;

    /**
     * Alert audience
     *
     * @var string
     */
    protected static $alertAudience = 'developer';

    /**
     * Now
     *
     * @var DateTime
     */
    protected static $now;

    /**
     * Flag invalid cert
     *
     * @var bool
     */
    protected $flagInvalidCert = false;

    /**
     * Class constructor.
     *
     * @param \Spatie\SSLCertificate\SSLCertificate $ssl
     * @param \Illuminate\Cache\CacheRepository $cache
     */
    public function __construct($ssl, $cache, $mail)
    {
        self::$cache = $cache;

        self::$ssl   = $ssl;

        self::$post  = \App\Model\Post::class;

        self::$now   = Carbon::now();

        $this->checkDomains = Collection::make();
    }

    /**
     * Initialize class.
     *
     * @return void
     */
    public function init() : void
    {
        /**
         * Cron event
         */
        add_action('cron-check-sites', [$this, 'checkSites']);

        /**
         * Add cron event to schedule
         */
        if (! wp_next_scheduled('cron-check-sites')) {
            wp_schedule_event(self::$now, 3600, 'cron-check-sites');
        }
    }

    /**
     * New alert is due to be sent.
     *
     * @return bool
     */
    public function dueToBeSent(string $lastSent) : bool
    {
        return Carbon::parse($lastSent)->floatDiffInHours(self::$now) > 23;
    }

    /**
     * Collect sites.
     *
     * @return void
     */
    public function collectSites()
    {
        /**
         * Query the database for sites
         * and their metadata
         */
        $sites = self::$post::type('site')->status('publish')->with('meta')->get();

        /**
         * Then, make a collection out of the results and iterate
         * through it.
         */
        Collection::make($sites)->each(function ($site) {
            /**
             * A new site will not have the last_checked meta.
             */
            if ($site->meta->last_checked == null) {
                /**
                 * So, create this meta
                 */
                $site->saveMeta('last_checked', self::$now);

                /**
                 * And register the site to be checked.
                 */
                $this->checkDomains->push([
                    'production' => $site->meta->hostnames_production,
                    'staging'    => $site->meta->hostnames_staging,
                ]);

            }

            /**
             * If an alert hasn't gone out recently
             * check the domains.
             */
            if ($this->dueToBeSent($site->meta->last_checked)) {
                $this->checkDomains->push([
                    'production' => $site->meta->hostnames_production,
                    'staging'    => $site->meta->hostnames_staging,
                ]);

                /**
                 * And save the new `last_checked` value to prevent
                 * repeat mailings.
                 */
                $site->saveMeta('last_checked', self::$now);
            }
        });

        /**
         * If one or more of the sites has been added to the
         * results collection then return the collection.
         */
        if (! $this->checkDomains->isEmpty()) {
            return $this->checkDomains;
        }

        /**
         * Else, return nothing.
         */
        return null;
    }

    /**
     * Check site certificates.
     *
     * @return void
     */
    public function checkSites()
    {
        /**
         * Gather sites.
         *
         * If messages have been sent recently or there are no sites
         * to message about then return early.
         */
        if (! $checkDomains = $this->collectSites()) {
            return;
        }

        /**
         * Otherwise, collect the domains
         */
        Collection::make($this->checkDomains)->each(function ($domains) {
            /**
             * And for each one
             */
            foreach ($domains as $env => $domain) {
                /**
                 * Check the status of its certificate.
                 */
                $certCheck = self::$ssl::createForHostName($domain);

                /**
                 * And set an array
                 */
                $certInfo  = new Object(
                    $domain      = $domain,
                    $environment = $env,
                    $valid       = $certCheck->isValid(),
                    $issuer      = $certCheck->getIssuer(),
                    $expiration  = $certCheck->expirationDate()->toDayDateTimeString(),
                    $daysLeft    = $certCheck->expirationDate()->diffInDays(),
                );

                /**
                 * If the certificate is invalid
                 */
                if (! $certInfo->valid) {
                    /**
                     * Then flag it as such.
                     */
                    $this->flagInvalid = true;

                    /**
                     * And alert interested parties via email.
                     */
                    $this->sendMailToAll(
                        self::$alertAudience,
                        'invalidCert',
                        (array) $certInfo
                    );

                /**
                 * If the domain is set to expire soon
                 */
                } elseif ($certInfo->daysLeft < 7
                    && $certInfo->environment == 'production') {
                    /**
                     * Then flag it as such.
                     */
                    $this->flagInvalid = true;

                    /**
                     * And alert interested parties via email.
                     */
                    $this->sendMailToAll(
                        self::$alertAudience,
                        'upcomingCert',
                        (array) $certInfo
                    );
                }
            }
        });

        /**
         * Finally, if no domain was flagged as expired or soon to expire
         * then send a success summary.
         */
        if (! $this->flagInvalidCert) {
            $this->sendMailToAll(
                self::$alertAudience,
                'nominalCerts'
            );
        }
    }

    /**
     * Send mail to a specific WP_User role.
     *
     * @param  string $role
     * @param  string $alertType
     * @param  array  $certInfo
     *
     * @return void
     */
    public function sendMailToAll(string $alertAudience, string $alertType, array $certInfo = []) : void
    {
        $audience = \get_users(['role' => $alertAudience]);

        Collection::make($audience)->each(
            function ($user) use ($certInfo, $alertType) {
                $this->sendMail($user->user_email, $alertType, $certInfo);
            }
        );
    }

    /**
     * Send an email message.
     *
     * @param  string $role
     * @param  string $alertType
     * @param  array  $certInfo
     *
     * @return void
     */
    public function sendMail(string $recipient, string $alertType, array $certInfo)
    {
        Mail::to($recipient)->send(new CertificateAlert($recipient, $alertType, $certInfo));
    }
}

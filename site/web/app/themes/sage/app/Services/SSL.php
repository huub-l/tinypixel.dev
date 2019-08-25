<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Cache\CacheRepository;
use Illuminate\Support\Facades\Mail;
use Spatie\SSLCertificate\SSLCertificate;
use App\Model\Post;
use App\Mail\CertificateAlert;

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
        $this->collectSites();

        add_action('init', [$this, 'checkSites']);
    }

    /**
     * New alert is due to be sent.
     *
     * @return bool
     */
    public function dueToBeSent(string $lastSent) : bool
    {
        return Carbon::parse($lastSent)->floatDiffInHours(self::$now) > 24;
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
         * And make a collection out of the results.
         */
        Collection::make($sites)->each(function ($site) {
            /**
             * Save `last_checked` if it isn't set (new site)
             */
            if ($site->meta->last_checked == null) {
                $site->saveMeta('last_checked', self::$now);
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
    }

    /**
     * Check site certificates.
     *
     * @return void
     */
    public function checkSites()
    {
        /**
         * If there are domains to message about
         */
        if (! $this->checkDomains->isEmpty()) {
            /**
             * Collect the domains
             */
            Collection::make($this->checkDomains)->each(function ($domains) {
                foreach ($domains as $env => $domain) {

                    /**
                     * Gather information on the domain.
                     */
                    $certCheck = self::$ssl::createForHostName($domain);

                    $certInfo  = [
                        'domain'      => $domain,
                        'environment' => $env,
                        'valid'       => $certCheck->isValid(),
                        'issuer'      => $certCheck->getIssuer(),
                        'expiration'  => $certCheck->expirationDate()->toDayDateTimeString(),
                        'daysLeft'    => $certCheck->expirationDate()->diffInDays(),
                    ];

                    /**
                     * If domain certificate is invalid
                     */
                    if (! $certInfo['valid']) {
                        /**
                         * Then set the `flagInvalid` flag to true.
                         */
                        $this->flagInvalid = true;

                        /**
                         * And send the mail.
                         */
                        $this->sendMailToAll(self::$alertAudience, 'invalidCert', $certInfo);
                    }

                    /**
                     * If the domain is set to expire soon
                     */
                    elseif ($certInfo['daysLeft'] < 7 && $certInfo['environment'] == 'production') {
                        /**
                         * Then set the `flagInvalid` flag to true.
                         */
                        $this->flagInvalid = true;

                        /**
                         * And send the mail.
                         */
                        $this->sendMailToAll(self::$alertAudience, 'upcomingCert', $certInfo);
                    }
                }
            });

            /**
             * Finally, if no domain was flagged as expired or soon to expire
             * then send a success summary.
             */
            if (! $this->flagInvalidCert) {
                $this->sendMailToAll(self::$alertAudience, 'nominalCerts');
            }
        }
    }

    /**
     * Mail audience.
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

        Collection::make($audience)->each(function ($user) use ($certInfo, $alertType) {
            $this->sendMail($user->user_email, $alertType, $certInfo);
        });
    }

    /**
     * Send mail.
     *
     * @param  string $role
     * @param  string $alertType
     * @param  array  $certInfo
     * @return void
     */
    public function sendMail(string $recipient, string $alertType, array $certInfo)
    {
        Mail::to($recipient)->send(
            new CertificateAlert($recipient, $alertType, $certInfo)
        );
    }
}

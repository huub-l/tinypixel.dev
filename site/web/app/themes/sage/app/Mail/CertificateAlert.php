<?php

namespace App\Mail;

use Illuminate\Support\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function \wp_load_alloptions;

/**
 * SSL Certificate Alert Mailable
 *
 * @author  Kelly Mears <kelly@tinypixel.dev>
 * @license MIT
 * @since   1.0.0
 * @see     TinyPixel\WordPress\Mail\WordPressMail
 * @link    https://laravel.com/docs/5.8/mail
 *
 * @package    WordPress
 * @subpackage App
 */
class CertificateAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Subject
     *
     * @var string
     */
    public $subject;

    /**
     * Body
     *
     * @var string
     */
    public $body;

    /**
     * Attachment
     *
     * @var array
     */
    public $attach;

    /**
     * Site
     *
     * @var object
     */
    public $site;

    /**
     * Disclaimer
     *
     * @var string
     */
    public $disclaimer;

    /**
     * Logo
     *
     * @var string
     */
    public $logo = 'https://tinypixel.dev/app/uploads/2019/08/tiny-pixel-circle.png';

    /**
     * Creates a new WordPress Mailable instance.
     *
     * @param  array $mail
     * @return void
     */
    public function __construct(string $user, string $alertType, array $cert)
    {
        $this->user = $user;
        $this->cert = $cert;
        $this->type = $alertType;
    }

    /**
     * Set contents
     *
     * @return void
     */
    public function setContents()
    {
        $this->subject    = $this->emailComponent('subject');
        $this->body       = $this->emailComponent('body');
        $this->site       = (object) \wp_load_alloptions();
    }

    /**
     * Build the message
     *
     * @return \Illuminate\View\View
     */
    public function build()
    {
        $this->setContents();

        if (! is_null($this->subject)) {
            $this->subject($this->subject);
        }

        return $this->view('Mail::wordpress');
    }

    /**
     * Returns the email component if set.
     *
     * @param  string $component
     * @return mixed
     */
    protected function emailComponent($component)
    {
        if ($component == 'subject') {
            switch ($this->type) {
                case 'nominalCerts':
                    return '[SSL] Client certificates are all looking good!';
                case 'invalidCert':
                    return "[SSL] Invalid cert detected for {$this->cert['domain']}";
                case 'upcomingCert':
                    return "[SSL] Certificate expiring soon for {$this->cert['domain']}";
            }
        }

        if ($component == 'body') {
            switch ($this->type) {
                case 'nominalCerts':
                    return '<p>Have a great day!</p>';
                case 'invalidCert':
                    return "<p>Looks like there is a problem with the certificate for {$this->cert['domain']}</p> \n
                            <p>Here's the lowdown:</p> \n
                            <ul> \n
                                <li><strong>Domain:     {$this->cert['domain']}</li>    \n
                                <li><strong>Issuer:     {$this->cert['issuer']}</li>    \n
                                <li><strong>Expired on: {$this->cert['expiration']}</li>\n
                            </ul> \n";
                case 'upcomingCert':
                    return "<p><strong>Heads up!</strong> The SSL certificate for {$this->cert['domain']} is expiring \n
                            in {$this->cert['daysLeft']} days ({$this->cert['expiration']}).</p>";
            }
        }
    }
}

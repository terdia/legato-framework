<?php


namespace Legato\Framework\Mail;

use Swift_SmtpTransport;
use Swift_Mailer;

class SMTPClient
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Swift_SmtpTransport
     */
    private $transport;

    /**
     * @var, username for SMTP Client
     */
    private $SMTPUsername;

    /**
     * @var , password for SMTP Client
     */
    private $SMTPPassword;

    /**
     * @var, SMTP Hostname
     */
    private $SMTPHost;

    /**
     * @var, SMTP Client Port
     */
    private $SMTPPort;

    public function __construct()
    {
        $this->SMTPHost = getenv('SMTP_HOST');
        $this->SMTPPort = getenv('SMTP_PORT');
        $this->SMTPUsername = getenv('SMTP_USERNAME');
        $this->SMTPPassword = getenv('SMTP_PASSWORD');

        $this->transport = (new Swift_SmtpTransport($this->SMTPHost, $this->SMTPPort))
            ->setUsername($this->SMTPUsername)
            ->setPassword($this->SMTPPassword);

        $this->mailer = new Swift_Mailer($this->transport);
    }

    public function send($message)
    {
        return $this->mailer->send($message);
    }

}
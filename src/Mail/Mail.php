<?php


namespace Legato\Framework\Mail;


class Mail extends Message
{

    /**
     * The mail driver specified in .env file
     *
     * @var $driver
     */
    public static $driver;

    public static function setDriver()
    {
        return static::$driver = getenv('MAIL_DRIVER');
    }

    public static function getMailerClient()
    {
        self::setDriver();

        switch (strtolower(static::$driver))
        {
            case 'smtp':
                return new SMTPClient;
                break;
            case 'mailgun':
                return new MailGunClient;
                break;
            default:
                die('driver not found');
        }
    }

    /**
     * Send message using chosen driver
     *
     * @param $params
     * @return int|mixed
     */
    public static function send($params)
    {
        $params = array_merge([
            'subject' => '',
            'view' => '',
            'body' => '',
            'bodyHtml' => '',
            'to' => [],
            'bcc' => [],
            'cc' => [],
            'replyTo' => [],
            'file' => ''
        ], $params);

        $message = (new static())->to($params['to'])->from($params['from'])
            ->subject($params['subject'])->bcc($params['bcc'])->cc($params['cc'])
            ->reply($params['replyTo']);

        if($params['view'] != '')
        {
            $message->body(makeMail($params['view'], array('data' => $params['body'])), 'text/html');
        }else{
            $message->body($params['body']);
        }

        if($params['file'] != '')
        {
            $message->attachment($params['file']);
        }

        return self::getMailerClient()->send($message);
    }
}
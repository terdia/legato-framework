<?php

/*
 * This file is part of the Legato package.
 *
 * (c) Osayawe Ogbemudia Terry <terry@devscreencast.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Legato\Framework\Mail\Transport;

use GuzzleHttp\Client;
use Swift_Mime_SimpleMessage;

class MailGunClient
{
    /**
     * Registered mailgun domain.
     *
     * @var
     */
    private $domain;

    /**
     * The Mailgun Url to post to.
     *
     * @var
     */
    private $endPoint;

    /**
     * GuzzleHttp Client.
     *
     * @var
     */
    private $httpClient;

    /**
     * Mailgun API key.
     *
     * @var
     */
    private $apiKey;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->domain = getenv('MAILGUN_DOMAIN');
        $this->apiKey = getenv('MAILGUN_SECRET');
    }

    public function send(Swift_Mime_SimpleMessage $message)
    {
        $this->setEndpoint();

        $to = $this->prepareTo($message);

        $message->setBcc([]);

        $result = $this->httpClient->post($this->endPoint, [
            'auth' => [
                'api',
                $this->key(),
            ],
            'multipart' => [
                ['name' => 'to', 'contents' => $to],
                ['name' => 'message', 'contents' => $message->toString(), 'filename' => 'message.mime'],
            ],
        ]);

        return json_decode($result->getBody());
    }

    /**
     * Combine all contacts for the message.
     *
     * @param \Swift_Mime_SimpleMessage $message
     *
     * @return array
     */
    protected function combineTo(Swift_Mime_SimpleMessage $message)
    {
        return array_merge(
            (array) $message->getTo(), (array) $message->getCc(), (array) $message->getBcc()
        );
    }

    /**
     * Format the to addresses to match Mailgun message.mime format.
     *
     * @param Swift_Mime_SimpleMessage $message
     *
     * @return string
     */
    protected function prepareTo(Swift_Mime_SimpleMessage $message)
    {
        $to = array_map(function ($name, $address) {
            return $name ? $name." <{$address}>" : $address;
        }, $this->combineTo($message), array_keys($this->combineTo($message)));

        return implode(',', $to);
    }

    /**
     * Set the Mailgun post URL (endpoint).
     */
    public function setEndpoint()
    {
        $this->endPoint = 'https://api.mailgun.net/v3/'.$this->domain.'/messages.mime';
    }

    /**
     * Get the API key for Mailgun.
     *
     * @return mixed
     */
    public function key()
    {
        return $this->apiKey;
    }
}

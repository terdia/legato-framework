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

namespace Legato\Framework\Mail;

use Swift_Attachment;
use Swift_Message;

abstract class Message extends Swift_Message
{
    public function subject($subject)
    {
        $this->setSubject($subject);

        return $this;
    }

    public function to($to)
    {
        $this->setTo($to);

        return $this;
    }

    public function from($from)
    {
        $this->setFrom($from);

        return $this;
    }

    public function body($message, $contentType = null, $charset = null)
    {
        $this->setBody($message, $contentType, $charset);

        return $this;
    }

    public function cc($addresses)
    {
        $this->setCc($addresses);

        return $this;
    }

    public function bcc($addresses)
    {
        $this->setBcc($addresses);

        return $this;
    }

    public function reply($address, $name = null)
    {
        $this->setReplyTo($address, $name);

        return $this;
    }

    public function attachment($path)
    {
        $this->attach(Swift_Attachment::fromPath($path));

        return $this;
    }
}

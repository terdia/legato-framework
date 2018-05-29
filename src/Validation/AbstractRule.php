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

namespace Legato\Framework\Validator;

class AbstractRule
{
    protected function removeSpaces($value)
    {
        return trim($value);
    }

    public function shouldNotBeEmpty($value)
    {
        return $value != null && !empty($this->removeSpaces($value));
    }
}

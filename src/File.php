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

namespace Legato\Framework;

use Symfony\Component\Filesystem\Filesystem;

class File
{
    public function getFileSystem()
    {
        return new Filesystem();
    }
}

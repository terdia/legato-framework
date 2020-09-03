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

namespace Legato\Framework\Console\Interfaces;

interface TemplateGenerator
{
    /**
     * Get the stub for the file to be generated.
     *
     * @param $type
     *
     * @return mixed
     */
    public function getTemplate($type = null);

    /**
     * @param $search
     * @param $replace
     * @param $target
     *
     * @return mixed
     */
    public function findTemplateAndReplacePlaceHolders($search, $replace, $target);
}

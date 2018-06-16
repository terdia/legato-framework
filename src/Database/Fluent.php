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

use Illuminate\Database\Eloquent\Model;

class Fluent extends Model
{
    public static function paginated($perPage, $options = [], $query = null)
    {
        $request = new Request();

        if (is_null($query)) {
            $query = 'page';
        }

        if (!isset($options['path'])) {
            $options['path'] = $request->path();
        }

        $currentPage = $request->input($query) ?: '1';

        return new Paginator(static::all(), $perPage, $currentPage, $options);
    }
}

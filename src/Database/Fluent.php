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

namespace Legato\Framework\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Fluent extends Model
{
    /**
     * @param $perPage
     * @param array $item
     * @param array $options
     * @param null  $query
     *
     * @return Paginator
     */
    public static function paginated($perPage, $item = [], $options = [], $query = null)
    {
        $request = new Request();

        if (is_null($query)) {
            $query = 'page';
        }

        if (!count($item)) {
            $item = static::all();
        }

        $currentPage = $request->input($query, null);
        if (is_null($currentPage)) {
            $currentPage = 1;
        }

        $collection = new Collection($item);
        $currentPageResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        if (!isset($options['path'])) {
            $options['path'] = $request->path();
        }

        return new Paginator(
            $currentPageResults, count($collection), $perPage, $currentPage, $options
        );
    }

    /**
     * @param $perPage
     * @param array $item
     * @param array $options
     * @param null  $query
     *
     * @return SimplePaginator
     */
    public static function paginateBasic($perPage, $item = [], $options = [], $query = null)
    {
        $request = new Request();

        if (is_null($query)) {
            $query = 'page';
        }

        if (!count($item)) {
            $item = static::all();
        }

        $currentPage = $request->input($query, null);
        if (is_null($currentPage)) {
            $currentPage = 1;
        }

        $collection = new Collection($item);
        $currentPageResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        if (!isset($options['path'])) {
            $options['path'] = $request->path();
        }

        return new SimplePaginator($currentPageResults, $perPage, $currentPage, $options);
    }
}

<?php

namespace App\Models;

use Core\App;

final class ShortLink
{
    /**
     * @return bool|array
     */
    public static function get(): bool|array
    {
        return App::get('database')
            ->query('
            select
                short_links.id AS slid,
                short_links.target_url AS original_url,
                SUM(short_link_logs.clicks) AS total_clicks,
                COUNT(short_link_logs.id) AS unique_clicks
            from
                short_links
            LEFT JOIN
                    short_link_logs ON short_links.id = short_link_logs.short_link_id
            GROUP BY
                short_links.id
            ORDER BY
                short_links.id DESC
            ')
            ->get();
    }

    /**
     * @param array $parameters
     * @return int
     */
    public static function insert(array $parameters): int
    {
        return App::get('database')
            ->query('INSERT INTO short_links(target_url) VALUES (:target_url)', $parameters)
            ->lastInsertId();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function findById(int $id): mixed
    {
        return App::get('database')
            ->query('select * from short_links where id = :id', ['id' => $id])
            ->find();
    }
}

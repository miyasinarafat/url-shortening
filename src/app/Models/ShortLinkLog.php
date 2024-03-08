<?php

namespace App\Models;

use Core\App;

final class ShortLinkLog
{
    /**
     * @param string $userIp
     * @param int $shortLinkId
     * @return mixed
     */
    public static function findByIpAndShortLinkId(string $userIp, int $shortLinkId): mixed
    {
        return App::get('database')
            ->query('select * from short_link_logs where short_link_id = :short_link_id and user_ip = :user_ip', [
                'short_link_id' => $shortLinkId,
                'user_ip' => $userIp,
            ])
            ->find();
    }

    /**
     * @param array $parameters
     * @return int
     */
    public static function insert(array $parameters): int
    {
        return App::get('database')
            ->query('
            INSERT INTO
                short_link_logs(short_link_id, user_ip, clicks)
            VALUES
                (:short_link_id, :user_ip, :clicks)
            ',
                $parameters
            )
            ->lastInsertId();
    }

    /**
     * @param int $id
     * @return void
     */
    public static function incrementClicksById(int $id): void
    {
        App::get('database')->query('UPDATE short_link_logs SET clicks = clicks + 1 WHERE id = :id', [
            'id' => $id,
        ]);
    }
}

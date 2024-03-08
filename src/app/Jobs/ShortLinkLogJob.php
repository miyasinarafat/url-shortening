<?php

namespace App\Jobs;

use App\Models\ShortLinkLog;
use Core\Queue\Job;

class ShortLinkLogJob implements Job
{
    public function execute(array $payload): void
    {
        $userIp = $payload['user_ip'];
        $linkId = $payload['link_id'];

        /** Fetching short link entity log for user by user ip */
        $log = ShortLinkLog::findByIpAndShortLinkId($userIp, $linkId);

        /** Storing short link entity log if not found by user ip */
        if (! $log) {
            ShortLinkLog::insert([
                'short_link_id' => $linkId,
                'user_ip' => $userIp,
                'clicks' => 1,
            ]);
        }

        /** Updating the short link entity log count */
        if ($log) {
            ShortLinkLog::incrementClicksById($log['id']);
        }
    }
}

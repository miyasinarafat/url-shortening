<?php

namespace Tests\Models;

use App\Models\ShortLink;
use App\Models\ShortLinkLog;
use Tests\RefreshDatabase;
use Tests\TestCase;

class ShortLinkLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        $this->setupSQLite();
    }

    public function testFindByIpAndShortLinkId(): void
    {
        $userIp = '127.0.0.1';
        $linkId = ShortLink::insert(['target_url' => 'https://example.com']);
        ShortLinkLog::insert([
            'short_link_id' => $linkId,
            'user_ip' => $userIp,
            'clicks' => 1,
        ]);

        $log = ShortLinkLog::findByIpAndShortLinkId($userIp, $linkId);

        $this->assertNotFalse($log);
        $this->assertEquals($userIp, $log['user_ip']);
        $this->assertEquals($linkId, $log['short_link_id']);
        $this->assertEquals(1, $log['clicks']);
    }

    public function testInsert(): void
    {
        $userIp = '127.0.0.1';
        $linkId = ShortLink::insert(['target_url' => 'https://example2.com']);

        ShortLinkLog::insert([
            'short_link_id' => $linkId,
            'user_ip' => $userIp,
            'clicks' => 1,
        ]);
        $log = ShortLinkLog::findByIpAndShortLinkId($userIp, $linkId);

        $this->assertNotFalse($log);
        $this->assertEquals($userIp, $log['user_ip']);
        $this->assertEquals($linkId, $log['short_link_id']);
        $this->assertEquals(1, $log['clicks']);
    }

    public function testIncrementClicksById(): void
    {
        $userIp = '127.0.0.1';
        $linkId = ShortLink::insert(['target_url' => 'https://example3.com']);
        $logId = ShortLinkLog::insert([
            'short_link_id' => $linkId,
            'user_ip' => $userIp,
            'clicks' => 1,
        ]);

        ShortLinkLog::incrementClicksById($logId);
        $log = ShortLinkLog::findByIpAndShortLinkId($userIp, $linkId);

        $this->assertNotFalse($log);
        $this->assertEquals($userIp, $log['user_ip']);
        $this->assertEquals($linkId, $log['short_link_id']);
        $this->assertEquals(2, $log['clicks']);
    }

    public function testFindByIpAndShortLinkIdWithNonExistingIpAndId(): void
    {
        $userIp = '127.0.0.1.00.0';
        $linkId = 123;

        $log = ShortLinkLog::findByIpAndShortLinkId($userIp, $linkId);

        $this->assertFalse($log);
    }
}

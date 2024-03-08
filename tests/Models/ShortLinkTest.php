<?php

namespace Tests\Models;

use App\Models\ShortLink;
use Tests\RefreshDatabase;
use Tests\TestCase;

class ShortLinkTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        $this->setupSQLite();
    }

    public function testGet(): void
    {
        $shortLinkData = [
            ['target_url' => 'https://google.com'],
            ['target_url' => 'https://example.com'],
        ];

        foreach ($shortLinkData as $data) {
            ShortLink::insert($data);
        }

        $shortLinks = ShortLink::get();
        $dbShortLink = end($shortLinks);

        $this->assertCount(2, $shortLinks);
        $this->assertArrayHasKey('slid', $dbShortLink);
        $this->assertArrayHasKey('original_url', $dbShortLink);
        $this->assertArrayHasKey('total_clicks', $dbShortLink);
        $this->assertArrayHasKey('unique_clicks', $dbShortLink);
        $this->assertEquals(0, $dbShortLink['total_clicks']);
        $this->assertEquals(0, $dbShortLink['unique_clicks']);
    }

    public function testInsert(): void
    {
        $targetUrl = 'https://google.com';

        $id = ShortLink::insert(['target_url' => $targetUrl]);
        $dbShortLink = ShortLink::findById($id);

        $this->assertEquals($targetUrl, $dbShortLink['target_url']);
    }

    public function testFindById(): void
    {
        $targetUrl = 'https://google.com';
        $id = ShortLink::insert(['target_url' => $targetUrl]);

        $dbShortLink = ShortLink::findById($id);

        $this->assertNotNull($dbShortLink);
        $this->assertEquals($targetUrl, $dbShortLink['target_url']);
    }

    public function testFindByIdWithNonExistingId(): void
    {
        $id = 123;

        $shortLink = ShortLink::findById($id);

        $this->assertFalse($shortLink);
    }
}

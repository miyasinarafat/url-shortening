<?php

namespace Tests\Repositories;

use App\Repositories\ShortLinkRepository;
use Tests\RefreshDatabase;
use Tests\TestCase;

class ShortLinkRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ShortLinkRepository $repository;

    protected function setUp(): void
    {
        $this->setupSQLite();

        $this->repository = new ShortLinkRepository();
    }

    public function testSave(): void
    {
        $targetUrl = 'https://google.com';

        $id = $this->repository->save($targetUrl);

        $this->assertIsInt($id);
    }

    public function testGetList(): void
    {
        $shortLinkData = [
            'https://google.com',
            'https://example.com',
        ];

        foreach ($shortLinkData as $targetUrl) {
            $this->repository->save($targetUrl);
        }

        $shortLinks = $this->repository->getList();
        $dbShortLink = end($shortLinks);

        $this->assertCount(2, $shortLinks);
        $this->assertArrayHasKey('slid', $dbShortLink);
        $this->assertArrayHasKey('original_url', $dbShortLink);
        $this->assertArrayHasKey('total_clicks', $dbShortLink);
        $this->assertArrayHasKey('unique_clicks', $dbShortLink);
        $this->assertEquals(0, $dbShortLink['total_clicks']);
        $this->assertEquals(0, $dbShortLink['unique_clicks']);
    }
}

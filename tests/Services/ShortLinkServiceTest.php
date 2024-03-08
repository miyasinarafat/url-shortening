<?php

namespace Tests\Services;

use App\Services\ShortLinkService;
use Tests\TestCase;

class ShortLinkServiceTest extends TestCase
{
    public function testEncode(): void
    {
        $id = 987654321; /* 14q60P */
        $predictedHash = '14q60P';

        $hash = ShortLinkService::encode($id);

        $this->assertEquals($predictedHash, $hash);
    }

    public function testDecode(): void
    {
        $hash = '14q60P'; /* 987654321 */
        $predictedId = 987654321;

        $id = ShortLinkService::decode($hash);

        $this->assertEquals($predictedId, $id);
    }
}

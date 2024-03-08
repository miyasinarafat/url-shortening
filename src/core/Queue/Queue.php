<?php

namespace Core\Queue;

use Core\App;

final class Queue
{
    private array $payload;

    /**
     * @param array $payload
     * @return static
     */
    public static function make(array $payload): static
    {
        $queue = new static();
        $queue->payload = $payload;

        return $queue;
    }

    /**
     * @param string $jobType
     * @return void
     */
    public function push(string $jobType): void
    {
        $redis = App::get('redis');

        $redis->lpush('jobs', json_encode([
            'type' => $jobType,
            'body' => $this->payload,
        ]));
    }
}

<?php

namespace Core\Queue;

interface Job
{
    public function execute(array $payload): void;
}

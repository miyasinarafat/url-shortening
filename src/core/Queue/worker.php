<?php
require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use App\Jobs\ShortLinkLogJob;
use Core\App;

$redis = App::get('redis');
echo 'Queue worker is listening for jobs...' . PHP_EOL;

while (true) {
    /** Loop stops and waits here until a job becomes available */
    $jobData = json_decode($redis->brpop('jobs', 0)[1], true);
    $jobBody = $jobData['body'];
    $jobType = $jobData['type'];

    /** Here we can add new jobs based on their job `type` */
    $job = match ($jobType) {
        ShortLinkLogJob::class => new ShortLinkLogJob(),
        default => throw new \Exception("Job [{$jobType}] does not exist.")
    };

    $job->execute($jobBody);
}

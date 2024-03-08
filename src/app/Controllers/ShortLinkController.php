<?php

namespace App\Controllers;

use App\Jobs\ShortLinkLogJob;
use App\Repositories\ShortLinkRepository;
use App\Services\ShortLinkService;
use Core\App;
use Core\Queue\Queue;
use Core\Session;
use Core\ValidationException;
use Core\Validator;
use RuntimeException;

final class ShortLinkController
{
    /**
     * Show all entities.
     * @return mixed
     */
    public function index(): mixed
    {
        $links = App::get(ShortLinkRepository::class)->getList();
        $basePath = App::get('config')['shorten_base_path'];

        return view('links', compact('links', 'basePath'));
    }

    /**
     * Store a new link in the database.
     * @return mixed
     * @throws ValidationException
     */
    public function store(): mixed
    {
        /** Destroying session to handle another request */
        if (array_key_exists('another', $_POST)) {
            return $this->handleAnotherRequest();
        }

        /** handling new request */
        $target = $_POST['target'];

        if (Validator::url($target)) {
            ValidationException::throw(['target' => 'Invalid URL']);
        }

        $linkId = App::get(ShortLinkRepository::class)->save($target);
        Session::put('target', $target);
        Session::put('link_id', $linkId);

        return redirect('/');
    }

    /**
     * Redirecting short url to the target url
     * @param string $hash
     * @return mixed
     */
    public function redirect(string $hash): mixed
    {
        /** Decoding hash to get short link entity id */
        $linkId = ShortLinkService::decode($hash);

        /** Fetching short link entity by id */
        $link = App::get(ShortLinkRepository::class)->findById($linkId);

        if (! $link) {
            throw new RuntimeException('URL not found.');
        }

        /** Publishing queue to store log for short link */
        $userIp = getIPAddress();
        Queue::make(['user_ip' => $userIp, 'link_id' => $linkId])
            ->push(ShortLinkLogJob::class);

        /** Finally redirecting to the target url */
        http_response_code(302);

        return redirect($link['target_url']);
    }

    /**
     * @return mixed
     */
    private function handleAnotherRequest(): mixed
    {
        Session::flush();

        return redirect('/');
    }
}

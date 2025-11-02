<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Queue\Factory as Queue;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;

class AnalayticsController extends Controller
{
    protected $cache, $queue, $storage, $mail;

    public function __construct(Cache $cache, Queue $queue, Storage $storage, Mailer $mail)
    {
        $this->cache = $cache;
        $this->queue = $queue;
        $this->storage = $storage;
        $this->mail = $mail;
    }

    public function track(Request $request)
    {
        $page = $request->input('page', 'home');

        // 1️ Increment view count (Cached)
        $count = $this->cache->increment("views:$page");

        // 2️Save log (Storage contract)
        $this->storage->disk('local')->append('analytics.log', "$page visited at " . now());

        // 3️ Check milestone
        if ($count % 1000 === 0) {
            // Queue a background job
            $this->queue->push(new \App\Jobs\SendAnalyticsMilestoneMail($page, $count));
        }

        return response()->json([
            'page' => $page,
            'views' => $count,
        ]);
    }
}

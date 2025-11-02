<?php

namespace App\Jobs;

use Illuminate\Contracts\Mail\Mailer;

class SendAnalyticsMilestoneMail
{
    protected $page, $count;

    public function __construct($page, $count)
    {
        $this->page = $page;
        $this->count = $count;
    }

    public function handle(Mailer $mail)
    {
        $mail->raw("🎉 Page {$this->page} hit {$this->count} views!", function ($message) {
            $message->to('admin@example.com')->subject('Analytics Milestone!');
        });
    }
}

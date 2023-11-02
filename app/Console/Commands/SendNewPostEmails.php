<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use App\Mail\NewPostEmail;



class SendNewPostEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-new-post-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $websites = Website::all();

        foreach ($websites as $website) {
            $newPosts = $website->getNewPosts();

            foreach ($newPosts as $post) {
                $subscribers = $website->subscribers;

                foreach ($subscribers as $subscriber) {
                    if (!$subscriber->hasReceivedPost($post)) {
                        Mail::to($subscriber->email)->send(new NewPostEmail($post));

                        $subscriber->markPostAsSent($post, $subscriber);
                    }
                }
            }
        }
    }
}

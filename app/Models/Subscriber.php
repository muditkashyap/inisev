<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = ['email'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }
    public function isSubscribedTo(Website $website)
    {
        // Check if the subscriber has a subscription to the given website.
        return $this->subscriptions->where('website_id', $website->id)->isNotEmpty();
    }

    public function hasReceivedPost($post)
    {
        return $this->postSubscriptions()
            ->where('post_id', $post->id)
            ->whereNotNull('sent_at')
            ->exists();
    }




    public function markPostAsSent($post, $subscriber)
    {
        $this->postSubscriptions()->create([
            'post_id' => $post->id,
            'subscriber_id' => $subscriber->id,
            'sent_at' => now(),
        ]);
    }
    public function postSubscriptions()
    {
        return $this->hasMany(PostSubscription::class);
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    public $timestamps = true;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriptions', 'website_id', 'user_id');
    }



    public function getNewPosts()
    {
        return $this->posts()->whereDoesntHave('postSubscriptions', function ($query) {
            $query->whereNotNull('sent_at');
        })->get();
    }

}

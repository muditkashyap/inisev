<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSubscription extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','subscriber_id','sent_at'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}

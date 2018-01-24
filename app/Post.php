<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['id', 'user_id', 'comment_count', 'text', 'type', 'tag', 'predefined_tag', 'last_period', 'created_at', 'updated_at'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'posts_tags');
    }
}

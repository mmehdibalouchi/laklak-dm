<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title'];

    public function tags()
    {
        return $this->belongsToMany(Post::class, 'posts_tags');
    }

}

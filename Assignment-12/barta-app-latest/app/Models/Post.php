<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['description', 'uuid', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')->latest();
    }

    public function viewCounts()
    {
        return $this->hasMany(ViewCount::class, 'post_id', 'id');
    }

    public function reactCounts()
    {
        return $this->hasMany(React::class, 'post_id', 'id')->where('react_yn', 'Y');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class,'post_like')->withTimestamps();
    }
}

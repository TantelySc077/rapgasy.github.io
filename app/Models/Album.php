<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['artist_name', 'title', 'price', 'cover_image', 'description', 'user_id', 'file_path', 'is_published'];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

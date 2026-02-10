<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['album_id', 'title', 'duration', 'file_path'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}

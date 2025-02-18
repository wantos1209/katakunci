<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VideosearchDetail extends Model
{
    protected $fillable = ['videosearch_id', 'title', 'link', 'snippet', 'imageUrl', 'duration', 'source', 'channel', 'date', 'position'];
    protected $table = 'videosearch_detail';

    public function getDurationAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }
}

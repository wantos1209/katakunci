<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapsearchDetail extends Model
{
    protected $fillable = ['mapsearch_id', 'title', 'address', 'latitude', 'longitude', 'rating', 'ratingCount', 'category', 'phoneNumber', 'website', 'position'];
    protected $table = 'mapsearch_detail';
}

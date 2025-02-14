<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagesearchDetail extends Model
{
    protected $fillable = ['imagesearch_id', 'title', 'imageUrl', 'imageWidth', 'imageHeight', 'thumbnailUrl', 'thumbnailWidth', 'thumbnailHeight', 'source', 'domain', 'link', 'position'];
    protected $table = 'imagesearch_detail';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewssearchDetail extends Model
{
    protected $fillable = ['newssearch_id', 'title', 'link', 'snippet', 'date', 'source', 'imageUrl', 'position'];
    protected $table = 'newssearch_detail';
}

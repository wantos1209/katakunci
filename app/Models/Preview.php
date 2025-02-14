<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preview extends Model
{
    protected $fillable = ['websearch_id', 'title', 'link'];
    protected $table = 'preview';
}

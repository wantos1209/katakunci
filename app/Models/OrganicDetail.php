<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganicDetail extends Model
{
    protected $fillable = ['organic_id', 'title', 'link'];
    protected $table = 'organic_detail';
}

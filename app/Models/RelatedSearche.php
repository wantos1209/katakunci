<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedSearche extends Model
{
    protected $fillable = ['websearch_id', 'keyword_id'];
    protected $table = 'related_searches';
}

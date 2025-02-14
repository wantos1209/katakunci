<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationKeyword extends Model
{
    protected $fillable = ['keyword_id', 'related_id', 'jenis'];
    protected $table = 'relation_keyword';
}

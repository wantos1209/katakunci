<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $fillable = ['key'];
    protected $table = 'keywords';

    public function keywordrelation()
    {
        return $this->belongsToMany(Websearch::class, 'related_searches', 'keyword_id', 'related_id');
    }
}

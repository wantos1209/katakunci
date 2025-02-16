<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedSearch extends Model
{
    protected $fillable = ['websearch_id', 'keyword_id'];
    protected $table = 'related_searches';

    public function keyword()
    {
        return $this->belongsTo(Keyword::class, 'keyword_id');
    }
}

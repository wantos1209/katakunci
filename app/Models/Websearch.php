<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Websearch extends Model
{
    protected $fillable = ['site_id', 'jenis'];
    protected $table = 'websearch';

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function keywordrelation()
    {
        return $this->belongsToMany(Keyword::class, 'relation_keyword', 'related_id', 'keyword_id')
                    ->withPivot('jenis')
                    ->wherePivot('jenis', 1); 
    }

    public function knowledgegraph()
    {
        return $this->hasOne(Knowledgegraph::class, 'websearch_id');
    }

    public function organic()
    {
        return $this->hasMany(Organic::class, 'websearch_id');
    }

    public function preview()
    {
        return $this->hasMany(Preview::class, 'websearch_id');
    }

    public function relatedsearch()
    {
        return $this->hasMany(RelatedSearch::class, 'websearch_id');
    }
}

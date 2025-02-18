<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videosearch extends Model
{
    protected $fillable = ['site_id'];
    protected $table = 'videosearch';

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function keywordrelation()
    {
        return $this->belongsToMany(Keyword::class, 'relation_keyword', 'related_id', 'keyword_id')
                    ->withPivot('jenis')
                    ->wherePivot('jenis', 4); 
    }
}

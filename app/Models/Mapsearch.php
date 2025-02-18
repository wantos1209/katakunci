<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapsearch extends Model
{
    protected $fillable = ['site_id'];
    protected $table = 'mapsearch';

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function keywordrelation()
    {
        return $this->belongsToMany(Keyword::class, 'relation_keyword', 'related_id', 'keyword_id')
                    ->withPivot('jenis')
                    ->wherePivot('jenis', 5); 
    }
}

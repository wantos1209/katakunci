<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organic extends Model
{
    protected $fillable = ['websearch_id', 'title', 'link', 'snippet', 'iconUrl', 'position'];
    protected $table = 'organic';

    public function organicdetail()
    {
        return $this->hasMany(OrganicDetail::class, 'organic_id');
    }
}

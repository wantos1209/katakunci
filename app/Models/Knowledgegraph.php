<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Knowledgegraph extends Model
{
    protected $fillable = ['websearch_id', 'title', 'description', 'website', 'iconUrl', 'logoUrl', 'desktopImageUrl', 'mobileImageUrl', 'livechat', 'whatsapp', 'telegram', 'line', 'facebook', 'instagram', 'twitter', 'youtube', 'aplikasiIos', 'aplikasiAndroid'];
    protected $table = 'knowledgegraph';

    public function shortcut()
    {
        return $this->hasMany(Shortcut::class, 'knowledgegraph_id');
    }
}

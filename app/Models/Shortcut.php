<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
    protected $fillable = ['knowledgegraph_id', 'name'];
    protected $table = 'shortcut';

    public function shortcutdetail()
    {
        return $this->hasMany(ShortcutDetail::class, 'shortcut_id');
    }
}

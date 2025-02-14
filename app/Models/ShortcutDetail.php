<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortcutDetail extends Model
{
    protected $fillable = ['shortcut_id', 'name', 'url'];
    protected $table = 'shortcut_detail';
}

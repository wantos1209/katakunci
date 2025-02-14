<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Websearch extends Model
{
    protected $fillable = ['site_id', 'related_id', 'jenis'];
    protected $table = 'websearch';
}

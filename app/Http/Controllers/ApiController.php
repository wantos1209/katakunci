<?php

namespace App\Http\Controllers;

use App\Models\Websearch;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function searchdata($jenis, $query){
        $data = null;
        if($jenis == 'web') {
            $data = Websearch::with(['site', 'keywordrelation', 'knowledgegraph.shortcut.shortcutdetail', 'organic.organicdetail', 'preview', 'relatedsearch.keyword'])->orderBy('created_at', 'DESC')->get();
        }

        dd($data->toArray());
    }
}

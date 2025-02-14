<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];
        $analyticsData = [];
        $keywords = [];
        $topSitus = [];
        $toprankSitus = [];
        $norankSitus = [];
        return view('dashboard.index', [
            'data' => $data,
            'analyticsData' => $analyticsData,
            'keywords' => $keywords,
            'topSitus' => $topSitus,
            'toprankSitus' => $toprankSitus,
            'norankSitus' => $norankSitus,
        ]);
    }
}

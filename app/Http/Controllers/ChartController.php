<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function showChart()
{
    $data = [
        'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
        'values' => [120, 150, 180, 90, 200],
    ];

    return view('chart', compact('data'));
}
}

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cases.index', [
        'googleMapsApiKey' => env('GOOGLE_MAPS_API_KEY'),
    ]);
});

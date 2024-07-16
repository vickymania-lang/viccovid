<?php


use App\Http\Controllers\WorldometerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/scrape-worldometer', [WorldometerController::class, 'scrape']);

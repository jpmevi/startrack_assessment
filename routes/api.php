<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** ROUTE TO MAKE A SEARCH */
Route::get('search', [SearchController::class, 'search'])->name('search.index');

/** ROUTE TO GET STATS */
Route::get('stats', [StatController::class, 'index'])->name('stats.index');
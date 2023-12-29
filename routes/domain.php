<?php

use App\Models\Domain;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function ($domain) {
    $domain = Domain::where('name', $domain)->firstOrFail();

    return 'Holiing — ' . $domain->name;
});

Route::get('/{slug}', function ($domain, $slug) {
    $domain = Domain::where('name', $domain)->firstOrFail();

    $link = $domain->links()->where('slug', $slug)->firstOrFail();

    return redirect($link->url, 301);
});

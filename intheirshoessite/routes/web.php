<?php
use App\dataset1;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/game', function() {
    return view('EndlessRoller');
});


Route::get('/data', function(){
    $data = App\dataset1::all();
    return json_encode($data);
});


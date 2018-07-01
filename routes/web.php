<?php

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




Route::get('/', 'StaffsController@index');
Route::get('staffs', 'StaffsController@allStaffs');
Route::get('staffs/create', 'StaffsController@create');
Route::post('staffs', 'StaffsController@store');

Route::get('staffs/show/{staff}', 'StaffsController@show');
Route::delete('staffs/{staff}', 'StaffsController@destroy');
Route::get('staffs/edit/{staff}', 'StaffsController@edit');
Route::patch('staffss/{staff}', 'StaffsController@update');
Route::get('/staffs_search', 'StaffsController@staffsSearch');
Route::get('/staff_change_parent', 'StaffsController@staffChangeParent');

Auth::routes();

/*
Route::get('/', function () {
    return view('welcome');
});
*/

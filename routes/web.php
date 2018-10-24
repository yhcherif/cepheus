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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/servers', 'ServersController@index')->name('servers')->middleware('auth');
Route::get('/servers/create', 'ServersController@create')->name('servers.create')->middleware('auth');
Route::post('/servers', 'ServersController@store')->name('servers.store')->middleware('auth');
Route::get('/servers/{server}/sites', 'ServersController@sites')->name('servers.sites');

Route::get('/servers/{server}/vps', 'ProvisioningController@create')->name('provisioning.create');
Route::get('/provisioning/callback', 'ProvisioningController@store')->name('provisioning.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::middleware('auth')->get('/api/servers', 'Api\ServersController@index');
Route::middleware('auth')->get('/api/events', 'Api\ServersController@events');
Route::middleware('auth')->post('/api/servers', 'Api\ServersController@store');

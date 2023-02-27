<?php

use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user()->load('roles');
});

Route::middleware(['auth:sanctum'])->get('/users', function (Request $request) {
    return \App\Models\User::all()->load('roles');
});

Route::middleware(['auth:sanctum'])->get('/roles', function (Request $request) {
    return App\Models\Role::all();
});

Route::middleware(['auth:sanctum'])->get('/roles/{role}', function (Request $request, \App\Models\Role $role) {
    return $role;
});

Route::middleware(['auth:sanctum'])->get('/roles/{role}/users', function (Request $request, \App\Models\Role $role) {
    return $role->users;
});

Route::middleware(['auth:sanctum'])->get('/users/{user}', function (Request $request, \App\Models\User $user) {
    return $user->load('roles');
});

Route::middleware(['auth:sanctum'])->get('/users/{user}/roles', function (Request $request, \App\Models\User $user) {
    return $user->roles;
});

Route::middleware(['auth:sanctum'])->post('/users/{user}/roles', function (Request $request, \App\Models\User $user) {
    $user->roles()->sync($request->input('roles'));
    return $user->load('roles');
});



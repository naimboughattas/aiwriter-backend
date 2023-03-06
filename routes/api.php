<?php

use App\Http\Controllers\Api\AuthController;
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


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user()->load(['roles', 'prompts']);
});

Route::middleware(['auth:sanctum'])->get('/users', function (Request $request) {
    return \App\Models\User::with('roles:name')->get()->toArray();
});

Route::middleware(['auth:sanctum'])->post('/users', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

Route::middleware(['auth:sanctum'])->get('/users/props', function (Request $request) {
    return [
        'options' => [
            'roles' => \App\Models\Role::all()->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            })
        ],
    ];
});

/*
|--------------------------------------------------------------------------
| Role Routes
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Menu Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/menus', function (Request $request) {
    return \App\Models\Menu::with(['tabs', 'tabs.prompts', 'tabs.children', 'tabs.children.prompts'])->where('owner_id', auth()->user()->id)->get()->map(function ($menu) {
        return [
            'id' => $menu->id,
            'title' => $menu->title,
            'tabs' => $menu->tabs->where('parent_id', 0)
        ];
    });
});

Route::middleware(['auth:sanctum'])->get('/menus/{menu}', function (Request $request, \App\Models\Menu $menu) {
    return $menu;
});

Route::middleware(['auth:sanctum'])->get('/menus/{menu}/tabs', function (Request $request, \App\Models\Menu $menu) {
    return $menu->tabs->map(function ($tab) {
        return [
            'id' => $tab->id,
            'parent' => $tab->parent_id,
            'droppable' => ($tab->droppable) ? true : false,
            'text' => $tab->title,
            'data' => [
                'menu_id' => $tab->menu_id,
                'title' => $tab->title,
                'prompts_count' => $tab->prompts->count(),
                'prompts' => $tab->prompts,
                'created_at' => $tab->created_at,
            ]
        ];
    });
});

Route::middleware(['auth:sanctum'])->post('/menus', function (Request $request) {
    $menu = \App\Models\Menu::create([
        'owner_id' => auth()->user()->id,
        'title' => $request->input('title'),
        'icon' => $request->input('icon'),
        'order' => 0,
    ]);
    return $menu;
});

Route::middleware(['auth:sanctum'])->put('/menus/{menu}', function (Request $request, \App\Models\Menu $menu) {
    $menu->update($request->all());
    return $menu;
});

Route::middleware(['auth:sanctum'])->delete('/menus/{menu}', function (Request $request, \App\Models\Menu $menu) {
    $menu->delete();
    return $menu;
});

/*
|--------------------------------------------------------------------------
| Tab Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/tabs', function (Request $request) {
    return \App\Models\Tab::all();
});

Route::middleware(['auth:sanctum'])->get('/tabs/{tab}', function (Request $request, \App\Models\Tab $tab) {
    return $tab->load('prompts');
});

Route::middleware(['auth:sanctum'])->get('/tabs/{tab}/prompts', function (Request $request, \App\Models\Tab $tab) {
    return $tab->prompts;
});

Route::middleware(['auth:sanctum'])->post('/tabs', function (Request $request) {
    $tab = \App\Models\Tab::create($request->all());
    return $tab;
});

Route::middleware(['auth:sanctum'])->put('/tabs/{tab}', function (Request $request, \App\Models\Tab $tab) {
    if ($request->input('prompts')) {
        $tab->prompts()->sync($request->input('prompts'));
    } else {
        $tab->update([
            'menu_id' => $request->input('menu_id'),
            'parent_id' => $request->input('parent_id'),
        ]);
        $tab->recChildrenUpdate($request->input('menu_id'));
        \App\Models\Tab::find($request->input('parent_id'))->prompts()->sync([]);
    }
    return $tab;
});

Route::middleware(['auth:sanctum'])->delete('/tabs/{tab}', function (Request $request, \App\Models\Tab $tab) {
    $tab->delete();
    return $tab;
});

/*
|--------------------------------------------------------------------------
| Prompt Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/prompts', function (Request $request) {
    return \App\Models\Prompt::all();
});

Route::middleware(['auth:sanctum'])->get('/prompts/{prompt}', function (Request $request, \App\Models\Prompt $prompt) {
    return $prompt;
});

Route::middleware(['auth:sanctum'])->get('/prompts/{prompt}/responses', function (Request $request, \App\Models\Prompt $prompt) {
    return $prompt->responses;
});

Route::middleware(['auth:sanctum'])->post('/prompts', function (Request $request) {
    $prompt = \App\Models\Prompt::create([
        'author_id' => auth()->user()->id,
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'icon' => $request->input('icon'),
        'order' => 0,
    ]);
    return $prompt;
});

Route::middleware(['auth:sanctum'])->put('/prompts/{prompt}', function (Request $request, \App\Models\Prompt $prompt) {
    $prompt->update($request->all());
    $prompt->tabs()->sync($request->input('tabs'));
    return $prompt;
});

Route::middleware(['auth:sanctum'])->delete('/prompts/{prompt}', function (Request $request, \App\Models\Prompt $prompt) {
    $prompt->delete();
    return $prompt;
});

/*
|--------------------------------------------------------------------------
| Response Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/responses', function (Request $request) {
    return \App\Models\Response::all();
});

Route::middleware(['auth:sanctum'])->get('/responses/{response}', function (Request $request, \App\Models\Response $response) {
    return $response;
});

<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectsInvitationsController;
use App\Http\Controllers\ProjectTasksController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

//Project::created(function ($project) {
//
//});
//
//Project::updated(function ($project) {
//
//});

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


Route::group(['middleware' => 'auth'], function () {
    Route::resource('projects', ProjectsController::class);

    Route::post('/projects/{project}/tasks', [ProjectTasksController::class, 'store']);
    Route::patch('/projects/{project}/tasks/{task}', [ProjectTasksController::class, 'update']);

    Route::post('/projects/{project}/invitations', [ProjectsInvitationsController::class, 'store']);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});


Auth::routes();

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
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


Route::get('/', [PlayerController::class, 'login'])->name('player.login');
Route::post('/', [PlayerController::class, 'doLogin']);

Route::get('/player/register', [PlayerController::class, 'playerRegister'])->name('player.register');
Route::post('/player/register', [PlayerController::class, 'playerDoRegister']);

Route::get('/maze/session', [PlayerController::class, 'mazeCurrentSession'])->name('maze.session');

Route::get('/maze/room/{id}', [PlayerController::class, 'mazeRoom'])->name('maze.room');
Route::post('/maze/room/{id}', [PlayerController::class, 'doMazeRoom'])->name('maze.do_room');

Route::get('/maze/countdown', [PlayerController::class, 'mazeCountdown'])->name('maze.countdown');

Route::get('/maze/logout', [PlayerController::class, 'mazeLogout'])->name('maze.logout');
Route::post('/maze/logout', [PlayerController::class, 'doMazeLogout'])->name('maze.do_logout');

Route::get('/maze/logout/{hash}', [PlayerController::class, 'mazeLogout'])->name('maze.logout_hash');
Route::post('/maze/logout/{hash}', [PlayerController::class, 'doMazeLogout'])->name('maze.do_logout_hash');

Route::get('/maze/{hash}', [PlayerController::class, 'mazeSession'])->name('maze.index');
Route::get('/maze/{hash}/finish', [PlayerController::class, 'mazeSessionFinish'])->name('maze.finish');



Route::get('/player/leaderboard', [PlayerController::class, 'playerLeaderboard'])->name('player.leaderboard');
Route::post('/player/leaderboard', [PlayerController::class, 'playerLeaderboardAjax'])->name('player.leaderboard_ajax');



Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //Route::get('/dashboard/test', [\App\Http\Controllers\TestController::class, 'test'])->name('dashboard.test');

    Route::get('/dashboard/leader', [DashboardController::class, 'leader'])->name('dashboard.leader');
    Route::post('/dashboard/leader_ajax', [DashboardController::class, 'leaderAjax'])->name('dashboard.leader_ajax');

    Route::get('/dashboard/players', [DashboardController::class, 'players'])->name('dashboard.players');
    Route::post('/dashboard/players_ajax', [DashboardController::class, 'playersAjax'])->name('dashboard.players_ajax');

    Route::get('/dashboard/players_xlsx', [PlayerController::class, 'export'])->name('dashboard.players.export');

    Route::delete('/dashboard/administrator/delete_data', [DashboardController::class, 'deleteAll'])->name('dashboard.administrator.delete_all');


    Route::get('/dashboard/players/register', [PlayerController::class, 'register'])->name('dashboard.player.register');
    Route::post('/dashboard/players/register', [PlayerController::class, 'doRegister']);

    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



    Route::get('dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

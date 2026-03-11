<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VotingController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [VotingController::class, 'index'])->name('home');
    Route::get('/event/{id}', [VotingController::class, 'show'])->name('voting.show');
    Route::post('/event/{id}/vote', [VotingController::class, 'vote'])->name('voting.vote');
    Route::get('/event/{id}/results', [VotingController::class, 'results'])->name('voting.results');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CandidateController,
    DashboardController,
    HomeController,
    UserController,
    VoteController,
    SessionController
};

// Page d’accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Navigation
Route::prefix('nav')->group(function () {
    Route::get('elections', [HomeController::class, 'elections'])->name('elections');
    Route::get('results', [HomeController::class, 'results'])->name('results');
    Route::get('sessionitem/{id}', [HomeController::class, 'sessionitem'])->name('sessionitem');
    Route::get('resultofsession/{id}', [HomeController::class, 'resultofsession'])->name('resultofsession');
});

// Authentification
Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('inscription', [AuthController::class, 'inscription'])->name('inscription');
});

// Vote
Route::prefix('vote')->group(function () {
    Route::get('vote/{session_id}/{candidate_id}/{voting_id}', [VoteController::class, 'vote'])->middleware('auth')->name('vote');
});

// gestion Candidat
Route::prefix('candidate')->name('candidate.')->group(function () {
    Route::get('detail/{candidat_id}', [CandidateController::class, 'detailCandidate'])->name('detail');
    Route::get('edit/{candidat_id}', [CandidateController::class, 'editCandidate'])->name('edit');
    Route::post('update/{candidat_id}', [CandidateController::class, 'updateCandidate'])->name('update');
    Route::delete('delete/{candidat_id}', [CandidateController::class, 'deleteCandidate'])->name('delete');

    Route::post('store', [CandidateController::class, 'store'])->name('store');
    Route::get('show/{candidat_id}', [CandidateController::class, 'show'])->name('show');

    Route::get('voteCount/{candidat_id}', [CandidateController::class, 'voteCount'])->name('voteCount');
    Route::get('percentage/{candidat_id}', [CandidateController::class, 'percentage'])->name('percentage');
    Route::get('totalAllVote', [CandidateController::class, 'totalAllVote'])->name('totalAllVote');
});

// Dashboard admin
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('sessions', [DashboardController::class, 'sessions'])->name('sessions');
    Route::get('users', [DashboardController::class, 'users'])->name('users');
    Route::get('candidates', [DashboardController::class, 'candidates'])->name('candidates');
    Route::get('resultats', [DashboardController::class, 'resultats'])->name('resultats');
    Route::get('resultatSession/{session}', [DashboardController::class, 'resultatSession'])->name('resultatSession');

    // --- Routes pour les sessions ---
    Route::get('addSession', [SessionController::class, 'addSession'])->name('addSession');
    Route::post('store', [SessionController::class,  'store'])->name('storeSession');
    Route::get('detailSession/{session_id}', [SessionController::class, 'detailSession'])->name('detailSession');
    Route::get('editSession/{session_id}', [SessionController::class, 'editSession'])->name('editSession');

    Route::post('updateSession', [SessionController::class, 'updateSession'])->name('updateSession');
    Route::get('deleteSession/{session_id}', [SessionController::class, 'deleteSession'])->name('deleteSession');
});


<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('Candidate.view');
// });
Route::get('/', [App\Http\Controllers\CandidateSearchController::class, 'view']);


Route::get('/search-candidates', [App\Http\Controllers\CandidateSearchController::class, 'searchCandidates'])->name('search.candidates');

Route::get('/candidates/{id}', [App\Http\Controllers\CandidateSearchController::class, 'show'])->name('candidates.show');
Route::get('/candidates/download/{id}', [App\Http\Controllers\CandidateSearchController::class, 'download'])->name('candidates.download');

Route::get('/jobseekers/{id}', [App\Http\Controllers\CandidateSearchController::class, 'show'])->name('jobseekers.show');
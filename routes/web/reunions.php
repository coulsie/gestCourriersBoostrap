<?php
use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Vue calendrier ou liste hebdomadaire
    Route::get('/reunions/hebdo', [MeetingController::class, 'hebdo'])->name('reunions.hebdo');

    // Ressources standards (create, store, etc.)
    Route::resource('reunions', MeetingController::class);
});

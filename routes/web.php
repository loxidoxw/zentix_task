<?php

use Illuminate\Support\Facades\Route;

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

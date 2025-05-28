<?php

use Illuminate\Support\Facades\Route;

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/create', [App\Http\Controllers\ContactController::class, 'create'])->name('contact.create');


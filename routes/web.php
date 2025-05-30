<?php

use Illuminate\Support\Facades\Route;

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/{contact}/edit', [App\Http\Controllers\ContactController::class, 'edit'])->name('contact.edit');
Route::put('/contact/{contact}', [App\Http\Controllers\ContactController::class, 'update'])->name('contact.update');
Route::delete('/contacts/{contact}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contact.destroy');

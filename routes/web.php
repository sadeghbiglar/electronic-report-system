<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'users.index');
Volt::route('/login', 'auth.login')->name('login');
Volt::route('/dashboard', 'users.dashboard')->middleware('auth')->name('dashboard');
// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});
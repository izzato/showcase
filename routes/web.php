<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['password.confirm', 'verified'])->group(function () {
    Route::get('/user/profile-information', function () {
        return view('user.settings');
    })->name('user.settings');
    Route::get('/team/settings', function () {
        return view('team.settings');
    })->name('team.settings');
});

Route::get('/locale/{locale}', function ($locale) {
    if (Symfony\Component\Intl\Locales::exists($locale)) {
        cookie()->queue('locale', $locale);
        session()->put('locale', $locale);
    }

    return redirect()->back();
});

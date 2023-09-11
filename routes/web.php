<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['web','auth'])->group(function () {
    Route::prefix('scm-sample-themes')->group(function () {
        Route::get('/about', [\Scm\PluginSampleTheming\Controllers\SampleThemeController::class, 'about'])
            ->name('scm-sample-themes.about');

        Route::get('/about-frame', [\Scm\PluginSampleTheming\Controllers\SampleThemeController::class, 'about_framed'])
            ->name('scm-sample-themes.about-framed');
    });
});

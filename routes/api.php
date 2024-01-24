<?php

use Illuminate\Support\Facades\Route;
use Taecontrol\MoonGuard\Http\Controllers\ExceptionLogsController;
use Taecontrol\MoonGuard\Http\Controllers\ServerMetricsController;
use Taecontrol\MoonGuard\Repositories\ExceptionLogGroupRepository;

if (ExceptionLogGroupRepository::isEnabled()) {
    Route::post('/exceptions', ExceptionLogsController::class)->name('moonguard.api.exceptions');
}

Route::post('/hardware', ServerMetricsController::class)->name('moonguard.api.hardware');

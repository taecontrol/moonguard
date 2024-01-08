<?php

use Illuminate\Support\Facades\Route;
use Taecontrol\MoonGuard\Http\Controllers\ExceptionLogsController;
use Taecontrol\MoonGuard\Http\Controllers\SystemMetricsController;
use Taecontrol\MoonGuard\Repositories\ExceptionLogGroupRepository;

if (ExceptionLogGroupRepository::isEnabled()) {
    Route::post('/exceptions', ExceptionLogsController::class)->name('moonguard.api.exceptions');
}

Route::post('/hardware', SystemMetricsController::class)->name('moonguard.api.hardware');

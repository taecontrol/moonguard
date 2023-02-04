<?php

use Taecontrol\MoonGuard\Http\Controllers\ExceptionLogsController;
use Taecontrol\MoonGuard\Repositories\ExceptionLogGroupRepository;

if (ExceptionLogGroupRepository::isEnabled()) {
    Route::post('/exceptions', ExceptionLogsController::class)->name('moonguard.api.exceptions');
}

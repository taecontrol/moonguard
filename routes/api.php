<?php

use Taecontrol\Moonguard\Http\Controllers\ExceptionLogsController;
use Taecontrol\Moonguard\Repositories\ExceptionLogGroupRepository;

if (ExceptionLogGroupRepository::isEnabled()) {
    Route::post('/exceptions', ExceptionLogsController::class)->name('moonguard.api.exceptions');
}

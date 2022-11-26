<?php

use Taecontrol\Larastats\Http\Controllers\ExceptionLogsController;
use Taecontrol\Larastats\Repositories\ExceptionLogGroupRepository;

if (ExceptionLogGroupRepository::isEnabled()) {
    Route::post('/exceptions', ExceptionLogsController::class)->name('larastats.api.exceptions');
}

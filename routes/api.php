<?php

use Taecontrol\Larastats\Http\Controllers\ExceptionLogsController;

Route::post('/exceptions', ExceptionLogsController::class)->name('larastats.api.exceptions');

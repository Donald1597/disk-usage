<?php

use Illuminate\Support\Facades\Route;
use Donald1597\DiskUsage\Http\Controllers\DiskUsageController;

Route::get('/disk-usage', [DiskUsageController::class, 'index']);
Route::post('/disk-usage/delete-old-files', [DiskUsageController::class, 'deleteOldFiles'])->name('delete.old.files');

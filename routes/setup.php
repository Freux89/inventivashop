<?php

use App\Http\Controllers\SetupController;

/*
|--------------------------------------------------------------------------
| Install Routes
|--------------------------------------------------------------------------
|
| This route is responsible for handling the installation process
| 
*/

Route::get('/', [SetupController::class, 'init'])->name('installation.init');

Route::get('/checklist', [SetupController::class, 'checklist'])->name('installation.checklist');

Route::get('/database-setup/{error?}', [SetupController::class, 'databaseSetup'])->name('installation.dbSetup');
Route::post('/database-setup', [SetupController::class, 'storeDatabaseSetup'])->name('installation.storeDbSetup');

Route::get('/db-migration', [SetupController::class, 'dbMigration'])->name('installation.migration');
Route::get('/run-db-migration/{demo?}', [SetupController::class, 'runDbMigration'])->name('installation.runMigration');

Route::get('/admin-configuration', [SetupController::class, 'storeAdminForm'])->name('installation.storeAdminForm');
Route::post('/admin-configuration', [SetupController::class, 'storeAdmin'])->name('installation.storeAdmin');

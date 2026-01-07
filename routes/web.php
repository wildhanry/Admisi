<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmissionController;

Route::get('/', function () {
    return redirect()->route('admissions.index');
});

// ADMISSION MODULE ROUTES
Route::prefix('admissions')->name('admissions.')->group(function () {
    // Main routes
    Route::get('/', [AdmissionController::class, 'index'])->name('index');
    Route::get('/create', [AdmissionController::class, 'create'])->name('create');
    Route::post('/', [AdmissionController::class, 'store'])->name('store');
    Route::get('/{registration}', [AdmissionController::class, 'show'])->name('show');
    Route::patch('/{registration}/status', [AdmissionController::class, 'updateStatus'])->name('updateStatus');
    
    // AJAX endpoints
    Route::get('/api/doctors/{polyclinic}', [AdmissionController::class, 'getDoctorsByPolyclinic'])->name('doctors.byPolyclinic');
    Route::post('/api/check-patient', [AdmissionController::class, 'checkPatientByNIK'])->name('checkPatient');
});

<?php

use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// login route
Route::post('/login', [UserController::class, 'login']);
// user/check
Route::get('/user/check', [UserController::class, 'checkUser'])->middleware('auth:sanctum');
// logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
// store
Route::post('/user/store', [UserController::class, 'store']);
// get user
Route::get('/user/{email}', [UserController::class, 'index']);
// update google id
Route::put('/user/googleid/{id}', [UserController::class, 'updateGoogleId']);
// update user
Route::put('/user/{id}', [UserController::class, 'update']);

// Doctor
Route::get('/doctors', [DoctorController::class, 'index'])->middleware('auth:sanctum');
Route::post('/doctors', [DoctorController::class, 'store'])->middleware('auth:sanctum');
Route::put('/doctors/{id}', [DoctorController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->middleware('auth:sanctum');
// get active doctor
Route::get('/doctors/active', [DoctorController::class, 'getActiveDoctor'])->middleware('auth:sanctum');
// get search doctor
Route::get('/doctors/search', [DoctorController::class, 'searchDoctor'])->middleware('auth:sanctum');
// get doctor by clinic
Route::get('/doctors/clinic/{id}', [DoctorController::class, 'getDoctorByClinic'])->middleware('auth:sanctum');
// get doctor by specialist
Route::get('/doctors/specialist/{id}', [DoctorController::class, 'getDoctorBySpecialist'])->middleware('auth:sanctum');

//orders
//store order
Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');

//get order by patient
Route::get('/orders/patient/{patient_id}', [OrderController::class, 'getOrderByPatient'])->middleware('auth:sanctum');

//get order by doctor
Route::get('/orders/doctor/{doctor_id}', [OrderController::class, 'getOrderByDoctor'])->middleware('auth:sanctum');

//get all order
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');

//get order by clinic
Route::get('/orders/clinic/{clinic_id}', [OrderController::class, 'getOrderByClinic'])->middleware('auth:sanctum');

//get clinic summary
Route::get('orders/summary/{clinic_id}', [OrderController::class, 'getSummary'])->middleware('auth:sanctum');

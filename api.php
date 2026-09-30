<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BkashController;

Route::post('/login',[AuthController::class,'login']);
Route::get('/health',fn()=>response()->json(['ok'=>true,'service'=>'MRL Factory API','version'=>'1.0.0']));
Route::match(['get','post'],'/payments/bkash/callback',[BkashController::class,'callback']);

Route::middleware('mrl.auth')->group(function () {
    Route::get('/orders',[OrderController::class,'index']);
    Route::post('/orders',[OrderController::class,'store']);
    Route::delete('/orders/{order}',[OrderController::class,'destroy']);
    Route::get('/employees',[EmployeeController::class,'index']);
    Route::post('/employees',[EmployeeController::class,'store']);
    Route::delete('/employees/{employee}',[EmployeeController::class,'destroy']);
    Route::post('/payments/bkash/create',[BkashController::class,'create']);
    Route::post('/payments/bkash/execute',[BkashController::class,'execute']);
    Route::get('/payments/bkash/status/{paymentId}',[BkashController::class,'status']);
});

<?php

use App\Http\Controllers\Api\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function(){
    Route::post('store',[ClientController::class,'store']);
    Route::get('complaint',[ClientController::class,'complaints']);
    Route::put('complaint/{id}',[ClientController::class,'updateComplaint'])->where('id', '[0-9]+');
    Route::post('complaint/store',[ClientController::class,'storeComplaint']);
});

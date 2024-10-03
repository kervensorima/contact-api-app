<?php

use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




// create the routes to the controller

Route::get('contacts', [ContactController::class, 'index']);


Route::post('contacts', [ContactController::class, 'store']);


Route::put("contacts/{id}", [ContactController::class, 'update']);


Route::delete("contacts/{contact}", [ContactController::class, 'delete']);


Route::get('contacts/{id}',[ContactController::class, 'findById']);



Route::get("contacts/search/contact", [ContactController::class, 'search']);

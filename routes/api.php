<?php

use Illuminate\Support\Facades\Route;


Route::get("/hello", function () {
    return response()->json([
        "message" => "Welcome to the API",
        "status" => "success"
    ]);
});
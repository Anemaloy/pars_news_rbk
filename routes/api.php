<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('/articles', \App\Http\Controllers\Api\ArticlesController::class);

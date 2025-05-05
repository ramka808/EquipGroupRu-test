<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/',[CatalogController::class, 'index'] );
Route::get('category/{categoryId}', [CatalogController::class, 'index'])->name('category');





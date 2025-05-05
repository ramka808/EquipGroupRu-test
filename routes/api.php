<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;

Route::get('/api/products/{categoryId}', [CatalogController::class, 'productsAjax']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;

Route::get('category/{categoryId}/products', [CatalogController::class, 'getProductsByCategoryAjax'])->name('api.category.products');
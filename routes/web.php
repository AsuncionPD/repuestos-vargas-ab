<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CategoryController::class, 'index'])->name('extras.home');
Route::get('/prueba-redisenado', [CategoryController::class, 'redisenado'])->name('extras.home-redisenado');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');


// Página principal de productos (index)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos', [ProductController::class, 'index'])->name('products.home');


// Otras rutas personalizadas

Route::post('/products/{product}/decrease', [ProductController::class, 'decreaseUnits'])->name('products.decrease');



Route::get('/products/category/{id}', [ProductController::class, 'byCategory'])->name('products.byCategory');


Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Rutas protegidas con autenticación
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/auth/dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('users/{user}/edit', [AuthController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AuthController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');

    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/table', [CategoryController::class, 'tableView'])->name('categories.table');

    Route::get('/products/admin/table', [ProductController::class, 'adminTable'])->name('products.adminTable');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/products/reduced-history', [ProductController::class, 'reducedHistory'])->name('products.reduced');

});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');













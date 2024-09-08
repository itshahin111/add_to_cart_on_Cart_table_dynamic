<?php


use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/cart', [CartController::class, 'index'])->name('carts.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('carts.add');
Route::post('/cart/increment/{cart}', [CartController::class, 'increment'])->name('carts.increment');
Route::post('/cart/decrement/{cart}', [CartController::class, 'decrement'])->name('carts.decrement');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('carts.remove');
<?php

use App\Http\Controllers\PortfolioController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/portfolios');
});


Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios');

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');

    Route::post('admin/portfolio/create', [PortfolioController::class, 'store'])->name('portfolio.store');
 
    Route::get('admin/portfolio/{id}', [PortfolioController::class, 'show'])->name('portfolio.show');

    Route::get('admin/portfolio/{id}/delete', [PortfolioController::class, 'destroy'])->name('portfolio.destory');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

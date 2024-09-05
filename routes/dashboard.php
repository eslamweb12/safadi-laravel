<?php 

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\dashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'=>['auth:admin'],
     'as' => 'dashboard.',
     'prefix'=>'admin/dashboard',



],function(){
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/',[dashboardController::class,'index']) 
    ->name('dashboard');
    Route::get('/categories/trash',[CategoriesController::class,'trash'])
    ->name('categories.trash');
    Route::put('categories/{category}/restore',[CategoriesController::class,'restore'])
    ->name('categories.restore');
    Route::delete('categories/{category}/force-delete',[CategoriesController::class,'force-delete'])
    ->name('categories.force-delete');


    Route::resources([
        'products' => ProductsController::class,
        'categories' => CategoriesController::class,
        'roles' => RolesController::class,
     
    ]);

});



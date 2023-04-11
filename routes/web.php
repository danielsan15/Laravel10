<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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




Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
//Administrador
Route::get('/all',[HomeController::class, 'all'])->name('home.all');
Route::get('/admin',[AdminController::class,'index'])
    ->middleware('can:admin.index')
    ->name('admin.index');

Route::namespace('App\Http\Controllers')->prefix('admin')->group(function(){

    Route::resource('articles','ArticleController')
        ->except('show')
        ->names('articles');

        //Categorias
        Route::resource('categories','CategoryController')
        ->except('show')
        ->names('categories');
        //COMENTARIOS
        Route::resource('comments','CommentController')
        ->only('index','destroy')
        ->names('comments');

        //Usuarios
        Route::resource('users','UserController')
        ->except('create','store','show')
        ->names('users');

        //Roles
        Route::resource('roles','RoleController')
        ->except('show')
        ->names('roles');
});
//Route::get('/users', [UserController::class, 'index'])->name('users.index');

//Articulos

//Route::put('/admin/category/update/{id}', [CategoryController::class,'update'] )->name('category.update');

//ver articulos por categoria
Route::get('category/{category}',[CategoryController::class, 'detail'])->name('categories.detail');

//ver articulos
Route::get('article/{article}',[ArticleController::class, 'show'])->name('articles.show');
//Guardar Commentarios
Route::get('/comment',[CommentController::class,'store'])->name('comments.store');
/*
Route::get('/articles',[ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create',[ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles',[ArticleController::class, 'store'])->name('articles.store');

Route::get('/articles/{article}/edit',[ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articles/{article}',[ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{article}',[ArticleController::class, 'destroy'])->name('articles.destroy');
*/

//perfiles
Route::resource('profiles',ProfileController::class)
        ->only('edit','update')
        ->names('profiles');


Auth::routes();

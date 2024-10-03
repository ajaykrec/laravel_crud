<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FileController;

// Route::get('/', function(){
//     return 'Home page';
// })->name('home'); 

Route::resource('/customer',CustomerController::class); 
Route::delete('/file',[FileController::class, 'delete_file'])->name('delete.file');        

//=== link storage folder in public ====
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});




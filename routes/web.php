<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Http\Request;
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

//Common naming practices
//index - show all data
//show - show single data
//create - show form to create new data
//store - store created data
//edit - show form to edit data
//update - update data
//destroy - delete data 


//index
Route::get('/', [ListingController::class, 'index'])->name('index');


//create
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth');


//store listing to db
Route::post('/listing', [ListingController::class, 'store']);

//edit listing
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit']);

//submit Edit to Update
Route::put('/listing/{listing}',[ListingController::class,'update'])->middleware('auth');

//delete listing
Route::delete('/listing/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//manage listings
Route::get('/listing/manage', [ListingController::class, 'manage'])->middleware('auth');

//show(always place at bottom)
Route::get('/listing/{listing}', [ListingController::class, 'show']);

/* User section*/

//show register/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//we actually create an account
Route::post('/users', [UserController::class, 'store']);

//Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//show login form
Route::get('/login', [UserController::class, 'login'])->middleware('guest');

//Log in 
Route::post('/users/auth', [UserController::class,'auth']);


/*
initially route method
Route::get('/', function () {
    return view('listings', [
        'listings' => Listing::all()
    ]);
});


routing method I 1st learnt
Route::get('/listings/{id}', function ($id){
    return view('single', [
        'listing' => Listing::find($id)
    ]);
});

route model binding part 1
Route::get('/listings/{id}', function ($id){

    $listing = Listing::find($id);

    if($listing){
        return view('single', [
            'listing' => $listing
        ]);
    }else{
        abort('404');
    }
});

route model binding part 2
Route::get('/listings/{listing}', function (Listing $listing){

    return view('single', [
        'listing' => $listing
    ]);
});


*/


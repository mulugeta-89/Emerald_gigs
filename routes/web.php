<?php

use App\Models\Listing;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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
// to show all listings
Route::get('/', [ListingController::class, "index"]);
// to show form to create listing
Route::get("/listings/create", [ListingController::class, "create"])->middleware("auth");
//to store the created Listing
Route::post("/listings", [ListingController::class, "store"])->middleware("auth");
//show edit Form
Route::get("/listings/{listing}/edit", [ListingController::class, "edit"])->middleware("auth");
//to update the Listing
Route::put("/listings/{listing}", [ListingController::class, "update"])->middleware("auth");
// to delete the listing
Route::delete("/listings/{listing}", [ListingController::class, "destroy"])->middleware("auth");
//to show a single listing
Route::get("/listing/{listing}", [ListingController::class, "show"]);
// to manage the listing
Route::get("/listings/manage", [ListingController::class, "manage"]);

//for users
//show register page
Route::get("/register", [UserController::class, "create"])->middleware("guest");

//to store the registered user
Route::post("/users", [UserController::class, "store"]);
//to logout user
Route::post("/logout", [UserController::class, "logout"])->middleware("auth");
//to show the login form
Route::get("/login", [UserController::class, "login"])->name("login")->middleware("guest");
//to login the user
Route::post("/users/authenticate", [UserController::class, "authenticate"]);
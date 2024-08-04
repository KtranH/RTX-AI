<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\Mail\SendEmail;
use App\Http\Controllers\User\Account;
use App\Http\Controllers\User\Home;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('generate_image');
});
Route::post('/generate-image', [ImageController::class, 'generateImage']);*/

//Access home page
Route::get('/',[Home::class,'ShowHome'])->name("showhome");

//Access login page
Route::get('/login',[Account::class,'ShowLogin'])->name("showlogin");

//Access sign up page
Route::get('/signup',[Account::class,'ShowSignUp'])->name("showsignup");

//Button login by google
Route::get('/auth2Google',[Account::class,'loginByGoogle'])->name("loginByGoogle");

//Data from Google
Route::get('/callBackGoogle',[Account::class,'callBackGoogle'])->name("callBackGoogle");

//Button logout
Route::get('/logout',[Account::class,'Logout'])->name("logout");

//Active sign up account
Route::post('/signupaccount',[Account::class,'NewAccount'])->name("newaccount");

//Send email
Route::get('/sendemail', [SendEmail::class, 'SendEmail'])->name("sendemail");

//New send email
Route::get('/resendemail', [SendEmail::class, 'ReSendEmail'])->name("resendemail");

//Show auth email
Route::get('/showauthemail', [SendEmail::class, 'ShowAuth'])->name("showauth");

//Show auth email
Route::post('/checkcode', [SendEmail::class, 'CheckCode'])->name("checkcode");

//Login account
Route::post('/loginaccount', [Account::class, 'LoginAccount'])->name("loginaccount");
<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\Mail\SendCodeRestPass;
use App\Http\Controllers\Mail\SendEmail;
use App\Http\Controllers\User\Account;
use App\Http\Controllers\User\Home;
use App\Http\Controllers\Board\Board;
use App\Http\Middleware\ThrottleRequests;
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

//Send code to email to change password
Route::get('/sendcodetoemailtochangepass', [SendCodeRestPass::class, 'SendCodeToEmail'])->name("sendcodetoemail")->middleware(ThrottleRequests::class . ':2,1');

//New send email
Route::get('/resendemail', [SendEmail::class, 'ReSendEmail'])->name("resendemail");

//Show auth email
Route::get('/showauthemail', [SendEmail::class, 'ShowAuth'])->name("showauth");

//Show auth email
Route::post('/checkcode', [SendEmail::class, 'CheckCode'])->name("checkcode");

//Login account
Route::post('/loginaccount', [Account::class, 'LoginAccount'])->name("loginaccount");

//Forget password page
Route::get('/forgetpass', [Account::class, 'ForgetPass'])->name("forgetpass");

//Send email to password
Route::post('/sendemail&changepass', [Account::class, 'SendEmailResetPass'])->name("sendemailresetpass");

//Input code to change password
Route::get('/inputcodetochangepass', [SendCodeRestPass::class, 'InputCodeToChangePass'])->name("inputcodetochangepass");

//Check code to change password
Route::post('/checkcodetochangepass', [SendCodeRestPass::class, 'CheckCodeToChangePass'])->name("checkcodetochangepass");

//Access board page
Route::get('/board', [Board::class, 'ShowBoard'])->name("showboard");

//Change board tab
Route::get('/board/{tab?}', [Board::class, 'ShowBoard'])->name('changeboard');

//Access album creation page
Route::get('/create_album', [Board::class, 'CreateAlbum'])->name("createalbum");

//Access account page
Route::get('/account', [Account::class, 'ShowAccount'])->name("showaccount");
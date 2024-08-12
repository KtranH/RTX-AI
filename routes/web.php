<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\Mail\SendCodeRestPass;
use App\Http\Controllers\Mail\SendEmail;
use App\Http\Controllers\User\Account;
use App\Http\Controllers\User\CreateImage;
use App\Http\Controllers\User\Home;
use App\Http\Controllers\User\WorkFlow\G1;
use App\Http\Controllers\User\WorkFlow\G2;
use App\Http\Controllers\User\WorkFlow\G3;
use App\Http\Middleware\CheckCookieLogin;
use App\Http\Middleware\ThrottleRequests;
use App\Models\WorkFlow;
use App\Http\Controllers\Board\Board;
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
Route::post('/checkcode', [SendEmail::class, 'CheckCode'])->name("checkcode")->middleware(ThrottleRequests::class . ':2,1');;

//Login account
Route::post('/loginaccount', [Account::class, 'LoginAccount'])->name("loginaccount");

//Forget password page
Route::get('/forgetpass', [Account::class, 'ForgetPass'])->name("forgetpass");

//Send email to password
Route::post('/sendemail&changepass', [Account::class, 'SendEmailResetPass'])->name("sendemailresetpass");

//Input code to change password
Route::get('/inputcodetochangepass', [SendCodeRestPass::class, 'InputCodeToChangePass'])->name("inputcodetochangepass");

//Check code to change password
Route::post('/checkcodetochangepass', [SendCodeRestPass::class, 'CheckCodeToChangePass'])->name("checkcodetochangepass")->middleware(ThrottleRequests::class . ':2,1');

//Access board page
Route::get('/board', [Board::class, 'ShowBoard'])->name("showboard");

//Change board tab
Route::get('/board/{tab?}', [Board::class, 'ShowBoard'])->name('changeboard');

//Access album creation page
Route::get('/create_album', [Board::class, 'CreateAlbum'])->name("createalbum");

//Access account page
Route::get('/account', [Account::class, 'ShowAccount'])->name("showaccount");

//Show All Workflow
Route::get('/showallworkflow', [CreateImage::class, 'ShowWorkFlow'])->name("showworkflow");

Route::middleware([CheckCookieLogin::class])->group(function () {
    
//Show G1
Route::get('/g1', [G1::class, 'InputDataG1'])->name("g1");

//Create Image G1
Route::post('/createg1', [G1::class, 'ShowImageG1'])->name("createg1");

//Cancel Image G1
/*Route::get('/cancelg1', [G1::class, 'stopQueue'])->name("cancelg1");*/

//Show Image G1
Route::get('/showg1', [G1::class, 'ImageG1'])->name("showg1");

//Show G2
Route::get('/g2', [G2::class, 'InputDataG2'])->name("g2");

//Create Image G2
Route::post('/createg2', [G2::class, 'ShowImageG2'])->name("createg2");

//Show Image G2
Route::get('/showg2', [G2::class, 'ImageG2'])->name("showg2");

//Show G3
Route::get('/g3', [G3::class, 'InputDataG3'])->name("g3");

//Create Image G3
Route::post('/createg3', [G3::class, 'ShowImageG3'])->name("createg3");

//Show Image G3
Route::get('/showg3', [G3::class, 'ImageG3'])->name("showg3");

//Show G4
Route::get('/g4', [G3::class, 'InputDataG3'])->name("g4");

//Show G5
Route::get('/g5', [G3::class, 'InputDataG3'])->name("g5");

//Show G6
Route::get('/g6', [G3::class, 'InputDataG3'])->name("g6");

//Show G7
Route::get('/g7', [G3::class, 'InputDataG3'])->name("g7");

//Show G8
Route::get('/g8', [G3::class, 'InputDataG3'])->name("g8");

//Show G9
Route::get('/g9', [G3::class, 'InputDataG3'])->name("g9");

//Show G10
Route::get('/g10', [G3::class, 'InputDataG3'])->name("g10");

//Show G11
Route::get('/g11', [G3::class, 'InputDataG3'])->name("g11");

//Show G12
Route::get('/g12', [G3::class, 'InputDataG3'])->name("g12");

//Show G13
Route::get('/g13', [G3::class, 'InputDataG3'])->name("g13");

//Show G14
Route::get('/g14', [G3::class, 'InputDataG3'])->name("g14");

//Show G15
Route::get('/g15', [G3::class, 'InputDataG3'])->name("g15");

//Show G16
Route::get('/g16', [G3::class, 'InputDataG3'])->name("g16");

//Show G17
Route::get('/g17', [G3::class, 'InputDataG3'])->name("g17");

//Show G18
Route::get('/g18', [G3::class, 'InputDataG3'])->name("g18");

//Show G19
Route::get('/g19', [G3::class, 'InputDataG3'])->name("g19");

//Show G20
Route::get('/g20', [G3::class, 'InputDataG3'])->name("g20");
});
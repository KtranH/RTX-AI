<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\Mail\SendCodeRestPass;
use App\Http\Controllers\Mail\SendEmail;
use App\Http\Controllers\User\Account;
use App\Http\Controllers\User\Home;
use App\Http\Controllers\User\WorkFlow\G1;
use App\Http\Controllers\User\WorkFlow\G2;
use App\Http\Controllers\User\WorkFlow\G3;
use App\Http\Middleware\CheckCookieLogin;
use App\Http\Middleware\ThrottleRequests;
use App\Models\WorkFlow;
use App\Http\Controllers\Board\Board;
use App\Http\Controllers\Image\Image;
use App\Http\Controllers\Creativity\Creativity;
use App\Http\Controllers\Explore\Explore;
use App\Http\Controllers\User\WorkFlow\G4;
use App\Http\Middleware\LimitContentUpdate;
use App\Http\Middleware\LimitUpdateAccountAccess;
use App\Http\Middleware\VerifyTurnstileCaptcha;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/ai', function () {
    return view('generate_image');
});
Route::post('/generate-image', [ImageController::class, 'generateImage']);

//Access home page
Route::get('/', [Home::class, 'ShowHome'])->name("showhome");

//Access login page
Route::get('/login', [Account::class, 'ShowLogin'])->name("showlogin")->middleware(VerifyTurnstileCaptcha::class);

//Access sign up page
Route::get('/signup', [Account::class, 'ShowSignUp'])->name("showsignup")->middleware(VerifyTurnstileCaptcha::class);

//Button login by google
Route::get('/auth2Google', [Account::class, 'loginByGoogle'])->name("loginByGoogle");

//Data from Google
Route::get('/callBackGoogle', [Account::class, 'callBackGoogle'])->name("callBackGoogle");

//Button logout
Route::get('/logout', [Account::class, 'Logout'])->name("logout");

//Active sign up account
Route::post('/signupaccount', [Account::class, 'NewAccount'])->name("newaccount");

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
Route::get('/forgetpass', [Account::class, 'ForgetPass'])->name("forgetpass")->middleware(VerifyTurnstileCaptcha::class);

//Send email to password
Route::post('/sendemail&changepass', [Account::class, 'SendEmailResetPass'])->name("sendemailresetpass");

//Input code to change password
Route::get('/inputcodetochangepass', [SendCodeRestPass::class, 'InputCodeToChangePass'])->name("inputcodetochangepass")->middleware(VerifyTurnstileCaptcha::class);

//Check code to change password
Route::post('/checkcodetochangepass', [SendCodeRestPass::class, 'CheckCodeToChangePass'])->name("checkcodetochangepass")->middleware(ThrottleRequests::class . ':2,1');

//Access creativity
Route::get('/creativity', [Creativity::class, 'ShowCreativity'])->name("showcreativity");

//Access explore
Route::get('/explore', [Explore::class, 'ShowExplore'])->name("showexplore");
Route::get('/api/explore', [Explore::class, 'indexApi'])->name("indexApi");

//See more categories
Route::get('/morecategories', [Explore::class, 'MoreCategory'])->name("morecategories");

//Show All Workflow
Route::get('/showallworkflow', [Image::class, 'ShowWorkFlow'])->name("showworkflow");

Route::middleware([CheckCookieLogin::class])->group(function () {

    //Access board page
    Route::get('/board', [Board::class, 'ShowBoard'])->name("showboard");

    //Change board tab
    Route::get('/board/{tab}', [Board::class, 'ShowBoard'])->name('changeboard');
    Route::get('/api/board', [Board::class, 'ShowBoardApi'])->name('ShowBoardApi');

    //Access album page
    Route::get('/album/{id}', [Board::class, 'ShowAlbum'])->name("showalbum");
    Route::get('/api/album/{id}', [Board::class, 'ShowAlbumApi'])->name("ShowAlbumApi");

    //Access album creation page
    Route::get('/create_album', [Board::class, 'CreateAlbum'])->name("createalbum");

    //Access album edit page
    Route::get('/edit_album/{id}', [Board::class, 'EditAlbum'])->name("editalbum");

    //Access account page
    Route::get('/account', [Account::class, 'ShowAccount'])->name("showaccount");

    //Access create image page
    Route::get('/create_image/{id}', [Image::class, 'CreateImage'])->name("createimage");

    //Add new album
    Route::post('/addmorealbum', [Board::class, 'AddAlbum'])->name("addalbum");

    //Update album
    Route::post('/updatealbum/{id}', [Board::class, 'UpdateAlbum'])->name("updatealbum")->middleware(LimitContentUpdate::class);

    //Delete album
    Route::get('/deletealbum/{id}', [Board::class, 'DeleteAlbum'])->name("deletealbum");

    //Add new image to album
    Route::post('/addimage2album/{id}', [Image::class, 'AddImage2Album'])->name("addimage2album");

    //Access image page
    Route::get('/image/{id}', [Image::class, 'ShowImage'])->name("showimage");

    //Update image
    Route::post('/updateimage/{id}', [Image::class, 'UpdateImage'])->name("updateimage")->middleware(LimitContentUpdate::class);

    //Delete image
    Route::get('/deleteimage/{id}', [Image::class, 'DeleteImage'])->name("deleteimage");

    //Like image
    Route::get('/likeimage/{id}', [Image::class, 'LikeImage'])->name("likeimage");

    //Set feature image
    Route::get('/featureimage/{id}', [Board::class, 'FeatureImage'])->name("featureimage");

    //Confirm change password
    Route::get('/confirmpassword', [Account::class, 'ConfirmChangePass'])->name("confirmchangepass");

    //Change passsword
    Route::get('/changepassword', [Account::class, 'ChangePass'])->name("changepass");

    //Access image page
    Route::get('/edit_image/{id}', [Image::class, 'EditImage'])->name("editimage");

    //Update account
    Route::post('/updateaccount', [Account::class, 'UpdateAccount'])->name("updateaccount")->middleware(LimitUpdateAccountAccess::class);

    //Change theme
    Route::post('/save-theme', function (Illuminate\Http\Request $request) {
        $theme = $request->input('theme');
        Session::put('theme', $theme);

        return response()->json(['status' => 'success']);
    });

    //Show G1
    Route::get('/g1', [G1::class, 'InputDataG1'])->name("g1");

    //Create Image G1
    Route::post('/createg1', [G1::class, 'ShowImageG1'])->name("createg1");

    //Cancel Image G1
    /*Route::get('/cancelg1', [G1::class, 'stopQueue'])->name("cancelg1");*/

    //Show result G1
    Route::get('/resultofg1', [G1::class, 'get_imageG1'])->name("get_imageg1");

    //Show G2
    Route::get('/g2', [G2::class, 'InputDataG2'])->name("g2");

    //Create Image G2
    Route::post('/createg2', [G2::class, 'ShowImageG2'])->name("createg2");

    //Show result G2
    Route::get('/resultofg2', [G2::class, 'get_imageG2'])->name("get_imageg2");

    //Show G3
    Route::get('/g3', [G3::class, 'InputDataG3'])->name("g3");

    //Create Image G3
    Route::post('/createg3', [G3::class, 'ShowImageG3'])->name("createg3");

    //Show result G3
    Route::get('/resultofg3', [G3::class, 'get_imageG3'])->name("get_imageg3");

    //Show G4
    Route::get('/g4', [G4::class, 'InputDataG4'])->name("g4");

    //Create Image G4
    Route::post('/createg4', [G4::class, 'ShowImageG4'])->name("createg4");

    //Show result G4
    Route::get('/resultofg4', [G4::class, 'get_imageG4'])->name("get_imageg4");

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

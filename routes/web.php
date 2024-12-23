<?php

use App\Http\Controllers\Admin\Account\Employee;
use App\Http\Controllers\Admin\Account\Information;
use App\Http\Controllers\Admin\Account\Login;
use App\Http\Controllers\Admin\Essential\AdminHome;
use App\Http\Controllers\Admin\Essential\HomeAdmin;
use App\Http\Controllers\Admin\Manage\AdminAI;
use App\Http\Controllers\Admin\Manage\AdminCategory;
use App\Http\Controllers\Admin\Manage\AdminImage;
use App\Http\Controllers\Mail\SendCodeRestPass;
use App\Http\Controllers\Mail\SendEmail;
use App\Http\Controllers\Settings\Settings;
use App\Http\Controllers\User\Account;
use App\Http\Controllers\User\Home;
use App\Http\Controllers\User\WorkFlow\G1;
use App\Http\Controllers\User\WorkFlow\G2;
use App\Http\Controllers\User\WorkFlow\G20;
use App\Http\Controllers\User\WorkFlow\G21;
use App\Http\Controllers\User\WorkFlow\G3;
use App\Http\Controllers\User\WorkFlow\G8;
use App\Http\Middleware\CheckCookieLogin;
use App\Http\Middleware\ThrottleRequests;
use App\Http\Controllers\Board\Board;
use App\Http\Controllers\Image\Image;
use App\Http\Controllers\Creativity\Creativity;
use App\Http\Controllers\Explore\Explore;
use App\Http\Controllers\Payment\Payment;
use App\Http\Controllers\User\WorkFlow\G10;
use App\Http\Controllers\User\WorkFlow\G11;
use App\Http\Controllers\User\WorkFlow\G12;
use App\Http\Controllers\User\WorkFlow\G13;
use App\Http\Controllers\User\WorkFlow\G14;
use App\Http\Controllers\User\WorkFlow\G15;
use App\Http\Controllers\User\WorkFlow\G16;
use App\Http\Controllers\User\WorkFlow\G17;
use App\Http\Controllers\User\WorkFlow\G18;
use App\Http\Controllers\User\WorkFlow\G19;
use App\Http\Controllers\User\WorkFlow\G4;
use App\Http\Controllers\User\WorkFlow\G5;
use App\Http\Controllers\User\WorkFlow\G6;
use App\Http\Controllers\User\WorkFlow\G7;
use App\Http\Controllers\User\WorkFlow\G9;
use App\Http\Middleware\CheckLoginAdmin;
use App\Http\Middleware\CheckRoleAdmin;
use App\Http\Middleware\LimitContentUpdate;
use App\Http\Middleware\LimitReport;
use App\Http\Middleware\LimitUpdateAccountAccess;
use App\Http\Middleware\LimitUpdateAccountAdmin;
use App\Http\Middleware\VerifyTurnstileCaptcha;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//DONT HAVE TO LOGIN FIRST
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//HOME
//-----------------------------------------------------------------------------------------------------------------------------------------------------------

//Access home page
Route::get('/', [Home::class, 'ShowHome'])->name("showhome");

Route::get('/api/get-notification/{userId}', [Home::class, 'ApiNotification']);
Route::get('/api/read-notification/{id}', [Home::class, 'ApiReadNotification']);

//-----------------------------------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------------------------------
//LOGIN, SIGN UP, LOGIN BY GOOGLE, LOGOUT

//Access login page
Route::get('/login', [Account::class, 'ShowLogin'])->name("showlogin")->middleware(VerifyTurnstileCaptcha::class);

//Login account
Route::post('/loginaccount', [Account::class, 'LoginAccount'])->name("loginaccount");

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

//-----------------------------------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------------------------------
//VERIFY EMAIL, FORGET PASSWORD, CHECK CODE TO CHANGE PASSWORD, RESEND EMAIL, CHECK CODE TO VERIFY EMAIL

//Send email
Route::get('/sendemail', [SendEmail::class, 'SendEmail'])->name("sendemail");

//Send code to email to change password
Route::get('/sendcodetoemailtochangepass', [SendCodeRestPass::class, 'SendCodeToEmail'])->name("sendcodetoemail")->middleware(ThrottleRequests::class . ':2,1');

//New send email
Route::get('/resendemail', [SendEmail::class, 'ReSendEmail'])->name("resendemail");

//Show auth email
Route::get('/showauthemail', [SendEmail::class, 'ShowAuth'])->name("showauth");

//Show auth email
Route::post('/checkcode', [SendEmail::class, 'CheckCode'])->name("checkcode")->middleware(ThrottleRequests::class . ':2,1');
;

//Forget password page
Route::get('/forgetpass', [Account::class, 'ForgetPass'])->name("forgetpass")->middleware(VerifyTurnstileCaptcha::class);

//Send email to password
Route::get('/sendemail&changepass', [Account::class, 'SendEmailResetPass'])->name("sendemailresetpass");

//Input code to change password
Route::get('/inputcodetochangepass', [SendCodeRestPass::class, 'InputCodeToChangePass'])->name("inputcodetochangepass")->middleware(VerifyTurnstileCaptcha::class);

//Check code to change password
Route::patch('/checkcodetochangepass', [SendCodeRestPass::class, 'CheckCodeToChangePass'])->name("checkcodetochangepass")->middleware(ThrottleRequests::class . ':2,1');

//-----------------------------------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------------------------------
//EXPLORE, CATEGORIES IMAGE, GENAI

//Access creativity
Route::get('/creativity', [Creativity::class, 'ShowCreativity'])->name("showcreativity");

//Access explore
Route::get('/explore', [Explore::class, 'ShowExplore'])->name("showexplore");
Route::get('/api/explore', [Explore::class, 'indexApi'])->name("indexApi");

//See more categories
Route::get('/morecategories', [Explore::class, 'MoreCategory'])->name("morecategories");

//Show All Workflow
Route::get('/showallworkflow', [Image::class, 'ShowWorkFlow'])->name("showworkflow");

//-----------------------------------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------------------------------------
//HAVE TO LOGIN FIRST
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
Route::middleware([CheckCookieLogin::class])->group(function () {

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //BOARD, FOLLOW USER, UNFOLLOW USER

    //Access board page
    Route::get('/board/{id?}', [Board::class, 'ShowBoard'])->name("showboard");

    //Change board tab
    Route::get('/board/{tab}', [Board::class, 'ShowBoard'])->name('changeboard');
    Route::get('/api/board', [Board::class, 'ShowBoardApi'])->name('ShowBoardApi');
    Route::get('/api/AI_Image/board', [Board::class, 'ShowAiImageApi'])->name('ShowAiImageApi');
    Route::get('/api/Saved_Image/board', [Board::class, 'ShowSavedImageApi'])->name('ShowSavedImageApi');

    //Follow user
    Route::post('/follow', [Board::class, 'FollowUser'])->name("followuser");

    //Unfollow user
    Route::delete('/unfollow', [Board::class, 'UnFollowUser'])->name("unfollowuser");

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //ALBUM, ADD IMAGE TO ALBUM, DELETE ALBUM, UPDATE ALBUM, PRIVATE ALBUM

    //Access album page
    Route::get('/album/{id}', [Board::class, 'ShowAlbum'])->name("showalbum");
    Route::get('/api/album/{id}', [Board::class, 'ShowAlbumApi'])->name("ShowAlbumApi");

    //Access album creation page
    Route::get('/create_album', [Board::class, 'CreateAlbum'])->name("createalbum");

    //Access album edit page
    Route::get('/edit_album/{id}', [Board::class, 'EditAlbum'])->name("editalbum");

    //Add new album
    Route::post('/addmorealbum', [Board::class, 'AddAlbum'])->name("addalbum");

    //Update album
    Route::put('/updatealbum/{id}', [Board::class, 'UpdateAlbum'])->name("updatealbum")->middleware(LimitContentUpdate::class);

    //Delete album
    Route::delete('/deletealbum/{id}', [Board::class, 'DeleteAlbum'])->name("deletealbum");

    //Private album
    Route::post('/privatealbum', [Board::class, 'PrivateAlbum'])->name("privatealbum");

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //IMAGE, ADD IMAGE, UPDATE IMAGE, DELETE IMAGE, SET FEATURE IMAGE, LIKE IMAGE, SAVED IMAGE, SHARE IMAGE

    //Access image page
    Route::get('/image/{id}', [Image::class, 'ShowImage'])->name("showimage");

    //Access create image page
    Route::get('/create_image/{id}', [Image::class, 'CreateImage'])->name("createimage");

    //Add new image to album
    Route::post('/addimage2album/{id}', [Image::class, 'AddImage2Album'])->name("addimage2album");

    //Access edit image page
    Route::get('/edit_image/{id}', [Image::class, 'EditImage'])->name("editimage");

    //Update image
    Route::put('/updateimage/{id}', [Image::class, 'UpdateImage'])->name("updateimage")->middleware(LimitContentUpdate::class);

    //Delete image
    Route::delete('/deleteimage/{id}', [Image::class, 'DeleteImage'])->name("deleteimage");

    //Like image
    Route::post('/likeimage/{id}', [Image::class, 'LikeImage'])->name("likeimage");

    //Set feature image
    Route::post('/featureimage', [Board::class, 'FeatureImage'])->name("featureimage");

    //Saved image
    Route::post('/savedimage', [Image::class, 'SavedImage'])->name("savedimage");

    //Share image
    Route::get('/shareimage/{id}/share', [Image::class, 'ShareImage'])->name("shareimage");

    //Report image
    Route::post('/reportimage', [Image::class, 'ReportImage'])->name("reportimage")->middleware(LimitReport::class);

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //LOAD COMMENT, ADD COMMENT, EDIT COMMENT AND DELETE COMMENT, LOAD REPLY, ADD REPLY, EDIT REPLY AND DELETE REPLY, DELETE COMMENT AND REPLY BY OWNER

    //Add comment
    Route::post('/addcomment/{idImage}', [Image::class, 'AddCommentInImage'])->name("addcomment");

    //Load more comment
    Route::get('/loadmorecomment/{idImage}', [Image::class, 'ShowCommentAPI'])->name("loadmorecomment");

    //Delete comment
    Route::delete('/deletecomment/{id}', [Image::class, 'DeleteComment'])->name("deletecomment");

    //Edit comment
    Route::patch('/updatecomment/{id}', [Image::class, 'UpdateComment'])->name("updatecomment");

    //Reply comment
    Route::post('/api/comments/{parentId}/replies', [Image::class, 'ReplyComment'])->name("replycomment");

    //Load more replies
    Route::get('/api/getcomments/{commentId}/replies', [Image::class, 'getReplies'])->name("getreplies");

    //Delete reply
    Route::delete('/api/deletereply/{id}', [Image::class, 'DeleteReply'])->name("deletereply");

    //Update reply
    Route::patch('/api/updatereply/{id}', [Image::class, 'UpdateReply'])->name("updatereply");

    //Reply reply
    Route::post('/api/reply/{parentId}/replies', [Image::class, 'ReplyReply'])->name("replyreply");

    //Delelet comment by owner
    Route::delete('/api/deletecomment/owner', [Image::class, 'DeleteCommentByOwner'])->name("deletecommentbyowner");

    //Delete reply by owner
    Route::delete('/api/deletereplycomment/owner', [Image::class, 'DeleteReplyByOwner'])->name("deletereplybyowner");

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //ACCOUNT, CHANGE PASSWORD, UPDATE ACCOUNT

    //Access account page
    Route::get('/account', [Account::class, 'ShowAccount'])->name("showaccount");

    //Confirm change password
    Route::get('/confirmpassword', [Account::class, 'ConfirmChangePass'])->name("confirmchangepass");

    //Change passsword
    Route::get('/changepassword', [Account::class, 'ChangePass'])->name("changepass");

    //Update account
    Route::put('/updateaccount', [Account::class, 'UpdateAccount'])->name("updateaccount")->middleware(LimitUpdateAccountAccess::class);

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //THEME

    //Change theme
    Route::post('/save-theme', function (Illuminate\Http\Request $request) {
        $theme = $request->input('theme');
        Session::put('theme', $theme);

        return response()->json(['status' => 'success']);
    });

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //PAYMENT, PRICING

    //Access Payment
    Route::get('/payment/{price}', [Payment::class, 'ShowPayment'])->name("showpayment");

    //Access Pricing
    Route::get('/pricing', function () {
        return view('User.Payment.Pricing');
    })->name('showpricing');

    //Payment Success
    Route::patch('/payment/success', [Payment::class, 'ShowPaymentSuccess'])->name("showpaymentsuccess");

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //SETTINGS

    //Access Settings
    Route::get('/settings', [Settings::class, 'Index'])->name("showsettings");
    Route::get('/api/settings/liked', [Settings::class, 'apiDataLiked'])->name("apiDataLiked");
    Route::get('/api/settings/album', [Settings::class, 'apiDataAlbum'])->name("apiDataAlbum");
    Route::get('/api/settings/follow', [Settings::class, 'apiDataFollow'])->name("apiDataFollow");

    //Change Settings Tab
    Route::get('/settings/{tab}', [Settings::class, 'ShowSettings'])->name('changesettings');

    //Update Preferences
    Route::post('/updatepreferences', [Settings::class, 'StorePreferences'])->name("updatepreferences");

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //WORKFLOW

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
    Route::get('/g5', [G5::class, 'InputDataG5'])->name("g5");

    //Create image G5
    Route::post('/createg5', [G5::class, 'ShowImageG5'])->name("createg5");

    //Show result G5
    Route::get('/resultofg5', [G5::class, 'get_imageG5'])->name("get_imageg5");

    //Show G6
    Route::get('/g6', [G6::class, 'InputDataG6'])->name("g6");

    //Create imamge G6
    Route::post('/createg6', [G6::class, 'ShowImageG6'])->name("createg6");

    //Show result G6
    Route::get('/resultofg6', [G6::class, 'get_imageG6'])->name("get_imageg6");

    //Show G7
    Route::get('/g7', [G7::class, 'InputDataG7'])->name("g7");

    //Create image G7
    Route::post('/createg7', [G7::class, 'ShowImageG7'])->name("createg7");

    //Show result G7
    Route::get('/resultofg7', [G7::class, 'get_imageG7'])->name("get_imageg7");

    //Show G8
    Route::get('/g8', [G8::class, 'InputDataG8'])->name("g8");

    //Create image G8
    Route::post('/createg8', [G8::class, 'ShowImageG8'])->name("createg8");

    //Show result G8
    Route::get('/resultofg8', [G8::class, 'get_imageG8'])->name("get_imageg8");

    //Show G9
    Route::get('/g9', [G9::class, 'InputDataG9'])->name("g9");

    //Create image G9
    Route::post('/createg9', [G9::class, 'ShowImageG9'])->name("createg9");

    //Show result G9
    Route::get('/resultofg9', [G9::class, 'get_imageG9'])->name("get_imageg9");

    //Show G10
    Route::get('/g10', [G10::class, 'InputDataG10'])->name("g10");

    //Create image G10
    Route::post('/createg10', [G10::class, 'ShowImageG10'])->name("createg10");

    //Show result G10
    Route::get('/resultofg10', [G10::class, 'get_imageG10'])->name("get_imageg10");

    //Show G11
    Route::get('/g11', [G11::class, 'InputDataG11'])->name("g11");

    //Create image G11
    Route::post('/createg11', [G11::class, 'ShowImageG11'])->name("createg11");

    //Show result G11
    Route::get('/resultofg11', [G11::class, 'get_imageG11'])->name("get_imageg11");

    //Show G12
    Route::get('/g12', [G12::class, 'InputDataG12'])->name("g12");

    //Show G13
    Route::get('/g13', [G13::class, 'InputDataG13'])->name("g13");

    //Create image G13
    Route::post('/createg13', [G13::class, 'ShowImageG13'])->name("createg13");

    //Show result G13
    Route::get('/resultofg13', [G13::class, 'get_imageG13'])->name("get_imageg13");

    //Show G14
    Route::get('/g14', [G14::class, 'InputDataG14'])->name("g14");

    //Create image G14
    Route::post('/createg14', [G14::class, 'ShowImageG14'])->name("createg14");

    //Show result G14
    Route::get('/resultofg14', [G14::class, 'get_imageG14'])->name("get_imageg14");

    //Show G15
    Route::get('/g15', [G15::class, 'InputDataG15'])->name("g15");

    //Show G16
    Route::get('/g16', [G16::class, 'InputDataG16'])->name("g16");

    //Create image G16
    Route::post('/createg16', [G16::class, 'ShowImageG16'])->name("createg16");

    //Show result G16
    Route::get('/resultofg16', [G16::class, 'get_imageG16'])->name("get_imageg16");

    //Show G17
    Route::get('/g17', [G17::class, 'InputDataG17'])->name("g17");

    //Create image G17
    Route::post('/createg17', [G17::class, 'ShowImageG17'])->name("createg17");

    //Show result G17
    Route::get('/resultofg17', [G17::class, 'get_imageG17'])->name("get_imageg17");

    //Show G18
    Route::get('/g18', [G18::class, 'InputDataG18'])->name("g18");

    //Create image G18
    Route::post('/createg18', [G18::class, 'ShowImageG18'])->name("createg18");

    //Show result G18
    Route::get('/resultofg18', [G18::class, 'get_imageG18'])->name("get_imageg18");

    //Show G19
    Route::get('/g19', [G19::class, 'InputDataG19'])->name("g19");

    //Create image G19
    Route::post('/createg19', [G19::class, 'ShowImageG19'])->name("createg19");

    //Show result G19
    Route::get('/resultofg19', [G19::class, 'get_imageG19'])->name("get_imageg19");

    //Show G20
    Route::get('/g20', [G20::class, 'InputDataG20'])->name("g20");

    //Create image G20
    Route::post('/createg20', [G20::class, 'ShowImageG20'])->name("createg20");

    //Show result G20
    Route::get('/resultofg20', [G20::class, 'get_imageG20'])->name("get_imageg20");

    //Show G21
    Route::get('/g21', [G21::class, 'InputDataG21'])->name("g21");

    //Create image G21
    Route::post('/createg21', [G21::class, 'ShowImageG21'])->name("createg21");

    //Show result G21
    Route::get('/resultofg21', [G21::class, 'get_imageG21'])->name("get_imageg21");
});
//-----------------------------------------------------------------------------------------------------------------------------------------------------------
//ADMIN
//-----------------------------------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------------------------------
//LOGIN, LOGOUT

//Form Login Admin
Route::get('/admin/login', [Login::class, 'ShowLogin'])->name('admin.login');

//Login Admin
Route::post('/admin/login', [Login::class, 'Login'])->name('admin.login.account');

//Logout Admin
Route::get('/admin/logout', [Login::class, 'Logout'])->name('admin.logout');

//---------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::group(['middleware' => [CheckLoginAdmin::class]], function () {
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //HOME

    //Home Admin
    Route::get('/admin', [AdminHome::class, 'ShowHome'])->name('admin');

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //CATEGORY, ADD CATEGORY, UPDATE CATEGORY, DELETE CATEGORY, SEARCH CATEGORY, LOCK CATEGORY, UNLOCK CATEGORY

    //Manage Category
    Route::get('/admin/category', [AdminCategory::class, 'ShowCategory'])->name('admin.category');

    //Add Category
    Route::post('/admin/addcategory', [AdminCategory::class, 'AddCategory'])->name('admin.addcategory');

    //Delete Category
    Route::delete('/admin/deletecategory', [AdminCategory::class, 'DeleteCategory'])->name('admin.deletecategory');

    //Search Category
    Route::get('/admin/searchcategory', [AdminCategory::class, 'SearchCategory'])->name('admin.searchcategory');

    //Update Category
    Route::put('/admin/updatecategory', [AdminCategory::class, 'UpdateCategory'])->name('admin.updatecategory');

    //Lock Category
    Route::put('/admin/lockcategory', [AdminCategory::class, 'LockCategory'])->name('admin.lockcategory');

    //Unlock Category
    Route::put('/admin/unlockcategory', [AdminCategory::class, 'UnlockCategory'])->name('admin.unlockcategory');

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //IMAGE, ACCEPT IMAGE, REJECT IMAGE, AI IMAGE, DELETE AI IMAGE

    //Manage Image
    Route::get('/admin/image', [AdminImage::class, 'ShowImage'])->name('admin.image');

    //Review Image
    Route::get('/api/admin/image', [AdminImage::class, 'ImageAPI'])->name('admin.image.api');

    //Accept Image
    Route::get('/api/admin/acceptimage', [AdminImage::class, 'imageAcceptAPI'])->name('admin.acceptimage');

    //Reject Image
    Route::get('/api/admin/rejectimage', [AdminImage::class, 'imageRejectAPI'])->name('admin.rejectimage');

    //Approved Report
    Route::put('/admin/approvedreport', [AdminImage::class, 'ApprovedReport'])->name('admin.approvedreport');

    //Reject Report
    Route::put('/admin/rejectreport', [AdminImage::class, 'RejectReport'])->name('admin.rejectreport');

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //ACOUNT ADMIN, INFORMATION, EMPLOYEE, UPDATE INFORMATION, UPDATE PASSWORD, UPDATE AVATAR, DELETE EMPLOYEE, ACTIVE EMPLOYEE, INSERT EMPLOYEE, UPDATE EMPLOYEE

    //Account Information
    Route::get('/admin/information', [Information::class, 'ShowInformation'])->name('admin.information');

    //Update Information
    Route::put('/admin/updateinformation', [Information::class, 'UpdateInformation'])->name('admin.updateinformation')->middleware(LimitUpdateAccountAdmin::class);

    //Update Password
    Route::put('/admin/updatepassword', [Information::class, 'UpdatePassword'])->name('admin.updatepassword')->middleware(LimitUpdateAccountAdmin::class);

    //Update Avatar
    Route::post('/admin/updateavatar', [Information::class, 'UpdateAvatar'])->name('admin.updateavatar');

    //Account Employee
    Route::get('/admin/employee', [Employee::class, 'ShowEmployee'])->name('admin.employee')->middleware(CheckRoleAdmin::class);

    //Search Employee
    Route::get('/admin/searchemployee', [Employee::class, 'SearchEmployee'])->name('admin.searchemployee');

    //Deleted Employee
    Route::put('/admin/deleteemployee', [Employee::class, 'DeletedEmployee'])->name('admin.deleteemployee');
    
    //Active Employee
    Route::put('/admin/activeemployee', [Employee::class, 'ActiveEmployee'])->name('admin.activeemployee');

    //Insert Employee
    Route::post('/admin/insertemployee', [Employee::class, 'InsertEmployee'])->name('admin.insertemployee');

    //Update Employee
    Route::put('/admin/updateemployee', [Employee::class, 'UpdateEmployee'])->name('admin.updateemployee');
    
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
    //AI IMAGE
    
    // Manage AI
    Route::get('/admin/ai', [AdminAI::class, 'ShowAI'])->name('admin.ai');

    //Image AI
    Route::get('/api/admin/imageai', [AdminAI::class, 'ImageAI'])->name('admin.imageai');
    
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------
});

//---------------------------------------------------------------------------------------------------------------------------------------------------------------

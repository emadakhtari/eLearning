<?php

use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
//    Login Process
    Route::post('CheckPassword', 'UsersAuthenticateManager@CheckPassword')->name('CheckPassword');
    Route::post('UsersLogin', 'UsersAuthenticateManager@UsersLogin')->name('UsersLogin');
    Route::get('UsersLogout', 'UsersAuthenticateManager@UsersLogout')->name('UsersLogout');
    Route::get('UsersLogin', 'UsersAuthenticateManager@UsersLoginView')->name('UsersLoginView');

//    Ajax
    Route::get('Ajax_GetUserCategoryPermission', 'AjaxHandler@GetUserCategoryPermission');


//    View
    Route::get('EditUsers/{id}', 'UsersManager@EditUsersView')->name('Users.Edit.View');
    Route::post('EditUsers/{id}', 'UsersManager@EditUsers')->name('Users.Edit');
});


//These Routes Use When User Not Logged In
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
//    Views(Get) Routes
    Route::get('AddUsers', 'UsersManager@AddUsersView')->name('Users.Add.View');
//    Create&Others (Post) Routes
    Route::post('AddUsers', 'UsersManager@AddUsers')->name('Users.Add');

    Route::post('sendCode', 'UsersManager@sendCode')->name('Users.sendCode');
    Route::post('checkCode', 'UsersManager@checkCode')->name('Users.checkCode');

});

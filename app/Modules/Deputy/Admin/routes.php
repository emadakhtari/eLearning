<?php

use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
//    Login Process
    Route::post('DeputyCheckPassword', 'DeputyAuthenticateManager@CheckPassword')->name('DeputyCheckPassword');
    Route::post('DeputyLogin', 'DeputyAuthenticateManager@DeputyLogin')->name('DeputyLogin');
    Route::get('DeputyLogout', 'DeputyAuthenticateManager@DeputyLogout')->name('DeputyLogout');
    Route::get('DeputyLogin', 'DeputyAuthenticateManager@DeputyLoginView')->name('DeputyLoginView');

    Route::get('EditDeputy/{id}', 'DeputyManager@EditDeputyView')->name('Deputy.Edit.View');
    Route::post('EditDeputy/{id}', 'DeputyManager@EditDeputy')->name('Deputy.Edit');

    Route::post('sendCodeDeputy', 'DeputyManager@sendCode')->name('Deputy.sendCode');
    Route::post('checkCodeDeputy', 'DeputyManager@checkCode')->name('Deputy.checkCode');
});


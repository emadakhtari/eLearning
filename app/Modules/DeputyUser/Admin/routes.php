<?php

use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
//    Login Process
    Route::get('AddDeputyUser', 'DeputyUserManager@AddDeputyUserView')->name('DeputyUser.Add.View');
    Route::post('AddDeputyUser', 'DeputyUserManager@AddDeputyUser')->name('DeputyUser.Add');

    Route::get('EditDeputyUser/{id}', 'DeputyUserManager@EditDeputyUserView')->name('DeputyUser.Edit.View');
    Route::post('EditDeputyUser/{id}', 'DeputyUserManager@EditDeputyUser')->name('DeputyUser.Edit');

    Route::post('Table', 'DeputyUserManager@Table')->name('DeputyUser.Table');

});


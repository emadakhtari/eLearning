<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\SchoolList\Admin\Controllers\SchoolListManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('List', 'SchoolListManager@ListView')->name('SchoolList.List.View');
    Route::get('Ajax_GetList', 'AjaxHandler@ListView')->name('SchoolList.List.Ajax');

    Route::get('Edit/{id}', 'SchoolListManager@EditView')->name('SchoolList.Edit.View');
    Route::post('Edit/{id}', 'SchoolListManager@Edit')->name('SchoolList.Edit');

    Route::post('SchoolListsendCode', 'SchoolListManager@sendCode')->name('SchoolList.sendCode');
    Route::post('SchoolListcheckCode', 'SchoolListManager@checkCode')->name('SchoolList.checkCode');
    Route::post('SchoolListcheckBase', 'SchoolListManager@checkBase')->name('SchoolList.checkBase');
});

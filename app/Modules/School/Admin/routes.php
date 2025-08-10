<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\School\Admin\Controllers\SchoolManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Add', 'SchoolManager@AddView')->name('School.Add.View');
    //Create(Post) Routes
    Route::post('Add', 'SchoolManager@Add')->name('School.Add');

    Route::post('provinceSelect', 'SchoolManager@provinceSelect')->name('School.provinceSelect');
    Route::post('SchoolBaseSelect', 'SchoolManager@BaseSelect')->name('School.BaseSelect');

    Route::post('assign', 'SchoolManager@assign')->name('School.assign');
    Route::post('ForceAssign', 'SchoolManager@ForceAssign')->name('School.ForceAssign');
    Route::post('assign2', 'SchoolManager@assign2')->name('School.assign2');
    Route::post('sendCode', 'SchoolManager@sendCode')->name('School.sendCode');
    Route::post('checkCode', 'SchoolManager@checkCode')->name('School.checkCode');
});

<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\ClassRoomSt\Admin\Controllers\ClassRoomStManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Show/{id}', 'ClassRoomStManager@ShowView')->name('ClassRoomSt.Show.View');
    Route::post('ClassRoomStCreate', 'ClassRoomStManager@ClassRoomStCreate')->name('ClassRoomSt.create');
    Route::post('ClassRoomStStart', 'ClassRoomStManager@ClassRoomStStart')->name('ClassRoomSt.start');
    Route::post('ClassRoomStJoin', 'ClassRoomStManager@ClassRoomStJoin')->name('ClassRoomSt.join');

});

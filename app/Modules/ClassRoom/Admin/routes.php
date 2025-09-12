<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\ClassRoom\Admin\Controllers\ClassRoomManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Show/{id}', 'ClassRoomManager@ShowView')->name('ClassRoom.Show.View');
    Route::post('ClassRoomCreate', 'ClassRoomManager@ClassRoomCreate')->name('ClassRoom.create');
    Route::post('ClassRoomStart', 'ClassRoomManager@ClassRoomStart')->name('ClassRoom.start');
    Route::post('ClassRoomEnd', 'ClassRoomManager@ClassRoomEnd')->name('ClassRoom.end');
    Route::post('DelayHaste', 'ClassRoomManager@DelayHaste')->name('ClassRoom.DelayHaste');

});

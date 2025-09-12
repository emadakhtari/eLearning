<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\Setting\Admin\Controllers\SettingManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {

    Route::get('Edit/{id}', 'SettingManager@EditView')->name('Setting.Edit.View');
    Route::post('Edit/{id}', 'SettingManager@Edit')->name('Setting.Edit');

});

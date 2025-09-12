<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\ClassAssign\Admin\Controllers\ClassAssignManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Add', 'ClassAssignManager@AddView')->name('ClassAssign.Add.View');
    //Create(Post) Routes
    Route::post('Add', 'ClassAssignManager@Add')->name('ClassAssign.Add');
    Route::post('ClassAssignTable', 'ClassAssignManager@Table')->name('ClassAssign.Table');

    Route::get('Edit/{id}', 'ClassAssignManager@EditView')->name('ClassAssign.Edit.View');
    Route::post('Edit/{id}', 'ClassAssignManager@Edit')->name('ClassAssign.Edit');
});

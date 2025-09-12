<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\Grade\Admin\Controllers\GradeManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Add', 'GradeManager@AddView')->name('Grade.Add.View');
    Route::get('Edit/{id}', 'GradeManager@EditView')->name('Grade.Edit.View');
    //Create(Post) Routes
    Route::post('Add', 'GradeManager@Add')->name('Grade.Add');
    Route::post('Edit/{id}', 'GradeManager@Edit')->name('Grade.Edit');



});

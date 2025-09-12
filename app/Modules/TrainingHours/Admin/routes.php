<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\TrainingHours\Admin\Controllers\TrainingHoursManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {

    Route::get('Add', 'TrainingHoursManager@AddView')->name('TrainingHours.Add.View');
    Route::post('Add', 'TrainingHoursManager@Add')->name('TrainingHours.Add');

    Route::get('Edit/{id}', 'TrainingHoursManager@EditView')->name('TrainingHours.Edit.View');
    Route::post('Edit/{id}', 'TrainingHoursManager@Edit')->name('TrainingHours.Edit');

    Route::post('TrainingHoursTable', 'TrainingHoursManager@Table')->name('TrainingHours.Table');

});

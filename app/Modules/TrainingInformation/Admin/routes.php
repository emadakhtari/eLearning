<?php


use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    Route::get('Add', 'TrainingInformationManager@AddView')->name('TrainingInformation.Add.View');
    Route::post('Ajax_AddTrain', 'TrainingInformationManager@AddTrain')->name('TrainingInformation.AddTrain');

    Route::post('TrainingInformationTable', 'TrainingInformationManager@Table')->name('TrainingInformation.Table');
    Route::post('TrainingInformationDelete', 'TrainingInformationManager@Delete')->name('TrainingInformation.Delete');
});

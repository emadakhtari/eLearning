<?php


use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    Route::get('Add', 'GeneralInformationManager@AddView')->name('GeneralInformation.Add.View');
    Route::post('Add', 'GeneralInformationManager@Add')->name('GeneralInformation.Add');

    Route::post('GeneralInformationClassList', 'GeneralInformationManager@ClassList')->name('GeneralInformation.ClassList');
    Route::post('GeneralInformationLessonList', 'GeneralInformationManager@LessonList')->name('GeneralInformation.LessonList');

    Route::post('GeneralInformationTable', 'GeneralInformationManager@Table')->name('GeneralInformation.Table');
    Route::post('GeneralInformationDelete', 'GeneralInformationManager@Delete')->name('GeneralInformation.Delete');
});

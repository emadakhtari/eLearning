<?php


use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    Route::get('Add', 'HomeworkUploadManager@AddView')->name('HomeworkUpload.Add.View');
    Route::post('Ajax_AddTrain', 'HomeworkUploadManager@AddTrain')->name('HomeworkUpload.AddTrain');

    Route::post('HomeworkUploadTable', 'HomeworkUploadManager@Table')->name('HomeworkUpload.Table');
    Route::post('HomeworkUploadDelete', 'HomeworkUploadManager@Delete')->name('HomeworkUpload.Delete');
});

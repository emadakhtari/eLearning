<?php

use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {

    Route::get('List', 'HomeworksManager@ListView')->name('Homeworks.List.View');
    Route::get('Ajax_GetList_Homework', 'HomeworksManager@ListViewAjax')->name('Homeworks.List.Ajax');

    Route::get('Edit/{id}', 'HomeworksManager@EditView')->name('Homeworks.Edit.View');
    Route::post('Edit/{id}', 'HomeworksManager@Edit')->name('Homeworks.Edit');

    Route::post('classList', 'HomeworksManager@classList')->name('Homeworks.classList');
    Route::post('lessonList', 'HomeworksManager@lessonList')->name('Homeworks.lessonList');
});

<?php


use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    Route::get('Add', 'TeacherAssignManager@AddView')->name('TeacherAssign.Add.View');
    Route::post('Add', 'TeacherAssignManager@Add')->name('TeacherAssign.Add');

    Route::post('TeacherAssigninfo', 'TeacherAssignManager@info')->name('TeacherAssign.info');
    Route::post('TeacherAssignlesson', 'TeacherAssignManager@lesson')->name('TeacherAssign.lesson');
    Route::post('TeacherAssignclass', 'TeacherAssignManager@class')->name('TeacherAssign.class');
    Route::post('TeacherAssignTable', 'TeacherAssignManager@Table')->name('TeacherAssign.Table');

    Route::post('TeacherAssignDelete', 'TeacherAssignManager@Delete')->name('TeacherAssign.Delete');
});

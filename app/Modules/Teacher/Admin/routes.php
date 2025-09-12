<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\Teacher\Admin\Controllers\TeacherManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    
    //Views(Get) Routes
    Route::get('Add', 'TeacherManager@AddView')->name('Teacher.Add.View');
    Route::get('Edit/{id}', 'TeacherManager@EditView')->name('Teacher.Edit.View');
    //Create(Post) Routes
    Route::post('Add', 'TeacherManager@Add')->name('Teacher.Add');
    Route::post('Edit/{id}', 'TeacherManager@Edit')->name('Teacher.Edit');

    Route::post('Table', 'TeacherManager@Table')->name('Teacher.Table');


    Route::post('TeacherCheckPassword', 'TeacherAuthenticateManager@CheckPassword')->name('TeacherCheckPassword');
    Route::post('TeacherLogin', 'TeacherAuthenticateManager@TeacherLogin')->name('TeacherLogin');
    Route::get('TeacherLogout', 'TeacherAuthenticateManager@TeacherLogout')->name('TeacherLogout');
    Route::get('TeacherLogin', 'TeacherAuthenticateManager@TeacherLoginView')->name('TeacherLoginView');
});

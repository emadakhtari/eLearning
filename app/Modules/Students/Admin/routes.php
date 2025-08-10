<?php


use App\Http\Controllers\CoreCommon;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Add', 'StudentsManager@AddView')->name('Students.Add.View');
    Route::get('Edit/{id}', 'StudentsManager@EditView')->name('Students.Edit.View');
    //Create(Post) Routes
    Route::post('Add', 'StudentsManager@Add')->name('Students.Add');
    Route::post('Edit/{id}', 'StudentsManager@Edit')->name('Students.Edit');

    Route::post('DeleteImage', 'StudentsManager@DeleteImage')->name('StudentsManager.DeleteImage');

    Route::post('StudentsClassList', 'StudentsManager@ClassList')->name('Students.ClassList');
    Route::post('StudentsTable', 'StudentsManager@Table')->name('Students.Table');

    Route::post('StudentsCheckPassword', 'StudentsAuthenticateManager@CheckPassword')->name('StudentsCheckPassword');
    Route::post('StudentsLogin', 'StudentsAuthenticateManager@StudentsLogin')->name('StudentsLogin');
    Route::get('StudentsLogout', 'StudentsAuthenticateManager@StudentsLogout')->name('StudentsLogout');
    Route::get('StudentsLogin', 'StudentsAuthenticateManager@StudentsLoginView')->name('StudentsLoginView');
});

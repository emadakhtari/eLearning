<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\Lesson\Admin\Controllers\LessonManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Add', 'LessonManager@AddView')->name('Lesson.Add.View');
    Route::get('Edit/{id}', 'LessonManager@EditView')->name('Lesson.Edit.View');
    //Create(Post) Routes
    Route::post('Add', 'LessonManager@Add')->name('Lesson.Add');
    Route::post('Edit/{id}', 'LessonManager@Edit')->name('Lesson.Edit');

    Route::post('Table', 'LessonManager@Table')->name('Lesson.Table');
    Route::post('BaseSelect', 'LessonManager@BaseSelect')->name('Lesson.BaseSelect');
});

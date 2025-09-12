<?php
use App\Http\Controllers\CoreCommon;
use App\Modules\Schedule\Admin\Controllers\ScheduleManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes

    Route::get('Add', 'ScheduleManager@AddView')->name('Schedule.Add.View');
    //Create(Post) Routes
    Route::post('Add', 'ScheduleManager@Add')->name('Schedule.Add');
    Route::post('ClassList', 'ScheduleManager@ClassList')->name('Schedule.ClassList');
    Route::post('LessonList', 'ScheduleManager@LessonList')->name('Schedule.LessonList');
    Route::post('TeacherList', 'ScheduleManager@TeacherList')->name('Schedule.TeacherList');
    Route::post('weekTable', 'ScheduleManager@weekTable')->name('Schedule.weekTable');

});

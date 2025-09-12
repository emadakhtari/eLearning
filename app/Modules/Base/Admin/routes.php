<?php


use App\Http\Controllers\CoreCommon;
use App\Modules\Base\Admin\Controllers\BaseManager;

$dd = CoreCommon::osD();
$manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . 'Manifest.json', "r");
$manifest = json_decode($manifestJson, true);
$moduleName = $manifest['title'];
$moduleSide = "Admin";


//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName . '/' . $moduleSide, 'namespace' => 'App\Modules\\' . $moduleName . '\\' . $moduleSide . '\Controllers', 'middleware' => ['web']], function () {
    //Views(Get) Routes
    Route::get('Add', 'BaseManager@AddView')->name('Base.Add.View');
    Route::get('Edit/{id}', 'BaseManager@EditView')->name('Base.Edit.View');
    //Create(Post) Routes
    Route::post('Add', 'BaseManager@Add')->name('Base.Add');
    Route::post('Edit/{id}', 'BaseManager@Edit')->name('Base.Edit');

    Route::post('Table', 'BaseManager@Table')->name('Base.Table');
});

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
    Route::get('AddUserCategory', 'UserCategoryManager@AddUserCategoryView')->name('UserCategory.Add.View');
    Route::get('EditUserCategory/{id}', 'UserCategoryManager@EditUserCategoryView')->name('UserCategory.Edit.View');

    //Create(Post) Routes
    Route::post('AddUserCategory', 'UserCategoryManager@AddUserCategory')->name('UserCategory.Add');
    Route::post('EditUserCategory/{id}', 'UserCategoryManager@EditUserCategory')->name('UserCategory.Edit');
    //Update(Put) Routes

});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Hash;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Http\Controllers\CoreCommon;
use Illuminate\Support\Facades\Auth;

$dd=CoreCommon::osD();
$manifestJson=file_get_contents(__DIR__.$dd.'..'.$dd.'Manifest.json', "r");
$manifest=json_decode($manifestJson,true);
$moduleName=$manifest['title'];
$moduleSide = "Admin";
// dd($moduleSide);

//These Routes Use When User Logged In And Have Permissions Of That Route
Route::group(['prefix' => $moduleName.'/'.$moduleSide, 'namespace' => 'App\Modules\\'.$moduleName.'\\'.$moduleSide.'\Controllers' ,'middleware'=>['web','guest:web'] ], function ()
{


    Route::get('/Admin',function(){
            return View('Master_Admin::MasterPage');
        })->name('MasterPage');
});


//These Routes Use When User Not Logged In


<?php


namespace App\Modules\SchoolList\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Illuminate\Http\Request;
use App\Modules\SchoolList\Admin\Models\SchoolList;
use Illuminate\Support\Facades\Auth;


class AjaxHandler extends Controller
{
    public function GetModuleName()
    {
        $dd = CoreCommon::osD();
        $manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . '..' . $dd . 'Manifest.json', "r");
        $manifest = json_decode($manifestJson, true);
        $moduleName = $manifest['title'];
        return $moduleName;
    }

    public function GetPreView()
    {
        $dd = CoreCommon::osD();
        $manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . '..' . $dd . 'Manifest.json', "r");
        $manifest = json_decode($manifestJson, true);
        $moduleName = $manifest['title'];
        if (substr(strrchr(__DIR__, "Admin" . $dd), 6)) {
            $side = 'Admin';
        } else if (substr(strrchr(__DIR__, "Site" . $dd), 5)) {
            $side = 'Site';
        }

        $preView = $moduleName . '_' . $side . '::';
        return $preView;
    }

    //Just Return Views

    public function ListView(Request $request)
    {
        $searchRequest = $request->input('search');
        $provinceRequest = $request->input('province');
        $cityRequest = $request->input('city');

        $app = SchoolList::Search($searchRequest,$provinceRequest,$cityRequest);
        $userId = Auth::user()->id;
        $userSelect = Users::where('id' , $userId)
            ->first();
        $userCategorySelect = UserCategory::where('id' , $userSelect->user_category_id)
            ->first();



        return view($this->GetPreView() . 'Ajax_List' ,compact('userCategorySelect'))->with('data', ['app' => $app]);
    }

}

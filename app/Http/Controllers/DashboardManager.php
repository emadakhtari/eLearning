<?php


namespace App\Http\Controllers;

use App\Modules\Communicated\Admin\Models\Communicated;
use App\Modules\CommunicatedUser\Admin\Models\CommunicatedUser;
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use Auth;
use DB;


class DashboardManager extends Controller
{
    public function ShowDashboard()
    {
//        dd(Auth::guard('web')->check(),Auth::guard('deputy')->check());
//       Auth::guard('web')->logout();
        if (Auth::guard('web')->check() == true) {
            $userId = Auth::user()->id;
            $user = Users::Where('id', $userId)
                ->first();
            $permissions = json_decode(Auth::user()->permissions, true)['admin'];

            $userCategory = UserCategory::where('status', 1)
                ->where('id', '!=', 1)
                ->get();
            $userCategoryRow = UserCategory::where('id', $user->user_category_id)
                ->first();
            return view('list', compact('permissions', 'userCategory', 'userCategoryRow'));
        } elseif (Auth::guard('teacher')->check() == true)  {
            return view('list');
        } elseif (Auth::guard('deputy')->check() == true)  {
            return view('list');
        } elseif (Auth::guard('students')->check() == true)  {
            return view('list');
        } else{
            return redirect(route('UsersLoginView'));
        }

    }
}

<?php
use App\Modules\UserCategory\Admin\Models\UserCategory;
use App\Modules\Users\Admin\Models\Users;
use App\Modules\Deputy\Admin\Models\Deputy;
use App\Modules\Teacher\Admin\Models\Teacher;
use App\Modules\Setting\Admin\Models\Setting;
use App\Modules\School\Admin\Models\School;
use App\Modules\Students\Admin\Models\Students;

if (Auth::guard('web')->check() == true) {
    $userId = Auth::user()->id;
    $userAllSinglePermissions = [];
    $user = Users::Where('id', $userId)
        ->first();
    $userCat = UserCategory::Where('id', $user->user_category_id)
        ->first();


    if (!empty($permissions)) {
        foreach ($permissions as $key => $permission) {
            foreach ($permission['permissions'] as $perm_json) {
                $perm = json_decode($perm_json, true);
                if (!empty($perm)) {
                    foreach ($perm[key($perm)] as $access_name) {
                        array_push($userAllSinglePermissions, $access_name);
                    }
                } else {
                    array_push($userAllSinglePermissions, $key . '.' . $perm_json);
                }
            }
        }
    }

//Dashboard
    if (Route::currentRouteName() == 'list') {
        $activeDashboard = " active";
    } else {
        $activeDashboard = "";
    }
    if (Route::currentRouteName() == 'UserCategory.Add.View' || Route::currentRouteName() == 'UserCategory.Edit.View') {
        $activeUserCategory = " active";
    } else {
        $activeUserCategory = "";
    }
    if (Route::currentRouteName() == 'Users.Add.View' || Route::currentRouteName() == 'Users.Edit.View') {
        $activeUser = " active";
    } else {
        $activeUser = "";
    }
    if (Route::currentRouteName() == 'Grade.Add.View' || Route::currentRouteName() == 'Grade.Edit.View') {
        $activeGrade = " active";
    } else {
        $activeGrade = "";
    }


    if (Route::currentRouteName() == 'Base.Add.View' || Route::currentRouteName() == 'Base.Edit.View') {
        $activeBase = " active";
    } else {
        $activeBase = "";
    }

    if (Route::currentRouteName() == 'Lesson.Add.View' || Route::currentRouteName() == 'Lesson.Edit.View') {
        $activeLesson = " active";
    } else {
        $activeLesson = "";
    }

    if (Route::currentRouteName() == 'School.Add.View' || Route::currentRouteName() == 'School.Edit.View') {
        $activeSchool = " active";
    } else {
        $activeSchool = "";
    }
    if (Route::currentRouteName() == 'SchoolList.List.View' || Route::currentRouteName() == 'SchoolList.Edit.View') {
        $activeSchoolList = " active";
    } else {
        $activeSchoolList = "";
    }
} elseif (Auth::guard('deputy')->check() == true) {

    if (Route::currentRouteName() == 'list') {
        $activeDashboard = " active";
    } else {
        $activeDashboard = "";
    }
    if (Route::currentRouteName() == 'Schedule.Add.View') {
        $activeSchedule = " active";
    } else {
        $activeSchedule = "";
    }

    if (Route::currentRouteName() == 'Students.Add.View' || Route::currentRouteName() == 'Students.Edit.View') {
        $activeStudents = " active";
    } else {
        $activeStudents = "";
    }
    if (Route::currentRouteName() == 'Teacher.Add.View' || Route::currentRouteName() == 'Teacher.Edit.View') {
        $activeTeacher = " active";
    } else {
        $activeTeacher = "";
    }
    if (Route::currentRouteName() == 'TeacherAssign.Add.View' || Route::currentRouteName() == 'TeacherAssign.Edit.View') {
        $activeTeacherAssign = " active";
    } else {
        $activeTeacherAssign = "";
    }
    if (Route::currentRouteName() == 'TrainingHours.Add.View' || Route::currentRouteName() == 'TrainingHours.Edit.View') {
        $activeTrainingHours = " active";
    } else {
        $activeTrainingHours = "";
    }
    if (Route::currentRouteName() == 'ClassAssign.Add.View') {
        $activeClassAssign = " active";
    } else {
        $activeClassAssign = "";
    }
    if (Route::currentRouteName() == 'DeputyUser.Add.View') {
        $activeDeputyUser = " active";
    } else {
        $activeDeputyUser = "";
    }
    if (Route::currentRouteName() == 'Setting.Edit.View') {
        $activeSetting = " active";
    } else {
        $activeSetting = "";
    }

    $deputyId = Auth::guard('deputy')->id();
    $Deputy = Deputy::Where('id', $deputyId)
        ->first();
    if ($Deputy->level == "2") {
        $permissionsDeputy = json_decode($Deputy->permissions, true)['admin'];
    } else {
        $permissionsDeputy = null;
    }

    $School = School::Where('id', $Deputy->school_id)
        ->first();


} elseif (Auth::guard('teacher')->check() == true) {
    $teacherId = Auth::guard('teacher')->id();
    $Teacher = Teacher::Where('id', $teacherId)
        ->first();
    if (Route::currentRouteName() == 'list') {
        $activeDashboard = " active";
    } else {
        $activeDashboard = "";
    }
    if (Route::currentRouteName() == 'WeeklySchedule.Add.View') {
        $activeWeeklySchedule = " active";
    } else {
        $activeWeeklySchedule = "";
    }
    if (Route::currentRouteName() == 'Homeworks.List.View') {
        $activeHomeworks = " active";
    } else {
        $activeHomeworks = "";
    }
    if (Route::currentRouteName() == 'TrainingInformation.Add.View') {
        $activeTrainingInformation = " active";
    } else {
        $activeTrainingInformation = "";
    }
    if (Route::currentRouteName() == 'GeneralInformation.Add.View') {
        $activeGeneralInformation = " active";
    } else {
        $activeGeneralInformation = "";
    }

} elseif (Auth::guard('students')->check() == true) {
    $studentsId = Auth::guard('students')->id();
    $Students = Students::Where('id', $studentsId)
        ->first();
    if (Route::currentRouteName() == 'list') {
        $activeDashboard = " active";
    } else {
        $activeDashboard = "";
    }
    if (Route::currentRouteName() == 'WeeklyScheduleSt.Add.View') {
        $activeWeeklyScheduleSt = " active";
    } else {
        $activeWeeklyScheduleSt = "";
    }
    if (Route::currentRouteName() == 'HomeworkUpload.Add.View') {
        $activeHomeworkUpload = " active";
    } else {
        $activeHomeworkUpload = "";
    }
}

$setting = Setting::where('id', 1)
    ->first();

?>

    <!DOCTYPE html>
<html class="loading" lang="fa" data-textdirection="rtl" dir="rtl">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{!! $setting->title !!}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Assets/Admin/images/fave.jpg')}}">
    <meta name="theme-color" content="#5A8DEE">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/vendors/css/extensions/swiper.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href=" {{asset('Assets/Admin/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/themes/semi-dark-layout.css')}}">


    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/pages/dashboard-ecommerce.css')}}">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/defaults.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/pages/toastr.min.css')}}">

    <!-- begin::global fancybox -->
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/css/sweetalert.css')}}">
    <!-- end::global fancybox -->

    <style>
        .navbar-header {
            height: auto !important;
        }

        .main-menu .navbar-header .navbar-brand .brand-logo .logo {
            height: auto !important;
            top: -9px !important;
            width: 90px !important;
            margin: 0 auto;
        }

        .brand-logo p {
            font-size: 14px !important;
            margin-bottom: 0 !important;
        }

        .brand-logo span {
            font-size: 14px !important;
        }
        .tui-full-calendar-popup-container {
            min-width: 320px !important;
        }
    </style>
    @yield('CSS')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="2-columns">

<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon bx bx-menu"></i></a></li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">

                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span
                                    class="user-name">
                                    @if(Auth::guard('web')->check() == true)
                                        {{$user->name}} {{$user->family}}
                                    @elseif(Auth::guard('deputy')->check() == true)
                                        {{$Deputy->name}} {{$Deputy->family}}
                                    @elseif(Auth::guard('teacher')->check() == true)
                                        {{$Teacher->name}} {{$Teacher->family}}
                                    @elseif(Auth::guard('students')->check() == true)
                                        {{$Students->name}} {{$Students->family}}
                                    @endif
                                </span><span
                                    class="user-status text-muted">
                                     @if(Auth::guard('web')->check() == true)
                                        {{$userCat->title}}
                                    @elseif(Auth::guard('deputy')->check() == true)
                                        معاونت آموزش
                                    @elseif(Auth::guard('teacher')->check() == true)
                                        مدرس
                                    @elseif(Auth::guard('students')->check() == true)
                                        دانش آموز
                                    @endif
                                </span></div>
                        </a>
                        <div class="dropdown-menu pb-0">
                            @if(Auth::guard('web')->check() == true)
                                <a class="dropdown-item" href="{{route('Users.Edit', $userId)}}">
                                    <i class="bx bx-user mr-50"></i>
                                    ویرایش پروفایل
                                </a>
                            @elseif(Auth::guard('deputy')->check() == true)
                                <a class="dropdown-item" href="{{route('Deputy.Edit', $deputyId)}}">
                                    <i class="bx bx-user mr-50"></i>
                                    ویرایش پروفایل
                                </a>
                            @elseif(Auth::guard('teacher')->check() == true)
                                <a class="dropdown-item" href="{{route('Teacher.Edit', $teacherId)}}">
                                    <i class="bx bx-user mr-50"></i>
                                    ویرایش پروفایل
                                </a>
                            @elseif(Auth::guard('students')->check() == true)
                                <a class="dropdown-item" href="{{route('Students.Edit', $studentsId)}}">
                                    <i class="bx bx-user mr-50"></i>
                                    ویرایش پروفایل
                                </a>
                            @endif
                            <div class="dropdown-divider mb-0"></div>
                            @if(Auth::guard('web')->check() == true)
                                <a class="dropdown-item" href="{{route('UsersLogout')}}">
                                    <i class="bx bx-power-off mr-50"></i>
                                    خروج
                                </a>
                            @elseif(Auth::guard('deputy')->check() == true)
                                <a class="dropdown-item" href="{{route('DeputyLogout')}}">
                                    <i class="bx bx-power-off mr-50"></i>
                                    خروج
                                </a>
                            @elseif(Auth::guard('teacher')->check() == true)
                                <a class="dropdown-item" href="{{route('TeacherLogout')}}">
                                    <i class="bx bx-power-off mr-50"></i>
                                    خروج
                                </a>
                            @elseif(Auth::guard('students')->check() == true)
                                <a class="dropdown-item" href="{{route('StudentsLogout')}}">
                                    <i class="bx bx-power-off mr-50"></i>
                                    خروج
                                </a>
                            @endif

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto" style="margin: 0 auto !important;"><a class="navbar-brand" href="{{route('list')}} ">
                    <div class="brand-logo" style="width: auto;height: auto">
                        @if($setting->top_menu_image)
                            <img class="logo" src="{{asset('upload/setting/'.$setting->top_menu_image)}}">
                        @endif
                        @if($setting->software_text)
                            {!! $setting->software_text !!}
                        @endif
                    </div>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i
                        class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation"
            data-icon-style="lines">
            <li class="nav-item {{$activeDashboard}}">
                <a href="{{route('list')}}">
                    <i class="menu-livicon" data-icon="desktop"></i>
                    <span class="menu-title" data-i18n="Dashboard">داشبورد</span>
                </a>
            </li>
            @if(Auth::guard('web')->check() == true)
                <li class=" navigation-header"><span>برنامه ها</span>
                @if(!empty($permissions['UserCategory']) || !empty($permissions['Users']) || Auth::guard('web')->user()->id == 1 )
                    <?php $moduleName = 'Users'; ?>
                    <li class="nav-item @if( Route::currentRouteName()=='Users.Edit.View') has-sub sidebar-group-active open @endif ">
                        <a href="#">
                            <i class="menu-livicon" data-icon="users"></i>
                            <span class="menu-title" data-i18n="User">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                        <ul class="menu-content">
                            @if(in_array("Users.Add.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                                <li @if( Route::currentRouteName()=='Users.Add.View' || Route::currentRouteName()=='Users.Edit.View') class=active
                                    @endif >
                                    <a href="{{route('Users.Add.View')}}"><i class="bx bx-left-arrow-alt"></i>
                                        <span class="menu-item" data-i18n="eCommerce">{{trans('modules.add')}}</span>
                                    </a>
                                </li>
                            @endif
                            @if(!empty($permissions['UserCategory']) || Auth::guard('web')->user()->id == 1)
                                <?php $moduleName = 'UserCategory'; ?>
                                @if(in_array("UserCategory.Add.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                                    <li class="nav-item {{$activeUserCategory}}">
                                        <a href="{{route('UserCategory.Add.View')}}">
                                            <i class="bx bx-left-arrow-alt"></i>
                                            <span class="menu-title"
                                                  data-i18n="UserCategory">{{trans('modules.'.$moduleName)}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li>
                @else
                    <?php $moduleName = 'Users'; ?>
                    <li class="nav-item" style="opacity: .5">
                        <a href="#">
                            <i class="menu-livicon" data-icon="users"></i>
                            <span class="menu-title" data-i18n="User">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a href="#" class="disablePermision"><i class="bx bx-left-arrow-alt"></i>
                                    <span class="menu-item" data-i18n="eCommerce">{{trans('modules.add')}}</span>
                                </a>
                            </li>
                            <?php $moduleName = 'UserCategory'; ?>
                            <li class="nav-item">
                                <a href="#" class="disablePermision">
                                    <i class="bx bx-left-arrow-alt"></i>
                                    <span class="menu-title"
                                          data-i18n="UserCategory">{{trans('modules.'.$moduleName)}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(!empty($permissions['Grade']) || Auth::guard('web')->user()->id == 1 )
                    <?php $moduleName = 'Grade'; ?>
                    @if(in_array("Grade.Add.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                        <li class="nav-item @if( Route::currentRouteName()=='Grade.Add.View' || Route::currentRouteName()=='Grade.Edit.View') active @endif">
                            <a href="{{route('Grade.Add.View')}}"><i class="menu-livicon"
                                                                     data-icon="chevron-top-double"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <?php $moduleName = 'Grade'; ?>
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision"><i class="menu-livicon" data-icon="chevron-top-double"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif

                @if(!empty($permissions['Base']) || Auth::guard('web')->user()->id == 1 )
                    <?php $moduleName = 'Base'; ?>
                    @if(in_array("Base.Add.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                        <li class="nav-item @if( Route::currentRouteName()=='Base.Add.View' || Route::currentRouteName()=='Base.Edit.View') active @endif">
                            <a href="{{route('Base.Add.View')}}"><i class="menu-livicon" data-icon="chevron-top"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <?php $moduleName = 'Base'; ?>
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision"><i class="menu-livicon" data-icon="chevron-top"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif
                @if(!empty($permissions['Lesson']) || Auth::guard('web')->user()->id == 1 )
                    <?php $moduleName = 'Lesson'; ?>
                    @if(in_array("Lesson.Add.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                        <li class="nav-item @if( Route::currentRouteName()=='Lesson.Add.View' || Route::currentRouteName()=='Lesson.Edit.View') active @endif">
                            <a href="{{route('Lesson.Add.View')}}"><i class="menu-livicon" data-icon="pen"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <?php $moduleName = 'Lesson'; ?>
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision"><i class="menu-livicon" data-icon="pen"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif
                @if(!empty($permissions['School']) || Auth::guard('web')->user()->id == 1 )
                    <?php $moduleName = 'School'; ?>
                    @if(in_array("School.Add.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                        <li class="nav-item @if( Route::currentRouteName()=='School.Add.View') active @endif">
                            <a href="{{route('School.Add.View')}}"><i class="menu-livicon" data-icon="building"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <?php $moduleName = 'School'; ?>
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision"><i class="menu-livicon" data-icon="building"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif

                @if(!empty($permissions['SchoolList']) || Auth::guard('web')->user()->id == 1 )
                    <?php $moduleName = 'SchoolList'; ?>
                    @if(in_array("SchoolList.List.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                        <li class="nav-item @if( Route::currentRouteName()=='SchoolList.List.View') active @endif">
                            <a href="{{route('SchoolList.List.View')}}"><i class="menu-livicon"
                                                                           data-icon="building"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <?php $moduleName = 'SchoolList'; ?>
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision"><i class="menu-livicon" data-icon="building"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif
                @if(!empty($permissions['Setting']) || Auth::guard('web')->user()->id == 1 )
                    <?php $moduleName = 'Setting'; ?>
                    @if(in_array("Setting.Add.View",$userAllSinglePermissions) || Auth::guard('web')->user()->id == 1)
                        <li class="nav-item @if(Route::currentRouteName()=='Setting.Edit.View') active @endif">
                            <a href="{{route('Setting.Edit.View','1')}}"><i class="menu-livicon" data-icon="gears"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <?php $moduleName = 'Setting'; ?>
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision"><i class="menu-livicon" data-icon="chevron-top-double"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif
            @elseif(Auth::guard('deputy')->check() == true)
                <?php $moduleName = 'DeputyUser'; ?>
                @if(!empty($permissionsDeputy['DeputyUser']) || $Deputy->level == "1" )
                    <li class="nav-item {{$activeDeputyUser}}">
                        <a href="{{route('DeputyUser.Add.View')}}">
                            <i class="menu-livicon" data-icon="users"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision">
                            <i class="menu-livicon" data-icon="users"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif
                <?php $moduleName = 'Teacher'; ?>
                @if(!empty($permissionsDeputy['Teacher']) || $Deputy->level == "1" )
                    <li class="nav-item  {{$activeTeacher}}">
                        <a href="{{route('Teacher.Add.View')}}">
                            <i class="menu-livicon" data-icon="users"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision">
                            <i class="menu-livicon" data-icon="users"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif


                <?php $moduleName = 'TrainingHours'; ?>
                @if(!empty($permissionsDeputy['TrainingHours']) || $Deputy->level == "1" )
                    <li class="nav-item  {{$activeTrainingHours}}">
                        <a href="{{route('TrainingHours.Add.View')}}">
                            <i class="menu-livicon" data-icon="morph-clock"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision">
                            <i class="menu-livicon" data-icon="morph-clock"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif


                <?php $moduleName = 'ClassAssign'; ?>
                @if(!empty($permissionsDeputy['ClassAssign']) || $Deputy->level == "1" )
                    <li class="nav-item {{$activeClassAssign}}">
                        <a href="{{route('ClassAssign.Add.View')}}">
                            <i class="menu-livicon" data-icon="home"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision">
                            <i class="menu-livicon" data-icon="home"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif


                <?php $moduleName = 'TeacherAssign'; ?>
                @if(!empty($permissionsDeputy['TeacherAssign']) || $Deputy->level == "1" )
                    <li class="nav-item  {{$activeTeacherAssign}}">
                        <a href="{{route('TeacherAssign.Add.View')}}">
                            <i class="menu-livicon" data-icon="swap-horizontal"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision">
                            <i class="menu-livicon" data-icon="swap-horizontal"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif


                <?php $moduleName = 'Schedule'; ?>
                @if(!empty($permissionsDeputy['Schedule']) || $Deputy->level == "1" )
                    <li class="nav-item  {{$activeSchedule}}">
                        <a href="{{route('Schedule.Add.View')}}">
                            <i class="menu-livicon" data-icon="calendar"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision">
                            <i class="menu-livicon" data-icon="calendar"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif


                @if(!empty($permissionsDeputy['Students']) || $Deputy->level == "1" )
                    @if($School->register_type == "1")
                        <?php $moduleName = 'Students'; ?>
                        <li class="nav-item  {{$activeStudents}}">
                            <a href="{{route('Students.Add.View')}}">
                                <i class="menu-livicon" data-icon="users"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @else
                        <?php $moduleName = 'Students'; ?>
                        <li class="nav-item" style="opacity: .5">
                            <a href="#" class="disablePermision">
                                <i class="menu-livicon" data-icon="users"></i>
                                <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item" style="opacity: .5">
                        <a href="#" class="disablePermision">
                            <i class="menu-livicon" data-icon="users"></i>
                            <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                        </a>
                    </li>
                @endif

            @elseif(Auth::guard('teacher')->check() == true)
                <?php $moduleName = 'WeeklySchedule'; ?>
                <li class="nav-item  {{$activeWeeklySchedule}}">
                    <a href="{{route('WeeklySchedule.Add.View')}}">
                        <i class="menu-livicon" data-icon="calendar"></i>
                        <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                    </a>
                </li>
                <?php $moduleName = 'TrainingInformation'; ?>
                <li class="nav-item  {{$activeTrainingInformation}}">
                    <a href="{{route('TrainingInformation.Add.View')}}">
                        <i class="menu-livicon" data-icon="box-add"></i>
                        <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                    </a>
                </li>
                <?php $moduleName = 'GeneralInformation'; ?>
                <li class="nav-item  {{$activeGeneralInformation}}">
                    <a href="{{route('GeneralInformation.Add.View')}}">
                        <i class="menu-livicon" data-icon="box-add"></i>
                        <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                    </a>
                </li>
                <?php $moduleName = 'Homeworks'; ?>
                <li class="nav-item  {{$activeHomeworks}}">
                    <a href="{{route('Homeworks.List.View')}}">
                        <i class="menu-livicon" data-icon="calendar"></i>
                        <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                    </a>
                </li>
            @elseif(Auth::guard('students')->check() == true)
                <?php $moduleName = 'WeeklyScheduleSt'; ?>
                <li class="nav-item  {{$activeWeeklyScheduleSt}}">
                    <a href="{{route('WeeklyScheduleSt.Add.View')}}">
                        <i class="menu-livicon" data-icon="calendar"></i>
                        <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                    </a>
                </li>
                <?php $moduleName = 'HomeworkUpload'; ?>
                <li class="nav-item  {{$activeHomeworkUpload}}">
                    <a href="{{route('HomeworkUpload.Add.View')}}">
                        <i class="menu-livicon" data-icon="calendar"></i>
                        <span class="menu-item" data-i18n="eCommerce">{{trans('modules.'.$moduleName)}}</span>
                    </a>
                </li>
            @endif
            <br>
            <br>
            <hr>
            <div style="text-align: center;padding: 0 20px;">
                @if($setting->powered_text)
                    {!! $setting->powered_text !!}
                @endif
                @if($setting->signature_image)
                    <img
                        style="
color: #f87008;
margin: 0 auto;
width: 73px;
display: block;
"
                        src="{{asset('upload/setting/'.$setting->signature_image)}}" alt="">
                @endif
            </div>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <input type="hidden" value="{{ csrf_token() }}" id="nekot">
        @yield('content')
    </div>
</div>
<!-- END: Content-->

<!-- BEGIN: Vendor JS-->
<script type="text/javascript"
        src="{{asset('Assets/Admin/vendors/js/vendors.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js')}}"></script>
<script type="text/javascript">
    if (typeof jQuery === 'undefined') {
        window.alert('LivIcons Evolution Script requires jQuery (https://jquery.com)!');
        throw new Error('LivIcons Evolution Script requires jQuery (https://jquery.com)!');
    }

    function LivIconsEvoDefaults() {
        "use strict";
        var defaultOptions = {
            pathToFolder: '{{asset('Assets/Admin/fonts/LivIconsEvo/svg/')}}', //the path from root of your site to folder with icons. Also may be as URL, like 'http://yoursite.com/path/to/LivIconsEvo/svg/'
            name: 'bell.svg', //the default icon name
            //visualization options
            style: 'original', //'original', 'solid', filled', 'lines' or ('lines-alt' / 'linesAlt')
            size: '60px', //default size
            strokeStyle: 'original', //'original', 'round' or 'square'
            strokeWidth: 'original', //'original' or any value in pixels
            tryToSharpen: true, //apply or not micro shifts of SVG shapes to try to make them more sharp (crisp)
            rotate: 'none', //'none' or any value in deg [0 ... 360]
            flipHorizontal: false,
            flipVertical: false,
            strokeColor: '#22A7F0', //when style opt is 'filled' or 'lines' or ('lines-alt' / 'linesAlt')
            strokeColorAction: '#b3421b', //when 'style' is 'original', 'filled' or 'lines' and 'colorsOnHover' or 'colorsWhenMorph' is 'custom'
            strokeColorAlt: '#F9B32F', //when style opt is ('lines-alt' / 'linesAlt')
            strokeColorAltAction: '#ab69c6', //when 'style' is ('lines-alt' / 'linesAlt') and 'colorsOnHover' or 'colorsWhenMorph' is 'custom'
            fillColor: '#91e9ff', //when style opt is 'filled'
            fillColorAction: '#ff926b', //when 'style' is 'original' or 'filled' and 'colorsOnHover' or 'colorsWhenMorph' is 'custom'
            solidColor: '#6C7A89', //when style opt is 'solid'
            solidColorAction: '#4C5A69', //when 'style' is 'solid' and 'colorsOnHover' or 'colorsWhenMorph' is 'custom'
            solidColorBg: '#ffffff', //when style opt is 'solid'
            solidColorBgAction: '#ffffff', //when 'style' is 'solid'
            colorsOnHover: 'none', //'none', 'lighter', 'darker', 'custom' or 'hue0' ... 'hue360'
            colorsHoverTime: 0.3, //seconds
            colorsWhenMorph: 'none', //'none', 'lighter', 'darker', 'custom' or 'hue0' ... 'hue360'
            brightness: 0.10, // brightness change when 'lighter' or 'darker' (10% by default)
            saturation: 0.07, // saturation change when 'lighter' or 'darker' (7% by default)
            morphState: 'start', //'start' or 'end' (initial state for animating position)
            morphImage: 'none', //'none' or a URL to your image (better to use an image with equal width and height)
            allowMorphImageTransform: false, //if true the inside image will rotate and/or flip with a morph icon together
            strokeWidthFactorOnHover: 'none', //'none' or numeric value. For ex., for increase twice set the option to 2
            strokeWidthOnHoverTime: 0.3, //seconds
            keepStrokeWidthOnResize: false,
            //animation options
            animated: true, //if false, an icon is static
            eventType: 'hover', //'click', 'hover' or 'none'
            eventOn: 'self', //'self', 'parent', 'grandparent' or any ID (#some_id) or class (.some_class)
            autoPlay: false, //be careful with true value
            delay: 0, //value in seconds
            duration: 'default', //'default' or value in seconds
            repeat: 'default', //'default', 'loop' or integer number of repeats
            repeatDelay: 'default', //'default' or value in seconds
            drawOnViewport: false,
            viewportShift: 'oneHalf', //'none', ('one-half' / 'oneHalf'), ('one-third' / 'oneThird') or 'full'
            drawDelay: 0, //seconds
            drawTime: 1, //seconds
            drawStagger: 0.1, //seconds
            drawStartPoint: 'middle', //'start', 'middle' or 'end'
            drawColor: 'same', //'same' or any desired color value (HEX)
            drawColorTime: 1, //seconds
            drawReversed: false, //true will reverse the order of shapes drawing
            drawEase: 'Power1.easeOut', //default ease
            eraseDelay: 0, //seconds
            eraseTime: 1, //seconds
            eraseStagger: 0.1, //seconds
            eraseStartPoint: 'middle', //'start', 'middle' or 'end'
            eraseReversed: true, //true will reverse the order of shapes erasing
            eraseEase: 'Power1.easeOut', //default ease
            touchEvents: false, //apply or not special events handlers for touch devices
            //callback functions
            beforeAdd: false,
            afterAdd: false,
            beforeUpdate: false,
            afterUpdate: false,
            beforeRemove: false,
            afterRemove: false,
            beforeDraw: false,
            afterDraw: false,
            duringDraw: false,
            beforeErase: false,
            afterErase: false,
            duringErase: false,
            beforeAnim: false,
            afterAnim: false,
            duringAnim: false
        };
        if (defaultOptions.pathToFolder === '/EDIT THIS OPTION!/') {
            window.alert('LivIcons Evolution: Please edit "pathToFolder" option in the "LivIconsEvo.defaults.js" file!');
            throw new Error('LivIcons Evolution: Please edit "pathToFolder" option in the "LivIconsEvo.defaults.js" file!');
        }
        return defaultOptions;
    }

    @if(session()->has('success'))
    $(document).ready(function () {
        Command: toastr["success"]("{{session()->get('success')}}", "");
    });
    @endif
    @if(session()->has('error'))
    $(document).ready(function () {
        Command: toastr["error"]("{{session()->get('error')}}", "");
    });
    @endif
</script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script type="text/javascript"
        src="{{asset('Assets/Admin/vendors/js/charts/apexcharts.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/vendors/js/extensions/swiper.min.js')}}"></script>
<!-- END: Page Vendor JS-->


<!-- BEGIN: Theme JS-->
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/configs/vertical-menu-light.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/core/app-menu.js')}}"></script>

<script type="text/javascript"
        src="{{asset('Assets/Admin/js/core/app.js')}}"></script>

<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/components.js')}}"></script>

<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/footer.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/customizer.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/pages/dashboard-ecommerce.js')}}"></script>
<!-- END: Page JS-->

<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/pages/toastr.min.js')}}"></script>
<!-- begin::global fancybox -->
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/sweetalert.min.js')}}"></script>
<!-- end::global fancybox -->
<script>
    $(".disablePermision").on("click", function () {
        swal({
                title: "سطح دسترسی",
                text: "سطح دسترسی شما برای این قابلیت غیر فعال می باشد.",
                type: "warning",
                showCancelButton: false,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "بستن!",
                showLoaderOnConfirm: true,
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                } else {
                    swal("", "محتوا شما در امان است!", "error");
                }
            });

    });

</script>

@yield('js')

</body>
<!-- END: Body-->
</html>

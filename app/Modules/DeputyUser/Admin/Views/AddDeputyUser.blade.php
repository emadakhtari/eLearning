@extends('Master_Admin::MasterPage')
@section('title')
    کاربران معاونت
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
    <style>
        .custom-switch {
            width: 13% !important;
            max-width: 13% !important;
            text-align: center;
            display: inline-block;
        }

        .custom-form-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed;
        }
    </style>
@stop
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1"></h5>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{route('list')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item "><a>کاربران معاونت</a>
                            </li>
                            <li class="breadcrumb-item active"><a>افزودن کاربر معاونت</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <form id="form" class="form form-vertical" name="form" method="post"
                          action="{{route('DeputyUser.Add')}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="{{ $deputyId }}" name="above_id" id="above_id">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">اطلاعات کاربر معاون مرکز آموزش</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_name">نام معاون مرکز آموزش:</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="name"
                                                               name="name"
                                                               placeholder="نام"
                                                        >
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_name">نام خانوادگی معاون مرکز آموزش:</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="family"
                                                               name="family"
                                                               placeholder="نام خانوادگی"
                                                        >
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-group"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_name">نام کاربری (کد ملی) معاون مرکز
                                                        آموزش:</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="national_code"
                                                               class="form-control char-textarea"
                                                               name="national_code"
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               placeholder="نام کاربری (کد ملی)"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-id-card"></i>
                                                        </div>
                                                        <small class="counter-value float-right"><span
                                                                class="char-count">0</span> / 10 </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">رمز عبور معاون مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password"
                                                               class="form-control"
                                                               name="password"
                                                               placeholder="رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password"
                                                               class="bx bxs-show  toggle-password"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">تکرار رمز عبور معاون مرکز آموزش:
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_confirmation"
                                                               class="form-control"
                                                               name="password_confirmation"
                                                               placeholder="تکرار رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_confirmation"
                                                               class="bx bxs-show  toggle-re-password"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone">شماره همراه معاون مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="phone"
                                                               class="form-control char-textarea4"
                                                               name="phone"
                                                               data-length="11"
                                                               minlength="11" maxlength="11"
                                                               placeholder="شماره همراه">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                        <small class="counter-value4 float-right"><span
                                                                class="char-count4">0</span> / 11 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">ایمیل معاون مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="email" class="form-control"
                                                               name="email" placeholder="ایمیل">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-header">
                                <h4 class="card-title">دسترسی کاربر معاون مرکز آموزش</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">مدرس</p>
                                                <input name="modules[]" type="checkbox" class="custom-control-input modules"
                                                       id="firstCheck_1"
                                                       value="1_Teacher">
                                                <label class="custom-control-label" for="firstCheck_1">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">افزودن</p>
                                                <input name="Teacher[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_1"
                                                       value='{"Add":["Teacher.Add.View","Teacher.Add"]}'>
                                                <label class="custom-control-label" for="secCheck_1">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">ویرایش</p>
                                                <input name="Teacher[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_2"
                                                       value='{"Edit":["Teacher.Edit.View","Teacher.Edit"]}'>
                                                <label class="custom-control-label" for="secCheck_2">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">لیست</p>
                                                <input name="Teacher[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_3"
                                                       value='{"List":["Teacher.List.View"]}'>
                                                <label class="custom-control-label" for="secCheck_3">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">ساعت آموزشی</p>
                                                <input name="modules[]" type="checkbox" class="custom-control-input modules"
                                                       id="firstCheck_2"
                                                       value="1_TrainingHours">
                                                <label class="custom-control-label" for="firstCheck_2">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">افزودن</p>
                                                <input name="TrainingHours[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_4"
                                                       value='{"Add":["TrainingHours.Add.View","TrainingHours.Add"]}'>
                                                <label class="custom-control-label" for="secCheck_4">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">ویرایش</p>
                                                <input name="TrainingHours[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_5"
                                                       value='{"Edit":["TrainingHours.Edit.View","TrainingHours.Edit"]}'>
                                                <label class="custom-control-label" for="secCheck_5">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">لیست</p>
                                                <input name="TrainingHours[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_6"
                                                       value='{"List":["TrainingHours.List.View"]}'>
                                                <label class="custom-control-label" for="secCheck_6">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">کلاس</p>
                                                <input name="modules[]" type="checkbox" class="custom-control-input modules"
                                                       id="firstCheck_3"
                                                       value="1_ClassAssign">
                                                <label class="custom-control-label" for="firstCheck_3">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">افزودن</p>
                                                <input name="ClassAssign[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_7"
                                                       value='{"Add":["ClassAssign.Add.View","ClassAssign.Add"]}'>
                                                <label class="custom-control-label" for="secCheck_7">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">ویرایش</p>
                                                <input name="ClassAssign[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_8"
                                                       value='{"Edit":["ClassAssign.Edit.View","ClassAssign.Edit"]}'>
                                                <label class="custom-control-label" for="secCheck_8">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">لیست</p>
                                                <input name="ClassAssign[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_9"
                                                       value='{"List":["ClassAssign.List.View"]}'>
                                                <label class="custom-control-label" for="secCheck_9">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">تخصیص مدرس</p>
                                                <input name="modules[]" type="checkbox" class="custom-control-input modules"
                                                       id="firstCheck_4"
                                                       value="1_TeacherAssign">
                                                <label class="custom-control-label" for="firstCheck_4">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">افزودن</p>
                                                <input name="TeacherAssign[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_10"
                                                       value='{"Add":["TeacherAssign.Add.View","TeacherAssign.Add"]}'>
                                                <label class="custom-control-label" for="secCheck_10">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">حذف</p>
                                                <input name="TeacherAssign[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_11"
                                                       value='{"Edit":["TeacherAssign.Delete","TeacherAssign.Edit"]}'>
                                                <label class="custom-control-label" for="secCheck_11">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">لیست</p>
                                                <input name="TeacherAssign[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_12"
                                                       value='{"List":["TeacherAssign.List.View"]}'>
                                                <label class="custom-control-label" for="secCheck_12">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">برنامه آموزشی</p>
                                                <input name="modules[]" type="checkbox" class="custom-control-input modules"
                                                       id="firstCheck_5"
                                                       value="1_Schedule">
                                                <label class="custom-control-label" for="firstCheck_5">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">افزودن</p>
                                                <input name="Schedule[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_13"
                                                       value='{"Add":["Schedule.Add.View","Schedule.Add"]}'>
                                                <label class="custom-control-label" for="secCheck_13">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">دانش آموز</p>
                                                <input name="modules[]" type="checkbox" class="custom-control-input modules"
                                                       id="firstCheck_6"
                                                       value="1_Students">
                                                <label class="custom-control-label" for="firstCheck_6">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">افزودن</p>
                                                <input name="Students[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_14"
                                                       value='{"Add":["Students.Add.View","Students.Add"]}'>
                                                <label class="custom-control-label" for="secCheck_14">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">ویرایش</p>
                                                <input name="Students[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_15"
                                                       value='{"Edit":["Students.Edit.View","Students.Edit"]}'>
                                                <label class="custom-control-label" for="secCheck_15">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                <p class="mb-0">لیست</p>
                                                <input name="Students[]" type="checkbox" class="custom-control-input item_modules"
                                                       id="secCheck_16"
                                                       value='{"List":["Students.List.View"]}'>
                                                <label class="custom-control-label" for="secCheck_16">
                                                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div
                                    class="custom-control custom-switch custom-switch-status custom-switch-success mr-2 mb-1">
                                    <p class="mb-0">وضعیت :</p>
                                    <input name="status" type="checkbox" class="custom-control-input"
                                           checked id="status"
                                           value="1">
                                    <label class="custom-control-label" for="status">
                                                        <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                        <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="col-md-6 col-6 ">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">ثبت</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="lds-ripple-content">
                        <div class="lds-ripple"><div></div><div></div></div>
                    </div>
                    <div id="BaseTable">
                        <div class="text-center">
                            <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                 style="width: 200px;margin: 0 auto" alt="">
                            <p class="pt10">
                                کاربر معاون برای مرکز آموزش شما تعریف نشده است
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('js')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>

    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $('.item_modules').click(function() {
            var closeCheckbox = $(this).closest('.border-bottom-dashed').find('input.modules:checkbox:first');
            if (closeCheckbox.prop('checked') == false) {
                closeCheckbox.prop('checked', true);
            }
        });
        $('.modules').click(function() {
            if ( $(this).prop('checked') == false) {
                $(this).closest('.border-bottom-dashed').find('input.item_modules:checkbox').prop('checked', false);
            }
        });
        $(document).ready(function () {
            base_table();
            function base_table() {
                var above_id = $("#above_id").val();
                var _token = $("#_token").val();
                $(".lds-ripple-content").fadeIn('slow');
                $.ajax({
                    type: 'POST',
                    url: '{{route('DeputyUser.Table')}}',
                    data: {above_id: above_id, _token: _token},
                    success: function (BaseTable) {
                        $('#BaseTable').html(BaseTable);
                        $(".lds-ripple-content").fadeOut('slow');
                    }
                });
            }


        });


        $(function () {
            $("#phone").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#phone").val(persianToEnglish($(this).val()));
                }
            });
            $("#national_code").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#national_code").val(persianToEnglish($(this).val()));
                }
            });

        });

        function persianToEnglish(input) {
            var inputstring = input;
            var persian = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"]
            var english = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]
            for (var i = 0; i < 10; i++) {
                var regex = new RegExp(persian[i], "g");
                inputstring = inputstring.toString().replace(regex, english[i]);
            }
            return inputstring;
        }

        $(function () {
            $("form#form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    family: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    national_code: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    }

                },
                messages: {
                    name: {
                        required: "لطفا نام خود را وارد نمایید.",
                        minlength: "نام حداقل باید ۳ حرف باشد."
                    },
                    family: {
                        required: "لطفا نام خانوادگی خود را وارد نمایید.",
                        minlength: "نام خانوادگی حداقل باید ۳ حرف باشد."
                    },
                    email: {
                        required: "لطفا ایمیل خود را وارد نمایید.",
                        email: "لطفا یک آدرس ایمیل معتبر وارد کنید"
                    },

                    phone: {
                        required: "لطفا شماره همراه خود را وارد نمایید.",
                        minlength: "شماره همراه حداقل باید ۱۱ کاراکتر باشد.",
                        maxlength: "شماره همراه حداکثر باید ۱۱ کاراکتر باشد.",
                        number: "شماره همراه باید عدد باشد."
                    },
                    national_code: {
                        required: "لطفا کد ملی خود را وارد نمایید.",
                        minlength: "کد ملی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد ملی حداکثر باید ۱۰ کاراکتر باشد.",
                        number: "کد ملی باید عدد باشد."
                    },
                    password: {
                        required: "لطفا رمز عبور را وارد نمایید.",
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation: {
                        required: "لطفا تکرار رمز عبور را وارد نمایید.",
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });

        $(".toggle-password").show();
        $(".toggle-password").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-re-password").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        @foreach($errors->all() as $error)
        setTimeout(function () {
            toastr.options = {
                timeOut: 5000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{$error}}").css("width", "100%")
        }, 1000);
        @endforeach


    </script>
    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

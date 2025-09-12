@extends('Master_Admin::MasterPage')
@section('title')
    ویرایش کاربران
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
    <style>
        #tr_{{$data['id']}}     {
            background: #DCDFE2;
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
                            <li class="breadcrumb-item"><a>کاربران</a>
                            </li>
                            <li class="breadcrumb-item active"><a>ویرایش کاربران</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body"><!-- Basic Horizontal form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <form id="form" class="form form-vertical" name="form" method="post"
                          action="{{route('Users.Edit', [$data['id']])}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ $data['id'] }}" id="userId">
                        <input type="hidden" value="{{$data['user']['id']}}" id="user_id" name="user_id">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="1" name="type" id="type">
                        @if ($userAdmin->user_category_id == 1)
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">اطلاعات دسترسی</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-4 col-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="user_category_id">{{trans('lang.selectUserCategory')}}</label>
                                                        <select
                                                            class="form-control __web-inspector-hide-shortcut__ _category"
                                                            name="user_category_id"
                                                            id="user_category_id" required="">
                                                            <option value="">انتخاب نشده</option>
                                                            @foreach($data['userCategories'] as $item)
                                                                <option value="{{$item['id']}}"
                                                                        @if(in_array($item['id'], $user_category_ids) !== false) selected @endif>{{$item['title']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <div id="modules_user">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card" id="group">
                            <div class="card-header">
                                <h4 class="card-title">اطلاعات گروه</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_name">نام گروه آموزشی :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="group_name"
                                                               name="group_name"
                                                               value="{{$data['user']['group_name']}}"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               placeholder="نام گروه آموزشی"
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
                                                    <label for="group_logo">آرم گروه آموزشی :</label>
                                                    <div class="position-relative has-icon-left">
                                                        @if ($userAdmin->user_category_id != 1)
                                                            <img style="height: 32px;"
                                                                 src="{{asset('upload/group/group_logo/'.$data['user']['group_logo'])}}"
                                                                 alt="">
                                                        @else
                                                            <fieldset>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                    <span class="input-group-text"
                                                                          id="group_logoFile"><i
                                                                            class="bx bx-upload"></i></span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                               id="group_logo"
                                                                               name="group_logo"
                                                                               aria-describedby="group_logoFile">
                                                                        <label class="custom-file-label"
                                                                               for="group_logo">انتخاب فایل</label>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="group_address">‫‫آدرس‬ پستی دفتر مرکزی گروه آموزشی
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <fieldset class="form-group">
                                                            <textarea name="group_address" class="form-control"
                                                                      id="basicTextarea" rows="3"
                                                                      @if ($userAdmin->user_category_id != 1)
                                                                      disabled
                                                                      @endif
                                                                      placeholder="‫آدرس‬ پستی دفتر مرکزی گروه آموزشی">{{$data['user']['group_address']}}</textarea>
                                                        </fieldset>
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-map-pin"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_postalCode">کد پستی دفتر مرکزی گروه آموزشی
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control char-textarea2" id="group_postalCode"
                                                               name="group_postalCode"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               value="{{$data['user']['group_postalCode']}}"
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               placeholder="کد پستی">

                                                        <div class="form-control-position">
                                                            <i class="bx bx-mail-send"></i>
                                                        </div>
                                                        <small class="counter-value float-right"><span
                                                                class="char-count2">0</span> / 10 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_phone">شماره تلفن دفتر مرکزی گروه آموزشی
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="group_phone"
                                                               name="group_phone"
                                                               value="{{$data['user']['group_phone']}}"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               placeholder="شماره تلفن">

                                                        <div class="form-control-position">
                                                            <i class="bx bx-phone-call"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card" id="users">
                            <div class="card-header">
                                <h4 class="card-title">اطلاعات کاربری</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name">نام</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="name"
                                                               name="name"
                                                               value="{{$data['user']['name']}}"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               placeholder="نام"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="family">نام خانوادگی</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="family"
                                                               name="family"
                                                               value="{{$data['user']['family']}}"
                                                               placeholder="نام خانوادگی"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-group"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="national_code">نام کاربری (کد ملی)</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="national_code"
                                                               class="form-control char-textarea1"
                                                               name="national_code"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               value="{{$data['user']['national_code']}}"
                                                               placeholder="نام کاربری (کد ملی)">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-id-card"></i>
                                                        </div>
                                                        <small class="counter-value float-right"><span
                                                                class="char-count1">0</span> / 10 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password">رمز عبور جدید</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password" class="form-control"
                                                               name="password"
                                                               value=""
                                                               placeholder="رمز عبور جدید">
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
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">تکرار رمز عبور</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_confirmation"
                                                               class="form-control"
                                                               name="password_confirmation"
                                                               value=""
                                                               placeholder="تکرار رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock-alt"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_confirmation"
                                                               class="bx bxs-show  toggle-re-password"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone">شماره همراه</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="phone" class="form-control char-textarea"
                                                               name="phone"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               data-length="11"
                                                               minlength="11" maxlength="11"
                                                               value="{{$data['user']['phone']}}"
                                                               placeholder="شماره همراه">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                        <small class="counter-value float-right"><span
                                                                class="char-count">0</span> / 11 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">ایمیل</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="email" class="form-control"
                                                               value="{{$data['user']['email']}}"
                                                               @if ($userAdmin->user_category_id != 1)
                                                               disabled
                                                               @endif
                                                               name="email" placeholder="ایمیل"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <fieldset class="form-group">
                                                    <label for="address">آدرس</label>
                                                    <textarea
                                                        @if ($userAdmin->user_category_id != 1)
                                                        disabled
                                                        @endif
                                                        class="form-control" name="address" id="address" rows="2"
                                                        placeholder="آدرس">{{$data['user']['address']}}</textarea>
                                                </fieldset>
                                            </div>
                                            @if ($userAdmin->user_category_id == 1)
                                                <hr style="width: 100%">
                                                <div class="col-md-12 col-12">
                                                    <div
                                                        class="custom-control custom-switch custom-switch-status custom-switch-success mr-2 mb-1">
                                                        <p class="mb-0">وضعیت</p>
                                                        <input name="status" type="checkbox"
                                                               class="custom-control-input"
                                                               id="status"
                                                               value="1" @if($data['user']['status']==1)
                                                            {{'checked'}}
                                                            @endif>
                                                        <label class="custom-control-label" for="status">
                                                        <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                            <span class="switch-icon-right"><i
                                                                    class="bx bx-x"></i></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif

                                            <br>
                                            <hr>
                                            <div class="col-md-6 col-6 ">

                                                @if ($userAdmin->user_category_id == 1)
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">ویرایش
                                                    </button>
                                                @else
                                                    <div id="btnVerifyDiv">
                                                        <a onClick="$(this).closest('#form').submit();"
                                                           class="btn btn-primary mr-1 mb-1" id="btnVerify">دریافت
                                                            تاییدیه تلفن همراه</a>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-6">
                                                @if(Auth()->user()->hasPermission('Users.Add'))
                                                    <a href="{{route('Users.Add')}}"
                                                       class="btn btn-danger mr-1 mb-1">انصراف</a>
                                                @else
                                                    <a href="{{route('list')}}"
                                                       class="btn btn-danger mr-1 mb-1">انصراف</a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    @if(Auth()->user()->hasPermission('Users.List'))
                        @if(!$users->isEmpty())
                            <div class="card">
                                <div class="scrollbar-external_wrapper">
                                    <div class="scrollbar-external">
                                        <div class="table-">
                                            <table id="table-extended-chechbox" class="table table-transparent">
                                                <thead>
                                                <tr>
                                                    <th style="display: none"></th>
                                                    <th>شناسه</th>
                                                    <th>کد ملی</th>
                                                    <th>نام و نام خانوادگی</th>
                                                    <th>شماره همراه</th>
                                                    <th>سطح</th>
                                                    <th>وضعیت</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($users as $item)
                                                    <tr class="text-center" id="tr_{{$item['id']}}">
                                                        <td style="display: none"></td>
                                                        <td class="text-bold-500">{{$item['id']}}</td>
                                                        <td>{{$item['national_code']}}</td>
                                                        <td>{{$item['name']}} {{$item['family']}}</td>
                                                        <td>{{$item['phone']}}</td>
                                                        <td>
                                                            @if($item->usercategory)
                                                                {{$item->usercategory->title}}
                                                            @endif
                                                        </td>
                                                        <td id="status_{{$item['id']}}">
                                                            @if($item['status']==1)
                                                                {{'فعال'}}
                                                            @else
                                                                {{'غیر فعال'}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="external-scroll_x">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar"></div>
                                        </div>
                                    </div>

                                    <div class="external-scroll_y">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 text-right stocks_list">
                            </div>
                        @else
                            <div class="text-center">
                                <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                     style="width: 200px;margin: 0 auto" alt="">
                                <p class="pt10">
                                    آیتمی جهت نمایش وجود ندارد!
                                </p>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
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


        $(document).ready(function () {
            $('.scrollbar-external').scrollbar({
                "autoScrollSize": false,
                "scrollx": $('.external-scroll_x'),
                "scrolly": $('.external-scroll_y')
            });
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
            $("#group_postalCode").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#national_code").val(persianToEnglish($(this).val()));
                }
            });
            $("#group_phone").keyup(function (e) {
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
                    @if ($userAdmin->user_category_id != 1)
                    password: {
                        minlength: 5,
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    @else
                    password: {
                        minlength: 5
                    },
                    password_confirmation: {
                        minlength: 5,
                        equalTo: "#password"
                    },
                    @endif


                    "user_category_id": "required",

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
                    @if ($userAdmin->user_category_id != 1)
                    password: {
                        required: "لطفا رمز عبور را وارد نمایید.",
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation: {
                        required: "لطفا تکرار رمز عبور را وارد نمایید.",
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },
                    @else
                    password: {
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation: {
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },
                    @endif


                    "user_category_id": "لطفا گروه کاربر را انتخاب نمایید.",
                },
                submitHandler: function (form) {

                    @if ($userAdmin->user_category_id != 1)
                    $(document).on("click", "#btnVerify", function () {
                        var password = $("#password").val();
                        var phone = $("#phone").val();
                        var userId = $("#userId").val();
                        var _token = $("#_token").val();
                        var passwordLe = $("#password").val().length;
                        if (password == "") {
                            Command: toastr["error"]("رمز عبور جدید خود را وارد نمایید", "");
                        } else {
                            $("#btnVerify").hide();
                            $.ajax({
                                type: "post",
                                url: "{{route('Users.sendCode')}}",
                                data: {password: password, phone: phone, userId: userId, _token: _token},
                                success: function (btnVerifyDiv) {
                                    if ($.isEmptyObject(btnVerifyDiv.error)) {
                                        Command: toastr["success"]("کد چهار رقمی به شماره همراه شما ارسال گردید.", "");
                                        $("#btnVerify").hide();
                                        $("#btnVerifyDiv").html("").html(btnVerifyDiv);
                                    } else {
                                        $("#btnVerify").hide();
                                        printErrorMsg(btnVerifyDiv.error);
                                    }
                                }
                            });

                            function printErrorMsg(msg2) {
                                $.each(msg2, function (key2, value2) {
                                    Command: toastr["error"](value2);
                                });
                            }
                        }

                        return false;
                    });
                    @else
                    form.submit();
                    @endif


                }
            });
        });

        $('#group').css("display", "none");
        $('#user').css("display", "none");
        $("#group_logo").change(function (e) {
            var ext = $("#group_logo").val().split(".").pop().toLowerCase();
            if ($.inArray(ext, ["png"]) == -1) {
                $(document).ready(function () {
                    Command: toastr["error"]("تصویر آرم گروه آموزشی حتما بايد با پسوند png باشد.", "");
                });
                $("#group_logo").val("");
                a = 0;
            } else {
                var picsize = (this.files[0].size);
                if (picsize > 1000000) {
                    Command: toastr["error"](" حداکثر حجم تصویر آرم گروه آموزشی ۱ مگابايت مي باشد.", "");
                    $("#group_logo").val("");
                    a = 0;
                } else {
                    a = 1;
                }
            }
        });
        $(document).on("click", "#disabled", function () {
            return false;
        });
        $(document).on("click", "#checkVerify", function () {
            var code = $("#code").val();
            var userCode = $("#userCode").val();
            if (code == "") {
                Command: toastr["error"]("لطفا کد ۴ رقمی را وارد نمایید", "");
            } else {
                if (userCode == code) {
                    var usId = $("#usId").val();
                    var pass = $("#pass").val();
                    var _token = $("#_token").val();
                    $("#checkVerify").hide();
                    $("#code").hide();
                    $.ajax({
                        type: "post",
                        url: "{{route('Users.checkCode')}}",
                        data: {usId: usId, pass: pass, _token: _token},
                        success: function (checkCode) {
                            Command: toastr["success"]("رمز عبور شما با موفقیت تغییر یافت.", "");
                            $("#checkVerify").hide();
                            $("#code").hide();
                            window.setTimeout(function () {
                                location.reload()
                            }, 3000)
                        }
                    });
                } else {
                    Command: toastr["error"]("کد ۴ رقمی وارد شده اشتباه می باشد", "");
                }
            }
            return false;
        });
        $(function () {
            $("#code").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#code").val(persianToEnglish($(this).val()));
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

        @if($user_category_ids[0] == 1)
        $('#group').css("display", "none");
        $('#user').css("display", "block");
        @else
        $('#group').css("display", "block");
        $('#user').css("display", "block");
        @endif
        @if ($userAdmin->user_category_id == 1)
        edit();

        $('#user_category_id').change(function () {
            edit();
        });
        function edit() {
            if ($('#user_category_id').val() != 0) {
                $('#modules_user').html('');
                $.get("../Ajax_GetUserCategoryPermission",
                    {
                        _token: $('#nekot').val(),
                        userCategoryId: $('#user_category_id').val(),
                        user_id: $('#user_id').val()
                    },
                    function (data, status) {
                        $('#modules_user').html('').html(data);

                    });
            } else if ($('#user_category_id').val() == 0) {
                $('#modules_user').html('');
            }
        }
        @endif
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
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                "sEmptyTable": "هیچ داده ای در جدول وجود ندارد",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            }
        });
        // table extended checkbox
        var tablecheckbox = $('#table-extended-chechbox').DataTable({
            "searching": true,
            "lengthChange": true,
            "paging": false,
            "bInfo": false,
            'columnDefs': [{
                "orderable": false,
                "targets": [0, 5, 6]
            }, //to disable sortying in col 0,3 & 4

            ],
            'select': 'multi',
            'order': [
                [1, 'desc']
            ]
        });

    </script>
    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

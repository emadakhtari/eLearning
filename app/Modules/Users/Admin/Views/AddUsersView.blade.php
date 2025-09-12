@extends('Master_Admin::MasterPage')
@section('title')
    کاربران
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
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
                            <li class="breadcrumb-item "><a>کاربران</a>
                            </li>
                            <li class="breadcrumb-item active"><a>افزودن کاربران</a>
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
                          action="{{route('Users.Add')}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="1" name="type" id="type">
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
                                                        name="user_category_id[]"
                                                        id="user_category_id" required="">
                                                        <option value="">انتخاب نشده</option>
                                                        @foreach($userCategories as $userCategory)
                                                            <option
                                                                value="{{$userCategory['id']}}">{{$userCategory['title']}}</option>
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
                                                               value="{{old('group_name')}}"
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
                                                                      placeholder="‫آدرس‬ پستی دفتر مرکزی گروه آموزشی">{{old('group_address')}}</textarea>
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
                                                               value="{{old('group_postalCode')}}"
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
                        <div class="card" id="user">
                            <div class="card-header">
                                <h4 class="card-title">اطلاعات کاربری</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name">نام :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="name"
                                                               name="name"
                                                               value="{{old('name')}}"
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
                                                    <label for="family">نام خانوادگی :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="family"
                                                               name="family"
                                                               value="{{old('family')}}"
                                                               placeholder="نام خانوادگی"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-group"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="national_code">نام کاربری (کد ملی) :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="national_code"
                                                               class="form-control char-textarea"
                                                               name="national_code"
                                                               value="{{old('national_code')}}"
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
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password">رمز عبور :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password" class="form-control"
                                                               name="password"
                                                               placeholder="رمز عبور"
                                                               required="">
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
                                                    <label for="password_confirmation">تکرار رمز عبور :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_confirmation"
                                                               class="form-control"
                                                               name="password_confirmation"
                                                               placeholder="تکرار رمز عبور"
                                                               required="">
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
                                                    <label for="phone">شماره همراه :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="phone" class="form-control char-textarea1"
                                                               name="phone"
                                                               value="{{old('phone')}}"
                                                               data-length="11"
                                                               minlength="11" maxlength="11"
                                                               placeholder="شماره همراه"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                        <small class="counter-value float-right"><span
                                                                class="char-count1">0</span> / 11 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">ایمیل :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="email" class="form-control"
                                                               name="email" placeholder="ایمیل"
                                                               value="{{old('email')}}"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="address">آدرس :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <fieldset class="form-group">
                                                            <textarea name="address" class="form-control" id="address"
                                                                      rows="3" placeholder="آدرس">{{old('address')}}</textarea>
                                                        </fieldset>
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user-pin"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr style="width: 100%">
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
                                                    <th style="width: 24px !important;"><i class="bx bx-x" style=""></i>
                                                    </th>
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
                                                        <td>
                                                            @if(Auth()->user()->hasPermission('Users.Edit'))
                                                                <fieldset>
                                                                    <div class="radio radio-shadow">
                                                                        <input type="radio" class="radioshadow"
                                                                               id="radioshadow{{$item['id']}}"
                                                                               name="edit"
                                                                               value="{{$item['id']}}">
                                                                        <label for="radioshadow{{$item['id']}}"></label>
                                                                    </div>
                                                                </fieldset>
                                                            @endif
                                                        </td>
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
            $('input[type=radio][name=edit]').change(function () {
                var url = '{{ route("Users.Edit", ":id") }}';

                url = url.replace(':id', this.value);
                $(".stocks_list a").remove();
                $('.stocks_list').append('<a class="btn btn-primary mr-1 mb-1 edit-btn" style="float:right" href="' + url + '">ویرایش </a></li>');
            });


            $('.radioshadow').click(function () {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".bx-x").not(targetBox).css("display", "block");
                $(".edit-btn").not(targetBox).css("display", "block");
                $(targetBox).hide();
            });
            $('.bx-x').click(function () {
                $(".radioshadow").prop("checked", false);
                $(".bx-x").css("display", "none");
                $(".stocks_list a").remove();
            });

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
                      },
                      "user_category_id[]": "required",

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
                      },
                      "user_category_id[]": "لطفا گروه کاربر را انتخاب نمایید.",
                  },
                  submitHandler: function (form) {
                      form.submit();
                  }
              });
          });
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
        $('#group').css("display", "none");
        $('#user').css("display", "none");
        $(function () {
            var html_data = '';
            $('#user_category_id').change(function () {
                if ($('#user_category_id').val() == 1) {
                    $('#group').css("display", "none");
                    $('#user').css("display", "block");
                } else if ($('#user_category_id').val() == 0) {
                    $('#group').css("display", "none");
                    $('#user').css("display", "none");
                } else {
                    $('#group').css("display", "block");
                    $('#user').css("display", "block");
                }
                html_data = '';
                if ($('#user_category_id').val() != 0) {
                    $('#modules_user').html('');
                    $.get("Ajax_GetUserCategoryPermission",
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

@extends('Master_Admin::MasterPage')
@section('title')
    مدرس
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
                            <li class="breadcrumb-item "><a>مدرس</a>
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
                    @if($deputyAdmin->hasPermission('Teacher.Add.View') || $deputyAdmin->level == "1")
                        <form id="form" class="form form-vertical" name="form" method="post"
                              action="{{route('Teacher.Add')}}" enctype="multipart/form-data">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                            <input type="hidden" value="{{$deputyId}}" name="deputy_id" id="deputy_id">
                            <input type="hidden" value="{{$SchoolSelect->id}}" name="school_id" id="school_id">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="name">نام مدرس :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="name"
                                                                   name="name"
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
                                                        <label for="family">نام خانوادگی مدرس :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="family"
                                                                   name="family"
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
                                                        <label for="national_code">نام کاربری (کد ملی) مدرس :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="national_code"
                                                                   class="form-control char-textarea"
                                                                   name="national_code"
                                                                   data-length="10"
                                                                   minlength="10" maxlength="10"
                                                                   placeholder="نام کاربری (کد ملی)">
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
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="password_confirmation">تکرار رمز عبور :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" id="password_confirmation"
                                                                   class="form-control"
                                                                   name="password_confirmation"
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
                                                        <label for="phone">شماره همراه مدرس :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="phone"
                                                                   class="form-control char-textarea1"
                                                                   name="phone"
                                                                   data-length="11"
                                                                   minlength="11" maxlength="11"
                                                                   placeholder="شماره همراه">
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
                                                        <label for="email">ایمیل مدرس :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="email" class="form-control"
                                                                   name="email" placeholder="ایمیل"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-envelope"></i>
                                                            </div>
                                                        </div>
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
                    @endif
                </div>
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    @if($deputyAdmin->hasPermission('Teacher.List.View') || $deputyAdmin->level == "1")
                        <div class="lds-ripple-content">
                            <div class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div id="TeacherTable">
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="gradeCur">
@stop
@section('js')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">

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

        $(document).ready(function () {
            var school_id = $("#school_id").val();
            var deputy_id = $("#deputy_id").val();
            var _token = $("#_token").val();
            $(".lds-ripple-content").fadeIn('slow');
            $.ajax({
                type: 'POST',
                url: '{{route('Teacher.Table')}}',
                data: {school_id: school_id, deputy_id: deputy_id, _token: _token},
                success: function (TeacherTable) {
                    $('#TeacherTable').html(TeacherTable);
                    $(".lds-ripple-content").fadeOut('slow');
                }
            });
        });


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
                },
                messages: {
                    name: {
                        required: "لطفا نام مدرس را وارد نمایید.",
                        minlength: "نام حداقل باید ۳ حرف باشد."
                    },
                    family: {
                        required: "لطفا نام خانوادگی مدرس را وارد نمایید.",
                        minlength: "نام خانوادگی حداقل باید ۳ حرف باشد."
                    },
                    email: {
                        required: "لطفا ایمیل مدرس را وارد نمایید.",
                        email: "لطفا یک آدرس ایمیل معتبر وارد کنید"
                    },

                    phone: {
                        required: "لطفا شماره همراه مدرس را وارد نمایید.",
                        minlength: "شماره همراه حداقل باید ۱۱ کاراکتر باشد.",
                        maxlength: "شماره همراه حداکثر باید ۱۱ کاراکتر باشد.",
                        number: "شماره همراه باید عدد باشد."
                    },
                    national_code: {
                        required: "لطفا کد ملی مدرس را وارد نمایید.",
                        minlength: "کد ملی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد ملی حداکثر باید ۱۰ کاراکتر باشد.",
                        number: "کد ملی باید عدد باشد."
                    },
                    password: {
                        required: "لطفا رمز عبور مدرس را وارد نمایید.",
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation: {
                        required: "لطفا تکرار رمز عبور را وارد نمایید.",
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },
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

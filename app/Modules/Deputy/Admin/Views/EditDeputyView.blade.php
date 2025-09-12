@extends('Master_Admin::MasterPage')
@section('title')
    پروفایل معاونت آموزش
@endsection
@section('CSS')
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
                            <li class="breadcrumb-item active"><a>پروفایل معاونت آموزش</a>
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
                <div class="col-12 col-sm-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <form id="form" class="form form-vertical" name="form" method="post"
                          action="{{route('Deputy.Edit', [$data['id']])}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ $data['id'] }}" id="userId">
                        <input type="hidden" value="{{$data['deputy']['phone']}}" name="phone" id="phone">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="1" name="type" id="type">
                        <div class="card" id="group">
                            <div class="card-header">
                                <h4 class="card-title">اطلاعات مرکز آموزش</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="group_postalCode">نوع مرکز آموزش
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="typeSchool"
                                                               value="{{$GradeSelect->title}}"
                                                               disabled
                                                               placeholder="نوع مرکز آموزش">
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-school"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_postalCode">نام مرکز آموزش
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="titleSchool"
                                                               value="{{$SchoolSelect->title}}"
                                                               disabled
                                                               placeholder="نام مرکز آموزش">
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-school"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="float-right" style="position: relative;width: 150px;">
                                                <span style="position: absolute;top: 32px;">آدرس پستی مرکز آموزش</span>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label for="group_postalCode">استان
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="provinceSchool"
                                                               value="{{$provinceSelect->State_Name}}"
                                                               disabled
                                                               placeholder="استان">
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-map-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label for="group_postalCode">شهر
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="citySchool"
                                                               value="{{$cityeSelect->City_Name}}"
                                                               disabled
                                                               placeholder="شهر">
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-city"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="group_postalCode">آدرس
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="addressSchool"
                                                               value="{{$SchoolSelect->address}}"
                                                               disabled
                                                               placeholder="آدرس">
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-map-pin"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label for="group_postalCode">کد پستی مرکز آموزش
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="postal_codeSchool"
                                                               value="{{$SchoolSelect->postal_code}}"
                                                               disabled
                                                               placeholder="کد پستی مرکز آموزش">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mail-send"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="float-right" style="position: relative;width: 150px;">
                                                <span style="position: absolute;top: 32px;">شماره تلفن مرکز آموزش</span>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label for="group_postalCode">شماره تلفن
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="phoneSchool"
                                                               value="{{$SchoolSelect->phone}}"
                                                               disabled
                                                               placeholder="شماره تلفن">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-phone-call"></i>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-2 col-sm-3 col-md-2 col-lg-1 col-xl-1">
                                                <div class="form-group">
                                                    <label for="group_postalCode">پیش شماره
                                                        :</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control pl0 pr0 text-center" id="area_codeSchool"
                                                               value="{{$SchoolSelect->area_code}}"
                                                               disabled
                                                               placeholder="پیش شماره">
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
                                                               value="{{$data['deputy']['name']}}"
                                                               disabled
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
                                                               value="{{$data['deputy']['family']}}"
                                                               placeholder="نام خانوادگی"
                                                               disabled
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
                                                               class="form-control char-textarea"
                                                               name="national_code"
                                                               disabled
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               value="{{$data['deputy']['national_code']}}"
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
                                                    <label for="phoneShow">شماره همراه</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="phoneShow" class="form-control char-textarea"
                                                               disabled
                                                               data-length="11"
                                                               minlength="11" maxlength="11"
                                                               value="{{$data['deputy']['phone']}}"
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
                                                               value="{{$data['deputy']['email']}}"
                                                               disabled
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
                                                <div id="btnVerifyDiv">
                                                    <a onClick="$(this).closest('#form').submit();"
                                                       class="btn btn-primary mr-1 mb-1" id="btnVerify">دریافت
                                                        تاییدیه تلفن همراه</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <a href="{{route('list')}}"
                                                   class="btn btn-danger mr-1 mb-1">انصراف</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>

@stop
@section('js')
    <!-- BEGIN: Page Vendor JS-->
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">

        $(function () {
            $("form#form").validate({
                rules: {
                    password: {
                        minlength: 5
                    },
                    password_confirmation: {
                        minlength: 5,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation: {
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },
                },
                submitHandler: function (form) {
                    $(document).on("click", "#btnVerify", function () {
                        var password = $("#password").val();
                        var userId = $("#userId").val();
                        var phone = $("#phone").val();
                        var _token = $("#_token").val();
                        var passwordLe = $("#password").val().length;
                        if (password == "") {
                            Command: toastr["error"]("رمز عبور جدید خود را وارد نمایید", "");
                        } else {
                            $("#btnVerify").hide();
                            $.ajax({
                                type: "post",
                                url: "{{route('Deputy.sendCode')}}",
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
                }
            });
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
                    $("#checkVerify").hide();
                    $("#code").hide();
                    var usId = $("#userId").val();
                    var pass = $("#pass").val();
                    var _token = $("#_token").val();
                    $.ajax({
                        type: "post",
                        url: "{{route('Deputy.checkCode')}}",
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

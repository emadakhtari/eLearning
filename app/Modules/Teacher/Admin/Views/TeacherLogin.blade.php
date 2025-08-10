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
    <link rel="stylesheet" type="text/css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href=" {{asset('Assets/Admin/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/themes/dark-layout.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/themes/semi-dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/core/menu/menu-types/vertical-menu.css')}}">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/pages/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/pages/jquery.countdown.css')}}">
    <style>
        #countdown {
            padding: 5%;
        }

        .countDays {
            display: none !important;
        }

        .countDiv0 {
            display: none !important;
        }

        .countHours {
            display: none !important;
        }

        .countDiv1 {
            display: none !important;
        }
        #captcha {
            width: 40%;
            float: right;;
        }
        #refreshcpatcha {
            display: block;
            height: 38px;
            float: right;
            line-height: 38px;
            margin-right: 10px;
        }
        #refreshcpatcha i{
            display: block;
            height: 38px;
            line-height: 38px;
            font-size: 25px;
        }
        #captchaimg {
            height: 100%;
            float: left;
        }
        #captchaimg img {
            width: 100%;
        }
        .claer {
            clear: both;
        }
        p{
            margin-bottom: 0;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body
    class="vertical-layout vertical-menu-modern 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- login page start -->
            <section id="auth-login" class="row flexbox-container">
                <div class="col-xl-8 col-11">
                    <div class="card bg-authentication mb-0">
                        <div class="row m-0">
                            <!-- left section-login -->
                            <div class="col-md-6 col-12 px-0">
                                <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h5 class="text-center mb-0">خوش آمدید</h5>
                                            @if($setting->software_text)
                                                {!! $setting->software_text !!}
                                            @endif
                                            @if($setting->owner_text)
                                                {!! $setting->owner_text !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <input type="hidden" value="{{ csrf_token() }}" id="nekot">
                                            <div class="divider">
                                                <div class="divider-text text-uppercase text-muted">
                                                    <small>
                                                        لطفا اطلاعات زیر را برای ورود به سامانه وارد نمائید :
                                                    </small>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group mb-50">

                                                    <input type="text" class="form-control text-left char-textarea"
                                                           data-length="10"
                                                           minlength="10" maxlength="10"
                                                           name="national_code"
                                                           id="national_code" placeholder="کد ملی" dir="ltr">
                                                    <small class="counter-value float-right"><span
                                                            class="char-count">0</span> / 10 </small>
                                                </div>
                                                <br>
                                                <div class="form-group mb-50">
                                                    <input type="password" class="form-control text-left"
                                                           name="password"
                                                           id="password" placeholder="رمز ورود به سامانه" dir="ltr">
                                                </div>
                                                <div class="form-group mb-50">
                                                    <input type="text" class="form-control text-left"
                                                           autofocus
                                                           {{--                                                           autocomplete="nope"--}}
                                                           {{--                                                           autocomplete="new-password"--}}
                                                           name="captcha"
                                                           id="captcha" placeholder="تصویر امنیتی" dir="ltr">
                                                    <a href="#" id="refreshcpatcha" onclick="return false;"><i
                                                            class="bx bx-reset"></i></a>
                                                    <div id="captchaimg">
                                                        {!! captcha_img() !!}
                                                    </div>
                                                    <div class="claer"></div>
                                                </div>
                                                <br>
                                                <input type="hidden" name="setAjax" id="setAjax" value="login">
                                                <button type="submit"
                                                        id="submit-step-one"
                                                        class="btn btn-primary glow w-100 position-relative">ورود<i
                                                        id="icon-arrow" class="bx bx-left-arrow-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- right section image -->
                            <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                <div class="card-content">
                                    @if($setting->login_image)
                                        <img class="img-fluid" src="{{asset('upload/setting/'.$setting->login_image)}}"
                                             alt="branding logo" style="border: 4px solid #f87008;">
                                    @endif
                                </div>
                            </div>
                            <!-- right section image -->
                            <div class="col- 12 col-md-12">
                                <div class="card-content">
                                    <br>
                                    <hr>
                                    <div style="text-align: center">
                                        @if($setting->powered_text)
                                            {!! $setting->powered_text !!}
                                        @endif
                                        @if($setting->license_text)
                                            {!! $setting->license_text !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- login page ends -->

        </div>
    </div>
</div>
<!-- END: Content-->

<!-- BEGIN: Vendor JS-->
<script type="text/javascript"
        src="{{asset('Assets/Admin/vendors/js/vendors.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>

<script type="text/javascript">
    $("#refreshcpatcha").click(function () {
        $("#captchaimg img").attr("src", $('#captchaimg img').attr('src') + '?' + Math.random());
    });
    $(function () {
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

    $(".toggle-password").hide();
    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    $('.spinner-grow').hide();
    $('#submit-step-one').click(function () {
        var national_code = $('#national_code').val();
        var is_valid_StepOne = true;
        if (national_code == '') {
            is_valid_StepOne = false;
            toastr.error('لطفا کد ملی خود را وارد کنید.');
        } else {
            var intRegex = /^\d+$/;
            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
            var str = $('#national_code').val();
            if (intRegex.test(str) || floatRegex.test(str)) {
                if ($('#national_code').val().length == 10) {
                    $('.spinner-grow').fadeIn('slow');
                    $("#submit-step-one").attr("disabled", true);
                    if (is_valid_StepOne) {
                        var national_code = $('#national_code').val();
                        var password = $('#password').val();
                        var captcha = $('#captcha').val();
                        var is_valid = true;

                        if (national_code == '') {
                            is_valid = false;
                        } else if (password == '') {
                            toastr.error("لطفا رمز خود را وارد کنید.").css("width", "100%");

                            var $elt = $('#submit-step-one').attr('disabled', true);
                            setTimeout(function () {
                                $elt.attr('disabled', false);
                            }, 1000);
                        } else if (captcha == '') {
                            toastr.error("لطفا تصویر امنیتی را وارد کنید.").css("width", "100%");
                            var $elt = $('#submit-step-one').attr('disabled', true);
                            setTimeout(function () {
                                $elt.attr('disabled', false);
                            }, 1000);
                        } else {

                            var intRegex = /^\d+$/;
                            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
                            var password = $('#password').val();
                            $('.spinner-grow').fadeIn('slow');
                            $.post("TeacherCheckPassword",
                                {
                                    _token: $('#nekot').val(),
                                    national_code: national_code,
                                    password: password,
                                    captcha: captcha
                                },
                                function (data, status) {
                                    $("#ResultStepOne").html('').html(data);
                                    console.log(data);
                                    if (data['status'] == 'true') {
                                        window.location = data['url'];
                                    } else if (data['status'] == 'false') {
                                        if (data['output'] == 'wrongPass') {
                                            $("#captchaimg img").attr("src", $('#captchaimg img').attr('src') + '?' + Math.random());
                                            $("#captcha").val("");
                                            toastr.error("رمز وارد شده صحیح نمی باشد.").css("width", "100%");
                                            var $elt = $('#submit-step-one').attr('disabled', true);
                                            setTimeout(function () {
                                                $elt.attr('disabled', false);
                                            }, 1000);
                                        } else if (data['output'] == 'wrongCaptcha') {
                                            $("#captchaimg img").attr("src", $('#captchaimg img').attr('src') + '?' + Math.random());
                                            $("#captcha").val("");
                                            toastr.error("تصویر امنیتی وارد شده صحیح نمی باشد.").css("width", "100%");
                                            var $elt = $('#submit-step-one').attr('disabled', true);
                                            setTimeout(function () {
                                                $elt.attr('disabled', false);
                                            }, 1000);
                                        } else if (data['output'] == 'wrongCode') {
                                            $("#captchaimg img").attr("src", $('#captchaimg img').attr('src') + '?' + Math.random());
                                            $("#captcha").val("");
                                            toastr.error("کد ملی وارد شده در سامانه مجود نمی باشد.").css("width", "100%");
                                            var $elt = $('#submit-step-one').attr('disabled', true);
                                            setTimeout(function () {
                                                $elt.attr('disabled', false);
                                            }, 1000);
                                        }

                                    }
                                });
                        }

                    } else {
                        $('.spinner-grow').fadeOut('slow');
                        var $elt = $('#submit-step-one').attr('disabled', true);
                        setTimeout(function () {
                            $elt.attr('disabled', false);
                        }, 1000);
                    }
                } else {
                    toastr.error('کد ملی باید ۱۰ عدد باشد.');
                }
            } else {
                toastr.error('کد ملی صحیح وارد نمایید.');
            }
        }
    });


</script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/configs/vertical-menu-dark.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/core/app-menu.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/core/app.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/components.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/footer.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/pages/toastr.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Assets/Admin/js/scripts/pages/jquery.countdown.js')}}"></script>
<!-- END: Page JS-->

</body>
<!-- END: Body-->
</html>

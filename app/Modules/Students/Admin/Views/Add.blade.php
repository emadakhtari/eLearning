@extends('Master_Admin::MasterPage')
@section('title')
    دانش آموز
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
                            <li class="breadcrumb-item "><a>دانش آموز</a>
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
                    @if($deputyAdmin->hasPermission('Students.Add.View') || $deputyAdmin->level == "1")
                        <form id="form" class="form form-vertical" name="form" method="post"
                              action="{{route('Students.Add')}}" enctype="multipart/form-data">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                            <input type="hidden" value="{{$deputyId}}" name="deputy_id" id="deputy_id">
                            <input type="hidden" value="{{$assignSelect->grade_id}}" name="grade_id" id="grade_id">
                            <input type="hidden" value="{{$SchoolSelect->id}}" name="school_id" id="school_id">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="base_id">پایه تحصیلی</label>
                                                        <select
                                                            class="form-control select2 __web-inspector-hide-shortcut__ _base_id"
                                                            name="base_id"
                                                            id="base_id" required="">
                                                            <option value="">انتخاب نشده</option>
                                                            @foreach($baseSelect as $item)
                                                                <option
                                                                    @if(old('base_id') == $item->id) selected @endif
                                                                value="{{$item['id']}}">{{$item['title']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="grade_id">کلاس</label>
                                                        <select
                                                            class="form-control __web-inspector-hide-shortcut__ _class_id"
                                                            name="class_id"
                                                            id="class_id" required="">
                                                            <option value="">انتخاب نشده</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">اطلاعات دانش آموز</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="student_name">نام دانش آموز :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="student_name"
                                                                   name="student_name"
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
                                                        <label for="student_family">نام خانوادگی دانش آموز :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="student_family"
                                                                   name="student_family"
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
                                                        <label for="student_national_code">نام کاربری (کد ملی) دانش آموز
                                                            :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="student_national_code"
                                                                   class="form-control char-textarea"
                                                                   name="student_national_code"
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
                                                        <label for="student_password">رمز عبور دانش آموز :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" id="student_password"
                                                                   class="form-control"
                                                                   name="student_password"
                                                                   placeholder="رمز عبور"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-lock"></i>
                                                            </div>
                                                            <div class="eIcov">
                                                                <i toggle="#student_password"
                                                                   class="bx bxs-show  toggle-password students_toggle-password"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="student_password_confirmation">تکرار رمز عبور دانش
                                                            آموز :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" id="student_password_confirmation"
                                                                   class="form-control"
                                                                   name="student_password_confirmation"
                                                                   placeholder="تکرار رمز عبور"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-lock-alt"></i>
                                                            </div>
                                                            <div class="eIcov">
                                                                <i toggle="#student_password_confirmation"
                                                                   class="bx bxs-show  toggle-re-password students_toggle-re-password"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="student_phone">شماره همراه دانش آموز :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="student_phone"
                                                                   class="form-control char-textarea1"
                                                                   name="student_phone"
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
                                                        <label for="student_email">ایمیل دانش آموز :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="student_email" class="form-control"
                                                                   name="student_email" placeholder="ایمیل"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-envelope"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="image">عکس پرسنلی دانش آموز :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <fieldset>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                    <span class="input-group-text"
                                                                          id="imageFile"><i
                                                                            class="bx bx-upload"></i></span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                               id="image"
                                                                               name="image"
                                                                               aria-describedby="imageFile">
                                                                        <label class="custom-file-label"
                                                                               for="image">انتخاب فایل</label>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">اطلاعات ولی دانش آموز</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="parents_name">نام ولی :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="parents_name"
                                                                   name="parents_name"
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
                                                        <label for="parents_family">نام خانوادگی ولی :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="parents_family"
                                                                   name="parents_family"
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
                                                        <label for="parents_national_code">نام کاربری (کد ملی) ولی
                                                            :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="parents_national_code"
                                                                   class="form-control char-textarea2"
                                                                   name="parents_national_code"
                                                                   data-length="10"
                                                                   minlength="10" maxlength="10"
                                                                   placeholder="نام کاربری (کد ملی)"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-id-card"></i>
                                                            </div>
                                                            <small class="counter-value float-right"><span
                                                                    class="char-count2">0</span> / 10 </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="parents_password">رمز عبور ولی :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" id="parents_password"
                                                                   class="form-control"
                                                                   name="parents_password"
                                                                   placeholder="رمز عبور"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-lock"></i>
                                                            </div>
                                                            <div class="eIcov">
                                                                <i toggle="#parents_password"
                                                                   class="bx bxs-show  toggle-password parentsـtoggle-password"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="parents_password_confirmation">تکرار رمز عبور ولی
                                                            :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" id="parents_password_confirmation"
                                                                   class="form-control"
                                                                   name="parents_password_confirmation"
                                                                   placeholder="تکرار رمز عبور"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-lock-alt"></i>
                                                            </div>
                                                            <div class="eIcov">
                                                                <i toggle="#parents_password_confirmation"
                                                                   class="bx bxs-show  toggle-re-password parents_toggle-re-password"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="parents_phone">شماره همراه ولی :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="parents_phone"
                                                                   class="form-control char-textarea3"
                                                                   name="parents_phone"
                                                                   data-length="11"
                                                                   minlength="11" maxlength="11"
                                                                   placeholder="شماره همراه"
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-mobile"></i>
                                                            </div>
                                                            <small class="counter-value float-right"><span
                                                                    class="char-count3">0</span> / 11 </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="parents_email">ایمیل ولی :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" id="parents_email" class="form-control"
                                                                   name="parents_email" placeholder="ایمیل"
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
                    @if($deputyAdmin->hasPermission('Students.List.View') || $deputyAdmin->level == "1")
                        <div class="lds-ripple-content">
                            <div class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div id="StudentsTable">
                            <div class="text-center">
                                <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                     style="width: 200px;margin: 0 auto" alt="">
                                <p class="pt10">
                                    برای مشاهده ی دانش آموزان، پایه تحصیلی و کلاس مورد نظر را انتخاب نمایید
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="baseCur" value="{{old('base_id')}}">
    <input type="hidden" id="ClassCur" name="ClassCur" value="{{old('class_id')}}">
    <div id="deleteOutput"></div>
@stop
@section('js')

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $("#image").change(function (e) {
            var ext = $("#image").val().split(".").pop().toLowerCase();
            if ($.inArray(ext, ["jpg"]) == -1) {
                $(document).ready(function () {
                    Command: toastr["error"]("عکس پرسنلی دانش آموز حتما بايد با پسوند jpg باشد.", "");
                });
                $("#image").val("");
                a = 0;
            } else {
                var picsize = (this.files[0].size);
                if (picsize > 1000000) {
                    Command: toastr["error"](" حداکثر حجم عکس پرسنلی دانش آموز ۱ مگابايت مي باشد.", "");
                    $("#image").val("");
                    a = 0;
                } else {
                    a = 1;
                }
            }
        });
        $(document).ready(function () {
            baseList();
            $("#base_id").change(function () {
                var base = $(this).val();
                $("#baseCur").val(base);
                baseList();
            });

            function baseList() {
                var base_id = $("#baseCur").val();
                var grade_id = $("#grade_id").val();
                var deputy_id = $("#deputy_id").val();
                var school_id = $("#school_id").val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('Students.ClassList')}}',
                    data: {
                        base_id: base_id,
                        grade_id: grade_id,
                        deputy_id: deputy_id,
                        school_id: school_id,
                        _token: _token
                    },
                    success: function (classResult) {
                        $('#class_id').html(classResult);
                    }
                });

            }

            base_table();
            $("#class_id").change(function () {
                var ClassCur = $(this).val();
                $("#ClassCur").val(ClassCur);
                base_table();
            });

            function base_table() {
                var class_id = $("#ClassCur").val();
                var base_id = $("#baseCur").val();
                var grade_id = $("#grade_id").val();
                var deputy_id = $("#deputy_id").val();
                var school_id = $("#school_id").val();
                var _token = $("#_token").val();
                $(".lds-ripple-content").fadeIn('slow');
                $.ajax({
                    type: 'POST',
                    url: '{{route('Students.Table')}}',
                    data: {
                        base_id: base_id,
                        grade_id: grade_id,
                        deputy_id: deputy_id,
                        school_id: school_id,
                        class_id: class_id,
                        _token: _token
                    },
                    success: function (StudentsTable) {
                        $('#StudentsTable').html(StudentsTable);
                        $(".lds-ripple-content").fadeOut('slow');
                    }
                });

            }
        });
        $(".students_toggle-password").show();
        $(".students_toggle-password").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".students_toggle-re-password").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".parentsـtoggle-password").show();
        $(".parentsـtoggle-password").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".parents_toggle-re-password").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(function () {
            $("#student_national_code").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#student_national_code").val(persianToEnglish($(this).val()));
                }
            });
            $("#student_phone").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#student_phone").val(persianToEnglish($(this).val()));
                }
            });
            $("#parents_national_code").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#parents_national_code").val(persianToEnglish($(this).val()));
                }
            });
            $("#parents_phone").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#parents_phone").val(persianToEnglish($(this).val()));
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
                    base_id: {
                        required: true
                    },
                    class_id: {
                        required: true
                    },
                    student_name: {
                        required: true,
                        minlength: 3
                    },
                    student_family: {
                        required: true,
                        minlength: 3
                    },
                    student_national_code: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    student_password: {
                        required: true,
                        minlength: 5
                    },
                    student_password_confirmation: {
                        required: true,
                        minlength: 5,
                        equalTo: "#student_password"
                    },
                    student_phone: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    student_email: {
                        required: true,
                        email: true,
                    },


                    parents_name: {
                        required: true,
                        minlength: 3
                    },
                    parents_family: {
                        required: true,
                        minlength: 3
                    },
                    parents_national_code: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    parents_password: {
                        required: true,
                        minlength: 5
                    },
                    parents_password_confirmation: {
                        required: true,
                        minlength: 5,
                        equalTo: "#parents_password"
                    },
                    parents_phone: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    parents_email: {
                        required: true,
                        email: true,
                    },
                },
                messages: {

                    base_id: {
                        required: "لطفا پایه تحصیلی را انتخاب نمایید.",
                    },
                    class_id: {
                        required: "لطفا پایه تحصیلی را انتخاب نمایید.",
                    },


                    student_name: {
                        required: "لطفا نام دانش آموز را وارد نمایید.",
                        minlength: "نام دانش آموز حداقل باید ۳ حرف باشد."
                    },
                    student_family: {
                        required: "لطفا نام انوادگی دانش آموز را وارد نمایید.",
                        minlength: "نام انوادگی دانش آموز حداقل باید ۳ حرف باشد."
                    },
                    student_national_code: {
                        required: "لطفا کد ملی دانش آموز را وارد نمایید.",
                        minlength: "کد ملی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد ملی حداکثر باید ۱۰ کاراکتر باشد.",
                        number: "کد ملی باید عدد باشد."
                    },
                    student_password: {
                        required: "لطفا رمز عبور دانش آموز را وارد نمایید.",
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    student_password_confirmation: {
                        required: "لطفا تکرار رمز عبور دانش آموز را وارد نمایید.",
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },
                    student_phone: {
                        required: "لطفا شماره همراه دانش آموز را وارد نمایید.",
                        minlength: "شماره همراه حداقل باید ۱۱ کاراکتر باشد.",
                        maxlength: "شماره همراه حداکثر باید ۱۱ کاراکتر باشد.",
                        number: "شماره همراه باید عدد باشد."
                    },
                    student_email: {
                        required: "لطفا ایمیل دانش آموز را وارد نمایید.",
                        email: "لطفا یک آدرس ایمیل معتبر وارد کنید"
                    },


                    parents_name: {
                        required: "لطفا نام ولی دانش آموز را وارد نمایید.",
                        minlength: "نام ولی دانش آموز حداقل باید ۳ حرف باشد."
                    },
                    parents_family: {
                        required: "لطفا نام انوادگی ولی دانش آموز را وارد نمایید.",
                        minlength: "نام انوادگی ولی دانش آموز حداقل باید ۳ حرف باشد."
                    },
                    parents_national_code: {
                        required: "لطفا کد ملی ولی دانش آموز را وارد نمایید.",
                        minlength: "کد ملی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد ملی حداکثر باید ۱۰ کاراکتر باشد.",
                        number: "کد ملی باید عدد باشد."
                    },
                    parents_password: {
                        required: "لطفا رمز عبور ولی دانش آموز را وارد نمایید.",
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    parents_password_confirmation: {
                        required: "لطفا تکرار رمز عبور ولی دانش آموز را وارد نمایید.",
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },
                    parents_phone: {
                        required: "لطفا شماره همراه ولی دانش آموز را وارد نمایید.",
                        minlength: "شماره همراه حداقل باید ۱۱ کاراکتر باشد.",
                        maxlength: "شماره همراه حداکثر باید ۱۱ کاراکتر باشد.",
                        number: "شماره همراه باید عدد باشد."
                    },
                    parents_email: {
                        required: "لطفا ایمیل ولی دانش آموز را وارد نمایید.",
                        email: "لطفا یک آدرس ایمیل معتبر وارد کنید"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
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

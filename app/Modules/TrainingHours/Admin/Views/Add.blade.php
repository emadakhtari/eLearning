`@extends('Master_Admin::MasterPage')
@section('title')
    ساعت آموزشی
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">

    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/css/bootstrap-material-datetimepicker.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .checkbox label:after, .checkbox label:before {
            height: 17px !important;
            width: 17px !important;
        }

        .checkbox label {
            font-size: 11px !important;
            line-height: 23px;
            padding-right: 20px !important;
            cursor: pointer;
        }

        .checkbox.checkbox-icon i {
            right: 2px !important;
            top: 6px !important;
            font-size: 13px !important;
        }

        .fieldset-grade {
            display: inline-block;
            margin: 0 auto 10px;
        }

        .float-none {
            float: none !important;
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
                            <li class="breadcrumb-item "><a>ساعت آموزشی</a>
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
                    @if($deputyAdmin->hasPermission('TrainingHours.Add.View') || $deputyAdmin->level == "1")
                        <form id="form" class="form form-vertical" name="form" method="post"
                              action="{{route('TrainingHours.Add')}}" enctype="multipart/form-data">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                            <input type="hidden" value="{{$deputyId}}" name="deputy_id" id="deputy_id">
                            <input type="hidden" value="{{$SchoolSelect->id}}" name="school_id" id="school_id">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="grade_id">روز هفته</label>
                                                        <div class="row">
                                                            <fieldset class="fieldset-grade">
                                                                <div class="checkbox checkbox-success checkbox-icon">
                                                                    <input type="checkbox" id="week_day_1"
                                                                           name="week_day[]"
                                                                           value="1"
                                                                           class="weekDay"
                                                                           @if(old('week_day') == '1') selected @endif>
                                                                    <label for="week_day_1"><i
                                                                            class="bx bx-bell"></i>شنبه</label>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="fieldset-grade">
                                                                <div class="checkbox checkbox-success checkbox-icon">
                                                                    <input type="checkbox" id="week_day_2"
                                                                           name="week_day[]"
                                                                           value="2"
                                                                           class="weekDay"
                                                                           @if(old('week_day') == '2') selected @endif>
                                                                    <label for="week_day_2"><i
                                                                            class="bx bx-bell"></i>یک شنبه</label>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="fieldset-grade">
                                                                <div class="checkbox checkbox-success checkbox-icon">
                                                                    <input type="checkbox" id="week_day_3"
                                                                           name="week_day[]"
                                                                           value="3"
                                                                           class="weekDay"
                                                                           @if(old('week_day') == '3') selected @endif>
                                                                    <label for="week_day_3"><i
                                                                            class="bx bx-bell"></i>دو شنبه</label>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="fieldset-grade">
                                                                <div class="checkbox checkbox-success checkbox-icon">
                                                                    <input type="checkbox" id="week_day_4"
                                                                           name="week_day[]"
                                                                           value="4"
                                                                           class="weekDay"
                                                                           @if(old('week_day') == '4') selected @endif>
                                                                    <label for="week_day_4"><i
                                                                            class="bx bx-bell"></i>سه شنبه</label>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="fieldset-grade">
                                                                <div class="checkbox checkbox-success checkbox-icon">
                                                                    <input type="checkbox" id="week_day_5"
                                                                           name="week_day[]"
                                                                           value="5"
                                                                           class="weekDay"
                                                                           @if(old('week_day') == '5') selected @endif>
                                                                    <label for="week_day_5"><i
                                                                            class="bx bx-bell"></i>چهار شنبه</label>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="fieldset-grade">
                                                                <div class="checkbox checkbox-success checkbox-icon">
                                                                    <input type="checkbox" id="week_day_6"
                                                                           name="week_day[]"
                                                                           value="6"
                                                                           class="weekDay"
                                                                           @if(old('week_day') == '6') selected @endif>
                                                                    <label for="week_day_6"><i
                                                                            class="bx bx-bell"></i>پنج شنبه</label>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset class="fieldset-grade">
                                                                <div class="checkbox checkbox-danger checkbox-icon">
                                                                    <input type="checkbox" id="week_day_7"
                                                                           name="week_day[]"
                                                                           value="7"
                                                                           class="weekDay"
                                                                           @if(old('week_day') == '7') selected @endif>
                                                                    <label for="week_day_7" style="color: red"><i
                                                                            class="bx bx-bell"></i>جمعه</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="grade_id">شماره وقت</label>
                                                        <select
                                                            class="form-control __web-inspector-hide-shortcut__ _time_number"
                                                            name="time_number"
                                                            id="time_number" required="">
                                                            <option value="">انتخاب نشده</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="start_time">ساعت شروع :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="start_time"
                                                                   name="start_time"
                                                                   placeholder="ساعت شروع"
                                                                   {{--                                                               readonly="readonly"--}}
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bxs-hourglass-top"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="end_time">ساعت اختتام :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="end_time"
                                                                   name="end_time"
                                                                   placeholder="ساعت اختتام"
                                                                   {{--                                                               readonly="readonly"--}}
                                                                   required="">
                                                            <div class="form-control-position">
                                                                <i class="bx bxs-hourglass-bottom"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <div class="col-md-6 col-6 ">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">ثبت
                                                    </button>
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
                    @if($deputyAdmin->hasPermission('TrainingHours.List.View') || $deputyAdmin->level == "1")
                        <div class="lds-ripple-content">
                            <div class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div id="weekDay">
                            <div class="text-center">
                                <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                     style="width: 200px;margin: 0 auto" alt="">
                                <p class="pt10">
                                    برای مشاهده ی ساعات آموزشی، روز هفته مورد نظر را انتخاب نمایید
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="weekDayCur" value="{{old('week_day')}}">
    <div id="deleteOutput"></div>
@stop
@section('js')
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#start_time').bootstrapMaterialDatePicker
            ({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });
            $('#end_time').bootstrapMaterialDatePicker
            ({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });
            base_table();


            $(".weekDay").change(function () {
                var output = jQuery.map($(':checkbox[name=week_day\\[\\]]:checked'), function (n, i) {
                    return n.value;
                }).join(',');
                $("#weekDayCur").val(output);
                base_table();
            });


            function base_table() {
                var week_day = $("#weekDayCur").val();
                var deputy_id = $("#deputy_id").val();
                var school_id = $("#school_id").val();
                var time_number = $("#time_number").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                var _token = $("#_token").val();
                $(".lds-ripple-content").fadeIn('slow');
                $.ajax({
                    type: 'POST',
                    url: '{{route('TrainingHours.Table')}}',
                    data: {
                        week_day: week_day,
                        deputy_id: deputy_id,
                        school_id: school_id,
                        time_number: time_number,
                        start_time: start_time,
                        end_time: end_time,
                        _token: _token
                    },
                    success: function (weekDay) {
                        $('#weekDay').html(weekDay);
                        $(".lds-ripple-content").fadeOut('slow');
                    }
                });
            }
        });


        $(function () {
            $("form#form").validate({
                rules: {
                    week_day: {
                        required: true
                    },
                    time_number: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    }
                },
                messages: {
                    week_day: {
                        required: "لطفا روز هفته را انتخاب نمایید.",
                    },
                    time_number: {
                        required: "لطفا شماره وقت را انتخاب نمایید.",
                    },
                    start_time: {
                        required: "لطفا ساعت شروع را انتخاب نمایید.",
                    },
                    end_time: {
                        required: "لطفا ساعت اختتام را انتخاب نمایید.",
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });

        @if(Session::has('message1'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.success("{{ Session::get('message1') }}").css()
        });
        @endif
        @if(Session::has('message2'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.success("{{ Session::get('message2') }}").css()
        });
        @endif
        @if(Session::has('message3'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.success("{{ Session::get('message3') }}").css()
        });
        @endif
        @if(Session::has('message4'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.success("{{ Session::get('message4') }}").css()
        });
        @endif
        @if(Session::has('message5'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.success("{{ Session::get('message5') }}").css()
        });
        @endif
        @if(Session::has('message6'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.success("{{ Session::get('message6') }}").css()
        });
        @endif
        @if(Session::has('message7'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.success("{{ Session::get('message7') }}").css()
        });
        @endif

        @if(Session::has('error1'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{ Session::get('error1') }}").css()
        });
        @endif
        @if(Session::has('error2'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{ Session::get('error2') }}").css()
        });
        @endif
        @if(Session::has('error3'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{ Session::get('error3') }}").css()
        });
        @endif
        @if(Session::has('error4'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{ Session::get('error4') }}").css()
        });
        @endif
        @if(Session::has('error5'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{ Session::get('error5') }}").css()
        });
        @endif
        @if(Session::has('error6'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{ Session::get('error6') }}").css()
        });
        @endif
        @if(Session::has('error7'))
        $(document).ready(function () {
            toastr.options = {
                timeOut: 6000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 200
            };
            toastr.error("{{ Session::get('error7') }}").css()
        });
        @endif

    </script>



    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

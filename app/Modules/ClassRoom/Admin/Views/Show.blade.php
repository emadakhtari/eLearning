@extends('Master_Admin::MasterPage')
@section('title')
    پایه تحصیلی
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
    <style>

        iframe {
            width: 100%;
            height: 400px;
        }
        .studentsList {

        }
        .studentsList li{
            display: inline-block;
            width: 32%;
            border: 1px solid;
            padding: 1%;
            margin: 0 0 15px;
            border-radius: 15px;
        }
        .studentsList li img{
            width: 120px;
            border-radius: 30px;
            display: inline;
            float: right;
            margin: 40px 0 0 15px;
        }
        .studentsList li .studentsListDlt {
            display:inline-block;
        }

        .studentsListDlt {
            text-align: center;
        }
        .studentName {
            padding-bottom: 7px;
            display: block;
        }
        .studentStatus {

        }
        .studentDelayHaste {

        }


        .custom-switch .custom-control-label {
            height: 30px;
            width: 86px;
        }
        .custom-switch .custom-control-label::before {
            background-color: #FF5B5C;
            width: 86px;
            height: 30px;
            right:0;
        }
        .custom-switch .custom-control-label::after {
            top: 1px;
            right: 1px;
            width: 43px;
            height: 28px;
        }
        .custom-switch .custom-control-input:checked~.custom-control-label::after {
            -webkit-transform: translateX(-41px);
            -ms-transform: translateX(-41px);
            transform: translateX(-41px);
            background-color: #ffffff !important;
        }
        .custom-switch .custom-control-label .switch-icon-right {
            left: 7px;
            top: 3px;
            color: #ffffff;
        }
        .custom-switch .custom-control-label .switch-icon-left {
            right: 7px;
            top: 3px;
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
                            <li class="breadcrumb-item "><a>کلاس همین حالا</a>
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
                <div class="col-12 col-sm-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <form id="form" class="form form-vertical" name="form" method="post"
                          action="" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="{{$teacherId}}" name="teacher_id" id="teacher_id">
                        <input type="hidden" value="{{$id->id}}" name="page_id" id="page_id">
                        <input type="hidden" value="{{$id->base_id}}" name="base_id" id="base_id">
                        <input type="hidden" value="{{$id->class_id}}" name="class_id" id="class_id">
                        <input type="hidden" value="{{$id->lesson_id}}" name="lesson_id" id="lesson_id">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                @if($MeetingInfo->isEmpty())
                                                    <span class="btn btn-success createClass" style="cursor: pointer">ساخت کلاس</span>
                                                    <span class="btn btn-success startClass startClassAfterCrtl"
                                                          style="cursor:pointer;display: none">شروع کلاس</span>
                                                    <span class="btn btn-success joinClass joinClassAfterCrtl"
                                                          style="cursor:pointer;display: none">رفتن به کلاس</span>
                                                @else
                                                    @if($url)
                                                        <iframe src="{{$url}}" allow="display-capture ;geolocation ; microphone ; camera *" frameborder="0" style="display: block; background: #fff; border: none; width: 100%;height: 700px"></iframe>
                                                        <br>
                                                        <span class="btn btn-light-danger endClass"
                                                              style="cursor:pointer">اتمام کلاس</span>
                                                        <hr>

                                                        <div id="Listform">
                                                            <h5>لیست دانش آموزان کلاس</h5>
                                                            <div class="row">
                                                                <ul class="col-12 studentsList">
                                                                    @foreach($studentList as $item)
                                                                        <input type="hidden" name="studentid[{{$item->id}}]" value="{{$item->id}}">
                                                                        <li>
                                                                            @if($item->image) {
                                                                                <img src="{{asset('upload/students/images/'.$item->image)}}" alt="">
                                                                            @else
                                                                                <img src="{{asset('Assets/Admin/images/avatar.png')}}" alt="">
                                                                            @endif
                                                                            <div class="studentsListDlt">
                                                                                <span class="studentName">{{$item->name}} {{$item->family}}</span>
                                                                                <div class="studentStatus">
                                                                                    <div class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                                                        <input name="status[{{$item->id}}]" type="checkbox" class="custom-control-input item_modules"
                                                                                               id="status_{{$item->id}}"
                                                                                               value='1'>
                                                                                        <label class="custom-control-label" for="status_{{$item->id}}">
                                                                                            <span class="switch-icon-left">حاضر</span>
                                                                                            <span class="switch-icon-right">غایب</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="studentDelayHaste">
                                                                                    <div class="position-relative has-icon-left">
                                                                                        <select class="form-control __web-inspector-hide-shortcut__ _class_id valid" name="delay[{{$item->id}}]" id="delay_{{$item->id}}" aria-required="true" aria-invalid="false">
                                                                                            <option value="0">تاخیر در ورود</option>
                                                                                            <option value="10">10 دقیقه</option>
                                                                                            <option value="15">15 دقیقه</option>
                                                                                            <option value="20">20 دقیقه</option>
                                                                                            <option value="30">30 دقیقه</option>
                                                                                        </select>
                                                                                        <div class="form-control-position">
                                                                                            <i class="bx bxs-hourglass-top"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="position-relative has-icon-left">
                                                                                        <select class="form-control __web-inspector-hide-shortcut__ _haste valid" name="haste[{{$item->id}}]" id="haste_{{$item->id}}" aria-required="true" aria-invalid="false">
                                                                                            <option value="0">تعجیل در خروج</option>
                                                                                            <option value="10">10 دقیقه</option>
                                                                                            <option value="15">15 دقیقه</option>
                                                                                            <option value="20">20 دقیقه</option>
                                                                                            <option value="30">30 دقیقه</option>
                                                                                        </select>
                                                                                        <div class="form-control-position">
                                                                                            <i class="bx bxs-hourglass-bottom"></i>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 col-6 ">
                                                                    <input type="submit" class="btn btn-primary mr-1 mb-1" id="ListformSend" value="ثبت"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="btn btn-success startClass"
                                                              style="cursor:pointer">شروع کلاس</span>
                                                        <span class="btn btn-success joinClass joinClassAfterCrtl"
                                                              style="cursor:pointer;display: none">رفتن به کلاس</span>
                                                    @endif
                                                @endif
                                                <div class="clear"></div>
                                                <div id="joinClass"></div>
                                            </div>
                                            <div class="col-md-12 col-12">
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
        $(".createClass").click(function () {
            var page_id = $("#page_id").val();
            var teacher_id = $("#teacher_id").val();
            var class_id = $("#class_id").val();
            var lesson_id = $("#lesson_id").val();
            var _token = $("#_token").val();
            $(this).fadeOut('slow');
            $.ajax({
                type: 'POST',
                url: '{{route('ClassRoom.create')}}',
                data: {
                    page_id: page_id,
                    teacher_id: teacher_id,
                    class_id: class_id,
                    lesson_id: lesson_id,
                    _token: _token
                },
                success: function (createClass) {
                    $(".startClassAfterCrtl").fadeIn('slow');
                    $(".createClass").css('display', 'none');
                }
            });
        });

        $(".startClass").click(function () {
            var page_id = $("#page_id").val();
            var teacher_id = $("#teacher_id").val();
            var class_id = $("#class_id").val();
            var lesson_id = $("#lesson_id").val();
            var _token = $("#_token").val();
            $(this).fadeOut('slow');
            $.ajax({
                type: 'POST',
                url: '{{route('ClassRoom.start')}}',
                data: {
                    page_id: page_id,
                    teacher_id: teacher_id,
                    class_id: class_id,
                    lesson_id: lesson_id,
                    _token: _token
                },
                success: function (startClass) {
                    $(".startClass").css('display', 'none');
                    location.reload();
                    // $('#joinClass').html(startClass);
                }
            });
        });
        $(".endClass").click(function () {
            var page_id = $("#page_id").val();
            var teacher_id = $("#teacher_id").val();
            var class_id = $("#class_id").val();
            var lesson_id = $("#lesson_id").val();
            var _token = $("#_token").val();
            $(this).fadeOut('slow');
            $.ajax({
                type: 'POST',
                url: '{{route('ClassRoom.end')}}',
                data: {
                    page_id: page_id,
                    teacher_id: teacher_id,
                    class_id: class_id,
                    lesson_id: lesson_id,
                    _token: _token
                },
                success: function (endClass) {
                    $(".endClass").fadeOut('slow');
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                }
            });
        });

        $(function () {
            $("#form").on('submit', function (e) {
                e.preventDefault();
                swal({
                        title: "آیا از درستی اطلاعات وارد کرده اطمینان دارید؟",
                        text: "پس از ارسال قادر به ویرایش نخواهید بود!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "بله, انجام شود!",
                        cancelButtonText: "خیر, انجام نشود!",
                        showLoaderOnConfirm: false,
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: 'post',
                                url: '{{route('ClassRoom.DelayHaste')}}',
                                data: $("#form").serialize(),
                                success: function (data) {
                                    if (data['status'] == 1) {
                                        swal({
                                            title: 'گزارش حضور و غیاب',
                                            text: data['massage'],
                                            type: "success",
                                            button: "باشه!",
                                        });
                                    } else {
                                        swal({
                                            title: 'گزارش حضور و غیاب',
                                            text: data['massage'],
                                            type: "error",
                                            button: "باشه!",
                                        });
                                    }

                                }
                            });
                        } else {
                            swal("", "حضور غیاب انجام نگردید!", "error");
                        }
                    });


            });

        });
    </script>
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

@extends('Master_Admin::MasterPage')
@section('title')
    برنامه آموزشی
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
    <style>
        .popover .popover-body {
            color: #304156 !important;
        }

        .popover {
            z-index: 1000;
        }
        .weekTable_p {
            text-align: center;
            color: #f87008;
            padding-top: 30px;
        }
        .weekTable_p b{
            color: #5A8DEE;
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
                            <li class="breadcrumb-item "><a>برنامه آموزشی</a>
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
                    @if($deputyAdmin->hasPermission('Schedule.Add.View') || $deputyAdmin->level == "1")
                        <form id="form" class="form form-vertical" name="form" method="post"
                              action="{{route('Schedule.Add')}}" enctype="multipart/form-data">
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
                                                        <label for="grade_id">پایه تحصیلی</label>
                                                        <select
                                                            class="form-control __web-inspector-hide-shortcut__ _base_id"
                                                            name="base_id"
                                                            id="base_id" required="">
                                                            <option value="">انتخاب نشده</option>
                                                            @foreach($baseList as $item)
                                                                <option
                                                                    value="{{$item['id']}}">{{$item['title']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="lesson_id">درس</label>
                                                        <select
                                                            class="form-control __web-inspector-hide-shortcut__ _lesson_id"
                                                            name="lesson_id"
                                                            id="lesson_id" required="">
                                                            <option value="">انتخاب نشده</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="class_id">کلاس</label>
                                                        <select
                                                            class="form-control __web-inspector-hide-shortcut__ _class_id"
                                                            name="class_id"
                                                            id="class_id" required="">
                                                            <option value="">انتخاب نشده</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--                                        <div class="row">--}}
                                            {{--                                            <div class="col-md-6 col-12">--}}
                                            {{--                                                <div class="form-group">--}}
                                            {{--                                                    <label for="class_id">کلاس</label>--}}
                                            {{--                                                    <select--}}
                                            {{--                                                        class="form-control __web-inspector-hide-shortcut__ _class_id"--}}
                                            {{--                                                        name="class_id"--}}
                                            {{--                                                        id="class_id" required="">--}}
                                            {{--                                                        <option value="">انتخاب نشده</option>--}}
                                            {{--                                                    </select>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 col-12" style="padding: 15px;">
                                                    کلاس های درس <input readonly type="text" id="lessonCurName"> ، برای
                                                    مدرس <input readonly type="text" id="teacherCurName">

                                                </div>
                                                <div class="col-md-9 col-9" id="weekTable">
                                                    <p class="weekTable_p">
                                                        لطفا <b>پایه تحصیلی</b>، <b>درس</b>، <b>کلاس</b> و <b>مدرس</b> مورد نظر خود را انتخاب نمایید.
                                                    </p>
                                                </div>
                                                <div class="col-3">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="teacher_id">مدرس</label>
                                                            <select
                                                                class="form-control __web-inspector-hide-shortcut__ _teacher_id"
                                                                name="teacher_id"
                                                                id="teacher_id" required="">
                                                                <option value="">انتخاب نشده</option>
                                                            </select>
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
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="baseCur">
    <input type="hidden" id="classCur">
    <input type="hidden" id="lessonCur">
    <input type="hidden" id="teacherCur">
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

        $(document).ready(function () {
            $('.radioWeek:checked').click(function () {
                $(this).attr('checked', false);
            });
            $(function () {
                $('input.radioWeek').click(function () {
                    var $radio = $(this);
                    if ($radio.data('waschecked') == true) {
                        $radio.prop('checked', false);
                        $radio.data('waschecked', false);
                    } else
                        $radio.data('waschecked', true);
                    $radio.siblings('input[name="rad"]').data('waschecked', false);
                });
            });
            $('.radioWeek').click(function () {
                var checkBase = $("#baseCur").val();
                var checkClass = $("#classCur").val();
                var checkLesson = $("#lessonCur").val();
                var checkTeacher = $("#teacherCur").val();
                if (!checkTeacher || !checkLesson || !checkClass || !checkBase) {
                    $('.radioWeek').prop("checked", false);
                    toastr.error("لطفا ابتدا پایه تحصیلی، کلاس، درس و مدرس را انتخاب نمایید.").css("width", "100%")
                }
            });
            $("#base_id").change(function () {
                $('.radioWeek').prop("checked", false);
                var base = $(this).val();
                $("#baseCur").val(base);
                // Base();
                Class();
                Lesson();
                Teache();
                weekTable();
                $("#classCur").val("");
                $("#lessonCur").val("");
                $("#teacherCur").val("");
                $("#lessonCurName").val("");
                $("#teacherCurName").val("");
            });

            function Lesson() {
                var school_id = $("#school_id").val();
                var grade_id = $("#grade_id").val();
                var base_id = $("#baseCur").val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('Schedule.LessonList')}}',
                    data: {
                        base_id: base_id,
                        grade_id: grade_id,
                        school_id: school_id,
                        _token: _token
                    },
                    success: function (lesson_info) {
                        $('#lesson_id').html(lesson_info);

                    }
                });
            }


            $("#lesson_id").change(function () {
                $('.radioWeek').prop("checked", false);
                var lesson = $(this).val();
                var lessonName = $("#lesson_id :selected").text();
                $("#teacherCurName").val("");
                $("#lessonCur").val(lesson);
                if (lessonName) {
                    if (lessonName == "انتخاب نشده") {
                        $("#lessonCurName").val("");
                    } else {
                        $("#lessonCurName").val(lessonName);
                    }
                } else {
                    var lessonName = "";
                    $("#lessonCurName").val(lessonName);
                }
                Class();
                Teache();
                $("#teacherCur").val("");
            });

            function Class() {
                var deputy_id = $("#deputy_id").val();
                var school_id = $("#school_id").val();
                var base_id = $("#base_id").val();
                var lesson_id = $("#lessonCur").val();
                var class_id = $("#class_id").val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('Schedule.ClassList')}}',
                    data: {
                        deputy_id: deputy_id,
                        base_id: base_id,
                        school_id: school_id,
                        lesson_id: lesson_id,
                        class_id: class_id,
                        _token: _token
                    },
                    success: function (class_info) {
                        $('#class_id').html(class_info);
                        weekTable();
                    }
                });
            }

            $("#class_id").change(function () {
                $('.radioWeek').prop("checked", false);
                var classInfo = $(this).val();
                $("#classCur").val(classInfo);
                $("#teacherCur").val("");
                $("#teacherCurName").val("");
                Teache();
            });

            function Teache() {
                var deputy_id = $("#deputy_id").val();
                var school_id = $("#school_id").val();
                var base_id = $("#base_id").val();
                var lesson_id = $("#lessonCur").val();
                var class_id = $("#classCur").val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('Schedule.TeacherList')}}',
                    data: {
                        deputy_id: deputy_id,
                        base_id: base_id,
                        school_id: school_id,
                        lesson_id: lesson_id,
                        class_id: class_id,
                        _token: _token
                    },
                    success: function (teacher_info) {
                        $('#teacher_id').html(teacher_info);
                        weekTable();
                    }
                });
            }

            $("#teacher_id").change(function () {
                $('.radioWeek').prop("checked", false);
                var teacher = $(this).val();
                var teacherName = $("#teacher_id :selected").text();
                $("#teacherCur").val(teacher);
                weekTable();
                if (teacherName) {
                    if (teacherName == "انتخاب نشده") {
                        $("#teacherCurName").val("");
                    } else {
                        $("#teacherCurName").val(teacherName);
                    }
                } else {
                    var teacherName = "";
                    $("#teacherCurName").val(teacherName);
                }

            });

            function weekTable() {
                var deputy_id = $("#deputy_id").val();
                var school_id = $("#school_id").val();
                var base_id = $("#base_id").val();
                var lesson_id = $("#lessonCur").val();
                var class_id = $("#class_id").val();
                var teacher_id = $("#teacherCur").val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('Schedule.weekTable')}}',
                    data: {
                        deputy_id: deputy_id,
                        base_id: base_id,
                        school_id: school_id,
                        lesson_id: lesson_id,
                        class_id: class_id,
                        teacher_id: teacher_id,
                        _token: _token
                    },
                    success: function (weekTableResult) {
                        if (!teacher_id || !lesson_id || !class_id || !base_id) {
                            $("#weekTable").html('<p class="weekTable_p">لطفا <b>پایه تحصیلی</b>، <b>درس</b>، <b>کلاس</b> و <b>مدرس</b> مورد نظر خود را انتخاب نمایید.</p>');
                        } else {
                            if (weekTableResult['success'] == 2) {
                                $("#weekTable").html(weekTableResult['output']);
                            } else {
                                $("#weekTable").html('<p class="weekTable_p">آیتمی جهت نمایش موجود نمی باشد</p>');
                            }
                        }

                    }
                });
            }
        });

        $(function () {
            $("form#form").validate({
                rules: {
                    base_id: {
                        required: true
                    },
                    class_id: {
                        required: true
                    },
                    lesson_id: {
                        required: true
                    },
                    teacher_id: {
                        required: true
                    }
                },
                messages: {
                    base_id: {
                        required: "لطفا پایه تحصیلی را انتخاب نمایید.",
                    },
                    class_id: {
                        required: "لطفا کلاس را انتخاب نمایید.",
                    },
                    lesson_id: {
                        required: "لطفا درس را انتخاب نمایید.",
                    },
                    teacher_id: {
                        required: "لطفا مدرس را انتخاب نمایید.",
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

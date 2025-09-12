@extends('Master_Admin::MasterPage')
@section('title')
    تکالیف
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">

    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/pickers/daterange/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/pickers/datepicker-jalali/bootstrap-datepicker.min.css')}}">

    <style>
        .bxs-close {

        }

        .bxs-close i {
            color: #f87008;
            cursor: pointer;
        }

        .bxs-close i:hover {
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
                            <li class="breadcrumb-item "><a>تکالیف</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="basic-vertical-layouts">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="lesson_id">پایه</label>
                        <select
                            class="form-control __web-inspector-hide-shortcut__ _base_id"
                            name="base_id"
                            id="base_id">
                            <option value="">انتخاب نشده</option>
                            @foreach($assignSelect as $item)
                                <option value="{{$item->base_id}}">{{$baseSelect[$item->id]->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="class_id">کلاس</label>
                        <select
                            class="form-control __web-inspector-hide-shortcut__ _class_id"
                            name="class_id"
                            id="class_id">
                            <option value="">انتخاب نشده</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="lesson_id">درس</label>
                        <select
                            class="form-control __web-inspector-hide-shortcut__ _lesson_id"
                            name="lesson_id"
                            id="lesson_id">
                            <option value="">انتخاب نشده</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-12">
                    <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control shamsi-datepicker" placeholder="انتخاب تاریخ" id="date" readonly>
                        <div class="form-control-position">
                            <i class="bx bx-calendar"></i>
                        </div>
                        <div class="form-control-position bxs-close" style="left: 0 !important;right: auto">
                            <i class="bx bxs-x-circle"></i>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-12">
                    <fieldset class="form-group position-relative has-icon-left">
                        <label class="control-label" for="title">جستجو (نام خانوادگی دانش آموز):
                        </label>
                        <input id="search" class="form-control" data-parsley-trigger="change" name="search"
                               type="text">
                    </fieldset>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="status">وضعیت</label>
                        <select
                            class="form-control __web-inspector-hide-shortcut__ _status"
                            name="status"
                            id="status">
                            <option value="">همه</option>
                            <option value="unseen">بررسی نشده</option>
                            <option value="1">کامل</option>
                            <option value="2">ناقص</option>
                            <option value="3">مورد تایید نیست</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row match-height">
                <div class="col-12">
                    <div class="lds-ripple-content">
                        <div class="lds-ripple">
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div id="BaseTable">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" name="baseCur" id="baseCur">
    <input type="hidden" name="classCur" id="classCur">
    <input type="hidden" name="lessonCur" id="lessonCur">
    <input type="hidden" name="statusCur" id="statusCur">
    <input type="hidden" name="grade_id" id="grade_id" value="{{$assignGrade->grade_id}}">
    <input type="hidden" name="school_id" id="school_id" value="{{$SchoolSelect->id}}">
@stop
@section('js')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>

    <script src="{{asset('Assets/Admin/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.min.js')}}"></script>

    <script
        src="{{asset('Assets/Admin/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.fa.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#base_id").change(function () {
                var bas = $(this).val();
                $("#baseCur").val(bas);
                lessonList();
                base();
            });

            $("#class_id").change(function () {
                var cls = $(this).val();
                $("#classCur").val(cls);
                clss();
                lessonList();
            });

            $("#lesson_id").change(function () {
                var less = $(this).val();
                $("#lessonCur").val(less);
                lesson()
            });
            $("#status").change(function () {
                var stat = $(this).val();
                $("#statusCur").val(stat);
                status()
            });
            function status() {
                $.get("Ajax_GetList_Homework",
                    {
                        _token: $('#nekot').val(),
                        lesson_id: $('#lessonCur').val(),
                        base_id: $('#baseCur').val(),
                        class_id: $('#classCur').val(),
                        status: $('#statusCur').val(),
                        date: $('#date').val(),
                        search: $('#search').val()
                    },
                    function (data, status) {
                        $('#loadingPage').fadeOut();
                        $('#BaseTable').html('').html(data);
                    });
            }

            function lessonList() {
                var base_id = $("#baseCur").val();
                var class_id = $("#classCur").val();
                var grade_id = $("#grade_id").val();
                var school_id = $("#school_id").val();
                var _token = $("#nekot").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('Homeworks.lessonList')}}',
                    data: {
                        class_id: class_id,
                        base_id: base_id,
                        grade_id: grade_id,
                        school_id: school_id,
                        base_id: base_id,
                        _token: _token
                    },
                    success: function (clsResult) {
                        $('#lesson_id').html(clsResult);
                    }
                });

            }
            function lesson() {
                $.get("Ajax_GetList_Homework",
                    {
                        _token: $('#nekot').val(),
                        lesson_id: $('#lessonCur').val(),
                        base_id: $('#baseCur').val(),
                        class_id: $('#classCur').val(),
                        date: $('#date').val(),
                        status: $('#statusCur').val(),
                        search: $('#search').val()
                    },
                    function (data, status) {
                        $('#loadingPage').fadeOut();
                        $('#BaseTable').html('').html(data);
                    });
            }
            function base() {
                var base_id = $("#baseCur").val();
                var class_id = $("#classCur").val();
                var grade_id = $("#grade_id").val();
                var school_id = $("#school_id").val();
                var _token = $("#nekot").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('Homeworks.classList')}}',
                    data: {
                        grade_id: grade_id,
                        school_id: school_id,
                        base_id: base_id,
                        _token: _token
                    },
                    success: function (clsResult) {
                        $('#class_id').html(clsResult);
                    }
                });
                $.get("Ajax_GetList_Homework",
                    {
                        _token: $('#nekot').val(),
                        lesson_id: $('#lessonCur').val(),
                        base_id: $('#baseCur').val(),
                        class_id: $('#classCur').val(),
                        date: $('#date').val(),
                        status: $('#statusCur').val(),
                        search: $('#search').val()
                    },
                    function (data, status) {
                        $('#loadingPage').fadeOut();
                        $('#BaseTable').html('').html(data);
                    });
            }


            function clss() {
                $('#loadingPage').fadeIn();
                $.get("Ajax_GetList_Homework",
                    {
                        _token: $('#nekot').val(),
                        lesson_id: $('#lessonCur').val(),
                        base_id: $('#baseCur').val(),
                        class_id: $('#classCur').val(),
                        date: $('#date').val(),
                        status: $('#statusCur').val(),
                        search: $('#search').val()
                    },
                    function (data, status) {
                        $('#loadingPage').fadeOut();
                        $('#BaseTable').html('').html(data);
                    });
            }

            $('.bxs-close').css('display', 'none');

            $('#loadingPage').fadeIn();
            $.get("Ajax_GetList_Homework",
                {
                    _token: $('#nekot').val(),
                    lesson_id: $('#lessonCur').val(),
                    base_id: $('#baseCur').val(),
                    class_id: $('#classCur').val(),
                    date: $('#date').val(),
                    status: $('#statusCur').val(),
                    search: $('#search').val()
                },
                function (data, status) {
                    $('#loadingPage').fadeOut();
                    $('#BaseTable').html('').html(data);
                });
        });


        $('#search').keyup(function () {
            $('#loadingPage').fadeIn();
            $.get("Ajax_GetList_Homework",
                {
                    _token: $('#nekot').val(),
                    lesson_id: $('#lessonCur').val(),
                    base_id: $('#baseCur').val(),
                    class_id: $('#classCur').val(),
                    date: $('#date').val(),
                    status: $('#statusCur').val(),
                    search: $('#search').val()
                },
                function (data, status) {
                    $('#loadingPage').fadeOut();
                    $('#BaseTable').html('').html(data);

                });
        });


        function from() {
            if ($('#date').val()) {
                $('.bxs-close').fadeIn();
            } else {
                $('.bxs-close').fadeOut();
            }
            $('#loadingPage').fadeIn();
            $.get("Ajax_GetList_Homework",
                {
                    _token: $('#nekot').val(),
                    lesson_id: $('#lessonCur').val(),
                    base_id: $('#baseCur').val(),
                    class_id: $('#classCur').val(),
                    date: $('#date').val(),
                    status: $('#statusCur').val(),
                    search: $('#search').val()
                },
                function (data, status) {
                    $('#loadingPage').fadeOut();
                    $('#BaseTable').html('').html(data);
                });
        }

        function paginating(pageNumber) {
            $('#loadingPage').fadeIn();
            $.get("Ajax_GetList_Homework",
                {
                    pageNumber: pageNumber,
                    _token: $('#nekot').val(),
                    lesson_id: $('#lessonCur').val(),
                    base_id: $('#baseCur').val(),
                    class_id: $('#classCur').val(),
                    date: $('#date').val(),
                    status: $('#statusCur').val(),
                    search: $('#search').val()
                },
                function (data, status) {
                    $('#loadingPage').fadeOut();
                    $('#BaseTable').html('').html(data);

                });
        }

        $('.shamsi-datepicker').datepicker({
            dateFormat: "yy/mm/dd",
            showOtherMonths: true,
            selectOtherMonths: false,
            onSelect: function (date, instance) {
                from();
            }
        });
        $(".bxs-close").click(function () {
            $("#date").val('');
            from();
            $('.bxs-close').fadeOut();
           return false;
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

@extends('Master_Admin::MasterPage')
@section('title')
    تخصیص مدرس
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">

    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/forms/select/select2.min.css')}}">
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
                            <li class="breadcrumb-item "><a>تخصیص مدرس</a>
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
                    @if($deputyAdmin->hasPermission('TeacherAssign.Add.View') || $deputyAdmin->level == "1")
                        <form id="form" class="form form-vertical" name="form" method="post"
                          action="{{route('TeacherAssign.Add')}}" enctype="multipart/form-data">
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
                                                    <label for="teacher_id">شماره ملی مدرس</label>
                                                    <select
                                                        class="form-control select2 __web-inspector-hide-shortcut__ _teacher_id"
                                                        name="teacher_id"
                                                        id="teacher_id" required="">
                                                        <option value="">انتخاب نشده</option>
                                                        @foreach($teacherSelect as $item)
                                                            <option
                                                                @if(old('teacher_id') == $item->id) selected @endif
                                                                value="{{$item['id']}}">{{$item['national_code']}} ({{$item['family']}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group" id="teacher_info">
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-top: 6px solid #DFE3E7">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="base_id">پایه</label>
                                                    <select
                                                        class="form-control __web-inspector-hide-shortcut__ _base_id"
                                                        name="base_id"
                                                        id="base_id" required="">
                                                        <option value="">انتخاب نشده</option>
                                                        @php($row=0)
                                                        @foreach($baseSelectList as $item)
                                                            <option
                                                                @if(old('base_id') == $baseSelect[$row]->id) selected @endif
                                                                value="{{$baseSelect[$row]->id}}">{{$baseSelect[$row]->title}}</option>
                                                            @php($row++)
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
                    @if($deputyAdmin->hasPermission('TeacherAssign.List.View') || $deputyAdmin->level == "1")
                        <div class="lds-ripple-content">
                            <div class="lds-ripple"><div></div><div></div></div>
                        </div>
                        <div id="TeacherAssignTable">
                            <div class="text-center">
                                <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                     style="width: 200px;margin: 0 auto" alt="">
                                <p class="pt10">
                                    برای مشاهده ی کلاس ها، پایه تحصیلی مورد نظر را انتخاب نمایید
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="teacherCur" value="{{old('teacher_id')}}">
    <input type="hidden" id="baseCur" value="{{old('base_id')}}">
    <div id="deleteOutput"></div>
@stop
@section('js')
    <script src="{{asset('Assets/Admin/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/js/scripts/forms/select/form-select2.js')}}"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            teacher();
            $("#teacher_id").change(function () {
                var teache = $(this).val();
                $("#teacherCur").val(teache);
                teacher();
            });
            function teacher() {
                var teacher_id = $("#teacherCur").val();
                var school_id = $("#school_id").val();
                var deputy_id = $("#deputy_id").val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('TeacherAssign.info')}}',
                    data: {teacher_id: teacher_id,school_id: school_id,deputy_id: deputy_id, _token: _token},
                    success: function (teacher_info) {
                        $('#teacher_info').html(teacher_info);
                    }
                });
                $(".lds-ripple-content").fadeIn('slow');
                $.ajax({
                    type: 'POST',
                    url: '{{route('TeacherAssign.Table')}}',
                    data: {
                        deputy_id: deputy_id,
                        school_id: school_id,
                        teacher_id: teacher_id,
                        _token: _token
                    },
                    success: function (TeacherAssignTable) {
                        $('#TeacherAssignTable').html(TeacherAssignTable);
                        $(".lds-ripple-content").fadeOut('slow');
                    }
                });
            }
            BaseTable();
            $("#base_id").change(function () {
                var BaseCur = $(this).val();
                $("#baseCur").val(BaseCur);
                BaseTable();
            });
            function BaseTable() {
                var base_id = $("#baseCur").val();
                var school_id = $("#school_id").val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('TeacherAssign.lesson')}}',
                    data: {base_id: base_id, _token: _token},
                    success: function (lesson_info) {
                        $('#lesson_id').html(lesson_info);
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('TeacherAssign.class')}}',
                    data: {school_id: school_id,base_id: base_id, _token: _token},
                    success: function (class_info) {
                        $('#class_id').html(class_info);
                    }
                });
            }

        });
        $(function () {
            $("form#form").validate({
                rules: {
                    teacher_id: {
                        required: true
                    },
                    base_id: {
                        required: true
                    },
                    lesson_id: {
                        required: true
                    },
                    class_id: {
                        required: true
                    }
                },
                messages: {
                    teacher_id: {
                        required: "لطفا مدرس را انتخاب نمایید.",
                    },
                    base_id: {
                        required: "لطفا پایه تحصیلی را انتخاب نمایید.",
                    },
                    lesson_id: {
                        required: "لطفا درس را انتخاب نمایید.",
                    },
                    class_id: {
                        required: "لطفا کلاس را انتخاب نمایید.",
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

@extends('Master_Admin::MasterPage')
@section('title')
    بارگذاری اطلاعات عمومی
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">

    <style>
        .uploader-text-icon {
            position: relative;
            left: 0;
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
                            <li class="breadcrumb-item "><a>بارگذاری اطلاعات عمومی</a>
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
                          action="{{route('GeneralInformation.Add')}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="{{$teacherId}}" name="teacher_id" id="teacher_id">
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
                                                        @foreach($baseList as $item)
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
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="file_type">نوع محتوای بارگذاری</label>
                                                    <select
                                                        class="form-control __web-inspector-hide-shortcut__ _file_type"
                                                        name="file_type"
                                                        id="file_type" required="">
                                                        <option value="">انتخاب نشده</option>
                                                        <option value="zip">ZIP (.zip)</option>
                                                        <option value="docx">Word (.docx)</option>
                                                        <option value="pptx">PowerPoint (.pptx)</option>
                                                        <option value="pdf">PDF (.pdf)</option>
                                                        <option value="mp4">(mp4.) تصویری</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="file" name="file" id="file"
                                                           class="inputfile inputfile-6">
                                                    <label for="file" class="form-control">
                                                        <strong class="image-lable">آپلود فایل
                                                            <svg class="uploadIconSvg"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 width="20"
                                                                 height="17" viewBox="0 0 20 17">
                                                                <path
                                                                    d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                            </svg>
                                                        </strong>
                                                        <span class="uploader-text-icon uploader-text-icon1"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
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
                    <div class="lds-ripple-content">
                        <div class="lds-ripple">
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div id="GeneralInformationTable">
                        <div class="text-center">
                            <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                 style="width: 200px;margin: 0 auto" alt="">
                            <p class="pt10">
                                برای مشاهده ی فایل ها، پایه تحصیلی ، کلاس و درس مورد نظر را انتخاب نمایید
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="deleteOutput"></div>
    <input type="hidden" id="baseCur" value="{{old('base_id')}}">
    <input type="hidden" id="ClassCur" value="{{old('ClassCur')}}">
    <input type="hidden" id="LessonCur">
    <input type="hidden" id="file_type">
    <input type="hidden" id="typeCur">
    <input type="hidden" id="teacherCur" value="{{$teacherId}}">
@stop
@section('js')
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script type="text/javascript" charset="utf-8"
            src="{{ asset('Assets/Admin/js/custom-file-input.js')}}"></script>

    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>



    <script type="text/javascript">
        classList();
        $("#base_id").change(function () {
            var base = $(this).val();
            $("#baseCur").val(base);
            $("#ClassCur").val("");
            $("#LessonCur").val("");
            $('#lesson_id').html("<option value=''>انتخاب نشده</option>");
            classList();
            lessonList();
        });


        function classList() {
            var base_id = $("#baseCur").val();
            var grade_id = $("#grade_id").val();
            var deputy_id = $("#deputy_id").val();
            var school_id = $("#school_id").val();
            var _token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: '{{route('GeneralInformation.ClassList')}}',
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

        $("#class_id").change(function () {
            var _class = $(this).val();
            $("#ClassCur").val(_class);
            lessonList();
        });

        function lessonList() {
            var class_id = $("#ClassCur").val();
            var base_id = $("#baseCur").val();
            var grade_id = $("#grade_id").val();
            var deputy_id = $("#deputy_id").val();
            var school_id = $("#school_id").val();
            var _token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: '{{route('GeneralInformation.LessonList')}}',
                data: {
                    base_id: base_id,
                    grade_id: grade_id,
                    deputy_id: deputy_id,
                    school_id: school_id,
                    _token: _token
                },
                success: function (lessonResult) {
                    if (class_id == 0) {
                        $('#lesson_id').html("<option value=''>انتخاب نشده</option>");
                    } else {
                        $('#lesson_id').html(lessonResult);
                    }

                }
            });

        }

        Table();

        $("#lesson_id").change(function () {
            var lesson = $(this).val();
            $("#LessonCur").val(lesson);
            Table();
        });

        function Table() {
            var teacher_id = $("#teacherCur").val();
            var base_id = $("#baseCur").val();
            var school_id = $("#school_id").val();
            var grade_id = $("#grade_id").val();
            var class_id = $("#ClassCur").val();
            var lesson_id = $("#LessonCur").val();
            var _token = $("#_token").val();
            $(".lds-ripple-content").fadeIn('slow');
            $.ajax({
                type: 'POST',
                url: '{{route('GeneralInformation.Table')}}',
                data: {
                    school_id: school_id,
                    teacher_id: teacher_id,
                    grade_id: grade_id,
                    base_id: base_id,
                    class_id: class_id,
                    lesson_id: lesson_id,
                    _token: _token
                },
                success: function (GeneralInformationTable) {
                    $('#GeneralInformationTable').html(GeneralInformationTable);
                    $(".lds-ripple-content").fadeOut('slow');
                }
            });
        }

        $("#file_type").change(function () {
            var _type = $(this).val();
            $("#typeCur").val(_type);
        });

        $('#file').bind('change', function () {
            var _type = $("#typeCur").val();
            if (_type) {
                var ext = $('#file').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, [_type]) == -1) {
                    toastr.error("فایل حتما بايد با پسوند '" + _type + "' باشد.").css("width", "100%")
                    $('#file').val("");
                    $('.uploader-text-icon1').text("");
                    a = 0;
                } else {
                    var picsize = (this.files[0].size);
                    if (picsize > 2000000) {
                        toastr.error("حداکثر حجم  ۲ مگابايت مي باشد.").css("width", "100%")
                        $('#file').val("");
                        $('.uploader-text-icon1').text("");
                        a = 0;
                    } else {
                        a = 1;
                    }
                }
            } else {
                toastr.error("لطفا نوع محتوای بارگذاری شده را مشخص نمایید.").css("width", "100%")
                $('#file').val("");
                $('.uploader-text-icon1').text("");
                a = 0;
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
                    file_type: {
                        required: true
                    },
                    file: {
                        required: true
                    }
                },
                messages: {
                    base_id: {
                        required: "لطفا پایه تحصیلی را انتخاب نمایید."
                    },
                    class_id: {
                        required: "لطفا کلاس را انتخاب نمایید."
                    },
                    lesson_id: {
                        required: "لطفا درس را انتخاب نمایید."
                    },
                    file_type: {
                        required: "لطفا نوع محتوای بارگذاری را انتخاب نمایید."
                    },
                    file: {
                        required: "لطفا فایل را بارگذاری نمایید."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });

    </script>
    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

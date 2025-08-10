@extends('Master_Admin::MasterPage')
@section('title')
    ویرایش پایه تحصیلی
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
                            <li class="breadcrumb-item "><a> ویرایش پایه تحصیلی</a>
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
                          action="{{route('Base.Edit', [$data['id']])}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{$userId}}" name="user_id" id="user_id">
                        <input type="hidden" value="{{ $data['id'] }}" id="baseId">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="grade_id">مقطع تحصیلی</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control"
                                                               readonly
                                                               value="{{$gradeSelect->title}}"
                                                               placeholder="مقطع تحصیلی">
                                                        <input type="hidden" class="form-control" id="grade_id"
                                                               name="grade_id"
                                                               value="{{$data['grade_id']}}">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-trending-up"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="title">عنوان پایه تحصیلی :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="title"
                                                               name="title"
                                                               value="{{ $data['title'] }}"
                                                               placeholder="عنوان"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-trending-up"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="col-md-6 col-6 ">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">ویرایش
                                                </button>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                @if(Auth()->user()->hasPermission('Base.Add'))
                                                    <a href="{{route('Base.Add')}}"
                                                       class="btn btn-danger mr-1 mb-1">انصراف</a>
                                                @else
                                                    <a href="{{route('list')}}"
                                                       class="btn btn-danger mr-1 mb-1">انصراف</a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    @if(Auth()->user()->hasPermission('Base.List'))
                        <div class="lds-ripple-content">
                            <div class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div id="BaseTable">
                            <div class="text-center">
                                <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                     style="width: 200px;margin: 0 auto" alt="">
                                <p class="pt10">
                                    برای مشاهده ی پایه های تحصیلی، مقطع تحصیلی مورد نظر را انتخاب نمایید
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" id="gradeCur" value="{{$data['grade_id']}}">
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
            base_table();
            $("#grade_id").change(function () {
                var base = $(this).val();
                $("#gradeCur").val(base);
                base_table();
            });

            function base_table() {
                var grade_id = $("#gradeCur").val();
                var baseId = $("#baseId").val();
                var _token = $("#_token").val();
                $(".lds-ripple-content").fadeIn('slow');
                $.ajax({
                    type: 'POST',
                    url: '{{route('Base.Table')}}',
                    data: {grade_id: grade_id, baseId: baseId, _token: _token},
                    success: function (BaseTable) {
                        $('#BaseTable').html(BaseTable);
                        $(".lds-ripple-content").fadeOut('slow');
                    }
                });
            }


        });


        $(function () {
            $("form#form").validate({
                rules: {
                    title: {
                        required: true
                    },
                    grade_id: {
                        required: true
                    }


                },
                messages: {
                    title: {
                        required: "لطفا پایه تحصیلی را وارد نمایید.",
                    },
                    grade_id: {
                        required: "لطفا مقطع تحصیلی را انتخاب نمایید.",
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

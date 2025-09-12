@extends('Master_Admin::MasterPage')
@section('title')
    کلاس
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
                            <li class="breadcrumb-item "><a>کلاس</a>
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
                    @if($deputyAdmin->hasPermission('ClassAssign.Add.View') || $deputyAdmin->level == "1")
                        <form id="form" class="form form-vertical" name="form" method="post"
                              action="{{route('ClassAssign.Add')}}" enctype="multipart/form-data">
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
                                                        <label for="title">عنوان کلاس :</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="title"
                                                                   name="title"
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
                    @if($deputyAdmin->hasPermission('ClassAssign.List.View') || $deputyAdmin->level == "1")
                        <div class="lds-ripple-content">
                            <div class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div id="ClassAssignTable">
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
    <input type="hidden" id="baseCur" value="{{old('base_id')}}">
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
            base_table();
            $("#base_id").change(function () {
                var base = $(this).val();
                $("#baseCur").val(base);
                base_table();
            });

            function base_table() {
                var base_id = $("#baseCur").val();
                var grade_id = $("#grade_id").val();
                var deputy_id = $("#deputy_id").val();
                var school_id = $("#school_id").val();
                var _token = $("#_token").val();
                $(".lds-ripple-content").fadeIn('slow');
                $.ajax({
                    type: 'POST',
                    url: '{{route('ClassAssign.Table')}}',
                    data: {
                        base_id: base_id,
                        grade_id: grade_id,
                        deputy_id: deputy_id,
                        school_id: school_id,
                        _token: _token
                    },
                    success: function (ClassAssignTable) {
                        $('#ClassAssignTable').html(ClassAssignTable);
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
                    base_id: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "لطفا کلاس را وارد نمایید.",
                    },
                    base_id: {
                        required: "لطفا پایه تحصیلی را انتخاب نمایید.",
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

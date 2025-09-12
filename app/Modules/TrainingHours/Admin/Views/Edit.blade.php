`@extends('Master_Admin::MasterPage')
@section('title')
    ویرایش ساعت آموزشی
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">

    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/css/bootstrap-material-datetimepicker.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                            <li class="breadcrumb-item "><a>ویرایش ساعت آموزشی</a>
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
                    @if($deputyAdmin->hasPermission('TrainingHours.Edit.View') || $deputyAdmin->level == "1")
                        <form id="form" class="form form-vertical" name="form" method="post"
                              action="{{route('TrainingHours.Edit', [$data['id']])}}" enctype="multipart/form-data">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                            <input type="hidden" value="{{$deputyId}}" name="deputy_id" id="deputy_id">
                            <input type="hidden" value="{{$SchoolSelect->id}}" name="school_id" id="school_id">
                            <input type="hidden" value="{{ $data['id'] }}" id="TrainingHoursId">

                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="grade_id">روز هفته</label>
                                                        <select
                                                            class="form-control __web-inspector-hide-shortcut__ _week_day"
                                                            name="week_day"
                                                            id="week_day" required="">
                                                            <option @if($data['week_day'] == '') selected
                                                                    @endif value="">انتخاب نشده
                                                            </option>
                                                            <option @if($data['week_day'] == '1') selected
                                                                    @endif value="1">شنبه
                                                            </option>
                                                            <option @if($data['week_day'] == '2') selected
                                                                    @endif value="2">یک شنبه
                                                            </option>
                                                            <option @if($data['week_day'] == '3') selected
                                                                    @endif value="3">دو شنبه
                                                            </option>
                                                            <option @if($data['week_day'] == '4') selected
                                                                    @endif value="4">سه شنبه
                                                            </option>
                                                            <option @if($data['week_day'] == '5') selected
                                                                    @endif value="5">چهار شنبه
                                                            </option>
                                                            <option @if($data['week_day'] == '6') selected
                                                                    @endif value="6">پنج هفته
                                                            </option>
                                                            <option @if($data['week_day'] == '7') selected
                                                                    @endif value="7">جمعه
                                                            </option>

                                                        </select>
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
                                                            <option @if($data['time_number'] == '') selected
                                                                    @endif value="">انتخاب نشده
                                                            </option>
                                                            <option @if($data['time_number'] == '1') selected
                                                                    @endif value="1">1
                                                            </option>
                                                            <option @if($data['time_number'] == '2') selected
                                                                    @endif value="2">2
                                                            </option>
                                                            <option @if($data['time_number'] == '3') selected
                                                                    @endif value="3">3
                                                            </option>
                                                            <option @if($data['time_number'] == '4') selected
                                                                    @endif value="4">4
                                                            </option>
                                                            <option @if($data['time_number'] == '5') selected
                                                                    @endif value="5">5
                                                            </option>
                                                            <option @if($data['time_number'] == '6') selected
                                                                    @endif value="6">6
                                                            </option>
                                                            <option @if($data['time_number'] == '7') selected
                                                                    @endif value="7">7
                                                            </option>
                                                            <option @if($data['time_number'] == '8') selected
                                                                    @endif value="8">8
                                                            </option>
                                                            <option @if($data['time_number'] == '9') selected
                                                                    @endif value="9">9
                                                            </option>
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
                                                                   value="{{$data['start_time']}}"
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
                                                                   value="{{$data['end_time']}}"
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
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">ویرایش
                                                    </button>
                                                </div>
                                                <div class="col-md-6 col-6">
                                                    <a href="{{route('TrainingHours.Add')}}"
                                                       class="btn btn-danger mr-1 mb-1">انصراف</a>
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
    <input type="hidden" id="weekDayCur" value="{{$data['week_day']}}">
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
            $("#week_day").change(function () {
                var day = $(this).val();
                $("#weekDayCur").val(day);
                base_table();
            });

            function base_table() {
                var TrainingHoursId = $("#TrainingHoursId").val();
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
                        TrainingHoursId: TrainingHoursId,
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



    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

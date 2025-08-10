@extends('Master_Admin::MasterPage')
@section('title')
    برنامه هفتگی
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

        .plan {
            border-bottom: 1px dashed;
            margin-bottom: 5px;
        }

        @media (max-width: 992px) {
            .weekDay {
                width: 100% !important;
            }
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
                            <li class="breadcrumb-item "><a>برنامه هفتگی</a>
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
                        <input type="hidden" value="{{$assignSelect->grade_id}}" name="grade_id" id="grade_id">
                        <input type="hidden" value="{{$SchoolSelect->id}}" name="school_id" id="school_id">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12 col-12" id="weekTable">
                                                @foreach($TrainingDays as $item)
                                                    @if($item->week_day == '1')
                                                        @php($week_day = "شنبه")
                                                    @elseif($item->week_day == '2')
                                                        @php($week_day = "یک شنبه")
                                                    @elseif($item->week_day == '3')
                                                        @php($week_day = "دو شنبه")
                                                    @elseif($item->week_day == '4')
                                                        @php($week_day = "سه شنبه")
                                                    @elseif($item->week_day == '5')
                                                        @php($week_day = "چهار شنبه")
                                                    @elseif($item->week_day == '6')
                                                        @php($week_day = "پنج شنبه")
                                                    @elseif($item->week_day == '7')
                                                        @php($week_day = "شنبه")
                                                    @endif
                                                    <section class="plan cf" id="plan_{{$item->week_day}}">
                                                        <span class="weekDay">
                                                            @if($item->week_day == $WeekDayNumber)
                                                                <b style="color: #f87008">{{$week_day}}</b>
                                                            @else
                                                                {{$week_day}}
                                                            @endif
                                                        </span>
                                                        @foreach($TrainingHours[$item->id] as $item2)
                                                            @if($Schedule[$item2->id])
                                                                @if($item2->start_time <= $timeNow && $item2->end_time >= $timeNow && $item2->week_day == $WeekDayNumber)
                                                                    <script>
                                                                        $(".btn-primary").css('display', 'none');
                                                                    </script>
                                                                    <span class="spanWeek">
                                                                        <input checked type="radio"
                                                                               name="week[{{$item->week_day}}]"
                                                                               id="free{{$item2->id}}"
                                                                               value="{{$item->week_day}}**{{$item2->time_number}}"
                                                                               class="radioWeek">
                                                                        <label
                                                                            class="free-label four col"
                                                                            for="free{{$item2->id}}"
                                                                            data-toggle="popover"
                                                                            data-original-title="از ساعت {{$item2->start_time}}"
                                                                            data-content="تا ساعت {{$item2->end_time}}"
                                                                            data-trigger="hover" data-placement="top"
                                                                            style="background-color:#f87008">
                                                                            <span
                                                                                style="font-size: 11px;display: inline-block;height: 30px;width: 100%;line-height: 30px;float: right">
                                                                                <span> زنگ :</span> <b>{{$item2->time_number}}</b>
                                                                            </span>
                                                                            <span
                                                                                style="font-size: 11px;display: inline-block;height: 30px;width: 100%;line-height: 30px;float: right">
                                                                                <span> کلاس :</span> <b>{{$classSelect[$item2->id]->title}}</b>
                                                                            </span>
                                                                            <span
                                                                                style="font-size: 11px;display: inline-block;height: 30px;width: 100%;line-height: 30px;float: right">
                                                                                <b>{{$lessonSelect[$item2->id]->title}}</b>
                                                                            </span>
                                                                            <span class="clear"></span>
                                                                        </label>
                                                                    </span>
                                                                @else
                                                                    <span class="spanWeek">
                                                                <input disabled type="radio"
                                                                       name="week[{{$item->week_day}}]"
                                                                       id="free{{$item2->id}}"
                                                                       value="{{$item->week_day}}**{{$item2->time_number}}"
                                                                       class="radioWeek">
                                                                <label class="free-label four col"
                                                                       for="free{{$item2->id}}" data-toggle="popover"
                                                                       data-original-title="از ساعت {{$item2->start_time}}"
                                                                       data-content="تا ساعت {{$item2->end_time}}"
                                                                       data-trigger="hover" data-placement="top">
                                                                            <span
                                                                                style="font-size: 11px;display: inline-block;height: 30px;width: 100%;line-height: 30px;float: right">
                                                                                <span> زنگ :</span> <b>{{$item2->time_number}}</b>
                                                                            </span>
                                                                            <span
                                                                                style="font-size: 11px;display: inline-block;height: 30px;width: 100%;line-height: 30px;float: right">
                                                                                <span> کلاس :</span> <b>{{$classSelect[$item2->id]->title}}</b>
                                                                            </span>
                                                                            <span
                                                                                style="font-size: 11px;display: inline-block;height: 30px;width: 100%;line-height: 30px;float: right">
                                                                                <b>{{$lessonSelect[$item2->id]->title}}</b>
                                                                            </span>
                                                                            <span class="clear"></span>
                                                                </label>
                                                            </span>
                                                                @endif

                                                            @endif
                                                        @endforeach
                                                        <div class="clear"></div>
                                                    </section>
                                                    <div class="clear"></div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <br>
                                        <hr>
                                        <div class="col-12 col-md-12 col-12 text-center">
                                            <a href="#" class="btn btn-primary mr-auto" style="display: none">ورود به
                                                کلاس (همین حالا!)
                                            </a>
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
    <input type="hidden" id="ClassCur">
    <input type="hidden" id="teacherCur" value="{{$teacherId}}">
@stop
@section('js')
    @foreach($TrainingDays as $item)
        @foreach($TrainingHours[$item->id] as $item2)
            @if($Schedule[$item2->id])
                @if($item2->start_time <= $timeNow && $item2->end_time >= $timeNow && $item2->week_day == $WeekDayNumber)
                    <script>
                        $(".btn-primary").css('display', 'inline-block');
                        $("#ClassCur").val('{{$item->id}}');
                        $(".btn-primary").attr('href', '{{route("ClassRoom.Show.View", $Schedule[$item2->id]->id)}}');
                    </script>
                @endif
            @endif
        @endforeach
    @endforeach
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">

        // $(document).ready(function () {
        //     $('.radioWeek:checked').click(function(){
        //         $(this).attr('checked', false);
        //     });
        //     $(function(){
        //         $('input.radioWeek').click(function(){
        //             var $radio = $(this);
        //             if ($radio.data('waschecked') == true)
        //             {
        //                 $radio.prop('checked', false);
        //                 $radio.data('waschecked', false);
        //             }
        //             else
        //                 $radio.data('waschecked', true);
        //             $radio.siblings('input[name="rad"]').data('waschecked', false);
        //         });
        //     });
        // });
        $(document).ready(function () {
            $('[id]').each(function (i) {
                $('[id="' + this.id + '"]').slice(1).remove();
            });
        });
        $(function () {
            $("form#form").validate({
                rules: {},
                messages: {},
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
            src="{{asset('Assets/Admin/js/scripts/popover/popover.js')}}"></script>

    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

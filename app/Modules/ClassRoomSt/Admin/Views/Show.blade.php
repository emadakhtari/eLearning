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
                        <input type="hidden" value="{{$id->class_id}}" name="class_id" id="class_id">
                        <input type="hidden" value="{{$id->lesson_id}}" name="lesson_id" id="lesson_id">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                @if($MeetingInfo->isEmpty())
                                                    <p>در حال حاظر مدرس کلاس را شروع نکرده است.</p>
                                                @else
                                                    @if($url)
                                                        <iframe src="{{$url}}" frameborder="0" style="display: block; background: #fff; border: none; width: 100%;"></iframe>
                                                    @else
                                                        <p>در حال حاظر مدرس کلاس را شروع نکرده است.</p>
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

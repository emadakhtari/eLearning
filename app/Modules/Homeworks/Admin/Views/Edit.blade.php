@extends('Master_Admin::MasterPage')
@section('title')
    مشاهده تکالیف
@endsection
@section('CSS')
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
                            <li class="breadcrumb-item "><a>مشاهده تکالیف</a>
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
                <div class="col-md-6 col-12">
                    <form id="form" class="form form-vertical" name="form" method="post"
                          action="{{route('Homeworks.Edit', [$data['id']])}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="{{$teacherId}}" name="teacherId" id="teacherId">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="base_id">پایه :</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="base_id"
                                                               name="base_id"
                                                               value="{{$baseSelect->title}}"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="class_id">کلاس :</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="class_id"
                                                               name="class_id"
                                                               value="{{$classSelect->title}}"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="lesson_id">درس :</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="lesson_id"
                                                               name="lesson_id"
                                                               value="{{$lessonSelect->title}}"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="student">نام و نام خانوادگی دانش آموز :</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" id="student"
                                                               name="student"
                                                               value="{{$studentSelect->name}} {{$studentSelect->family}}"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <fieldset>
                                                    <div class="radio radio-success">
                                                        <input type="radio"
                                                               @if($data['status'] == '1')
                                                                   checked
                                                               @endif
                                                               name="status" id="status_complete" value="1">
                                                        <label for="status_complete">کامل است ، متشکرم !</label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <fieldset>
                                                    <div class="radio radio-warning">
                                                        <input type="radio"
                                                               @if($data['status'] == '2')
                                                               checked
                                                               @endif
                                                               name="status" id="status_incomplete" value="2">
                                                        <label for="status_incomplete">ناقص است</label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <fieldset>
                                                    <div class="radio radio-danger">
                                                        <input type="radio"
                                                               @if($data['status'] == '3')
                                                               checked
                                                               @endif
                                                               name="status" id="status_NotApproved" value="3">
                                                        <label for="status_NotApproved">تکالیف مورد تایید نیست</label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="base_id">توضیحات تکمیلی :</label>
                                                    <fieldset class="form-group">
                                                        <textarea class="form-control" name="details" id="details" rows="3" placeholder="توضیحات تکمیلی">{!! $data['details'] !!}</textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
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
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            @if($data['file_type'] == 'jpg' || $data['file_type'] == 'jpeg')
                                <img src="{{asset('upload/students/homeworks/'.$data['file'])}}" alt="" style="width: 100%;border-radius: 30px">
                                <a href="{{asset('upload/students/homeworks/'.$data['file'])}}" class="btn btn-icon btn-secondary mt-1 mr-1 mb-1" download><i class="bx bx-download mr-1"></i>دانلود  </a>
                            @else
                                <a href="{{asset('upload/students/homeworks/'.$data['file'])}}" class="btn btn-icon btn-secondary mt-1 mr-1 mb-1" download><i class="bx bx-download mr-1"></i>دانلود  </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif
@stop
@section('js')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
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

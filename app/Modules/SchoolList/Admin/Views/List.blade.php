@extends('Master_Admin::MasterPage')
@section('title')
    مراکز آموزش موجود
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
                            <li class="breadcrumb-item "><a>مراکز آموزش موجود</a>
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
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb0" style="position: relative">
                                                <select class="select2 form-control _province" name="province"
                                                        id="province">
                                                    <option value="">انتخاب استان</option>
                                                    @foreach($state as $item)
                                                        <option value="{{$item->id}}">{{$item->State_Name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb0" style="position: relative">
                                                <select class="select2 form-control _city" name="city"
                                                        id="city">
                                                    <option value="">انتخاب شهر</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" class="form-control" id="search"
                                                           name="search"
                                                           placeholder="عنوان مرکز آموزش">
                                                    <div class="form-control-position">
                                                        <i class="bx bx-trending-up"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 result" id="resultSchoolList">

                </div>
            </div>
        </section>
    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
@stop
@section('js')
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/Lists/Lists.js')}}"></script>



    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript">
        $("#province").change(function () {
                var province = $(this).val();
                var _token = $("#_token").val();
                $.ajax({
                    type: 'POST',
                    url: '{{route('School.provinceSelect')}}',
                    data: {province: province, _token: _token},
                    success: function (cityResult) {
                        $('#city').html(cityResult);
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
    <script src="{{asset('Assets/Admin/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/js/scripts/forms/select/form-select2.js')}}"></script>
    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

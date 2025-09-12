@extends('Master_Admin::MasterPage')
@section('title')
    مقطع تحصیلی
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
                            <li class="breadcrumb-item "><a>مقطع تحصیلی</a>
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
                          action="{{route('Grade.Add')}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="{{$userId}}" name="user_id" id="user_id">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="title">عنوان مقطع تحصیلی :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="title"
                                                               name="title"
                                                               value="{{old('title')}}"
                                                               placeholder="عنوان"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-trending-up"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <fieldset>
                                                    <div class="checkbox checkbox-success checkbox-glow">
                                                        <input type="checkbox" id="forced" name="forced" value="1">
                                                        <label for="forced">کلیه پایه های این مقطع تحصیلی اجباری بوده و پایه اختیاری ندارد.</label>
                                                    </div>
                                                </fieldset>
                                            </div>
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
                    @if(Auth()->user()->hasPermission('Grade.List'))
                        @if(!$grade->isEmpty())
                            <div class="card">
                                <div class="scrollbar-external_wrapper">
                                    <div class="scrollbar-external">
                                        <div class="table-">
                                            <table id="table-extended-chechbox" class="table table-transparent">
                                                <thead>
                                                <tr>
                                                    <th style="width: 24px !important;"><i class="bx bx-x" style=""></i></th>
                                                    <th>شناسه</th>
                                                    <th>عنوان</th>
                                                    <th>اجباری</th>
                                                    @if($userCategorySelect->id == '1')
                                                        <th>کاربر ایجاد کننده</th>
                                                    @endif
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php($row=0)
                                                @foreach($grade as $item)
                                                    <tr class="text-center" id="tr_{{$item['id']}}">
                                                        <td>
                                                            @if(Auth()->user()->hasPermission('Grade.Edit'))
                                                                <fieldset>
                                                                    <div class="radio radio-shadow">
                                                                        <input type="radio" class="radioshadow"
                                                                               id="radioshadow{{$item['id']}}"
                                                                               name="edit"
                                                                               value="{{$item['id']}}">
                                                                        <label for="radioshadow{{$item['id']}}"></label>
                                                                    </div>
                                                                </fieldset>
                                                            @endif
                                                        </td>
                                                        <td class="text-bold-500">{{$item['id']}}</td>
                                                        <td>{{$item['title']}}</td>
                                                        <td id="forced_{{$item['id']}}">
                                                            @if($item['forced']==1)
                                                                بلی
                                                            @else
                                                                خیر
                                                            @endif
                                                        </td>
                                                        @if($userCategorySelect->id == '1')
                                                            <td>
                                                                {{$userCreate[$row]->name}} {{$userCreate[$row]->family}}
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    @php($row++)
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="external-scroll_x">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar"></div>
                                        </div>
                                    </div>
                                    <div class="external-scroll_y">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 text-right stocks_list">
                            </div>
                        @else
                            <div class="text-center">
                                <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                                     style="width: 200px;margin: 0 auto" alt="">
                                <p class="pt10">
                                    آیتمی جهت نمایش وجود ندارد!
                                </p>
                            </div>
                        @endif
                    @endif

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
        $(document).ready(function () {
            $('input[type=radio][name=edit]').change(function () {
                var url = '{{ route("Grade.Edit", ":id") }}';

                url = url.replace(':id', this.value);
                $(".stocks_list a").remove();
                $('.stocks_list').append('<a class="btn btn-primary mr-1 mb-1 edit-btn" style="float:right" href="' + url + '">ویرایش </a></li>');
            });
            $('.radioshadow').click(function () {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".bx-x").not(targetBox).css("display", "block");
                $(".edit-btn").not(targetBox).css("display", "block");
                $(targetBox).hide();
            });
            $('.bx-x').click(function () {
                $(".radioshadow").prop("checked", false);
                $(".bx-x").css("display", "none");
                $(".stocks_list a").remove();
            });

            $('.scrollbar-external').scrollbar({
                "autoScrollSize": false,
                "scrollx": $('.external-scroll_x'),
                "scrolly": $('.external-scroll_y')
            });
        });


        $(function () {
            $("form#form").validate({
                rules: {
                    title: {
                        required: true
                    }


                },
                messages: {
                    title: {
                        required: "لطفا مقطع تحصیلی را وارد نمایید.",
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
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                "sEmptyTable": "هیچ داده ای در جدول وجود ندارد",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            }
        });
        // table extended checkbox
        var tablecheckbox = $('#table-extended-chechbox').DataTable({
            "searching": true,
            "lengthChange": true,
            "paging": false,
            "bInfo": false,
            'columnDefs': [{
                "orderable": false,
                @if($userCategorySelect->id == '1')
                "targets": [0,3]
                @else
                "targets": [0,2,3]
                @endif

            }, //to disable sortying in col 0,3 & 4

            ],
            'select': 'multi',
            'order': [
                [1, 'desc']
            ]
        });

    </script>
    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

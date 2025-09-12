@extends('Master_Admin::MasterPage')
@section('title')
    ویرایش گروه کاربری
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
    <style>
        #tr_{{$data['id']}}   {
            background: #DCDFE2;
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
                            <li class="breadcrumb-item"><a>گروه کاربری</a>
                            </li>
                            <li class="breadcrumb-item active"><a>ویرایش گروه کاربری</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body"><!-- Basic Horizontal form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <form id="form" class="form form-vertical" name="form" method="post"
                          action="{{route('UserCategory.Edit', [$data['id']])}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="{{$data['id']}}" id="id" name="id">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="title">عنوان</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="title"
                                                               name="title"
                                                               value="{{$data['userCategory']['title']}}"
                                                               placeholder="عنوان"
                                                               required="">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="card-header">
                                                <h4 class="card-title"> دسترسی</h4>
                                            </div>
                                            <div class="col-md-12 mb-12">
                                                <div id="modules_user">
                                                    <?php $row = 1; ?>
                                                    <?php $perms = json_decode($data['userCategory']['permissions'], true)['admin']; ?>
                                                    @foreach($data['modules'] as $module)
                                                        @if($module['permissions'])
                                                            <div class="col-md-12 col-1 border-bottom-dashed pb5 pt5">
                                                            <div class="custom-control custom-switch mr-2 mb-1">
                                                                <p class="mb-0">{{trans('modules.'.$module['moduleName'])}}</p>
                                                                <input name="modules[]" type="checkbox"
                                                                       class="custom-control-input" checked
                                                                       id="firstCheck_{{$module['moduleName']}}"
                                                                       value="{{$module['moduleName']}}"
                                                                @if(!empty($perms[$module['moduleName']]))
                                                                    {{'checked'}}
                                                                    @endif>
                                                                <label class="custom-control-label"
                                                                       for="firstCheck_{{$module['moduleName']}}">
                                                                    <span class="switch-icon-left"><i
                                                                            class="bx bx-check"></i></span>
                                                                    <span class="switch-icon-right"><i
                                                                            class="bx bx-x"></i></span>
                                                                </label>
                                                            </div>
                                                            @foreach($module['permissions'] as $perm)
                                                                <div class="custom-control custom-switch mr-2 mb-1">
                                                                    <p class="mb-0">{{trans('modules.'. key($perm))}}</p>
                                                                    <input name="{{$module['moduleName']}}[]"
                                                                           type="checkbox" class="custom-control-input"
                                                                           id="secCheck_{{$row}}"
                                                                           value="{{json_encode($perm)}}"
                                                                    @if(!empty($perms[$module['moduleName']]['permissions']))
                                                                        @foreach($perms[$module['moduleName']]['permissions'] as $p )

                                                                            @if(   key(json_decode($p,true)) == key($perm)   )
                                                                                {{'checked'}}
                                                                                @endif
                                                                            @endforeach
                                                                        @endif>
                                                                    <label class="custom-control-label"
                                                                           for="secCheck_{{$row}}">
                                                                        <span class="switch-icon-left"><i
                                                                                class="bx bx-check"></i></span>
                                                                        <span class="switch-icon-right"><i
                                                                                class="bx bx-x"></i></span>
                                                                    </label>
                                                                </div>
                                                                <?php $row++; ?>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <hr style="width: 100%">
                                            <div class="col-md-12 col-12">
                                                <div
                                                    class="custom-control custom-switch custom-switch-status custom-switch-success mr-2 mb-1">
                                                    <p class="mb-0">وضعیت</p>
                                                    <input name="status" type="checkbox" class="custom-control-input"
                                                           id="status"
                                                           value="1" @if($data['userCategory']['status']==1)
                                                        {{'checked'}}
                                                        @endif>
                                                    <label class="custom-control-label" for="status">
                                                        <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                        <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <br>
                                            <hr>
                                            <div class="col-md-6 col-6 ">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">ویرایش</button>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <a href="{{route('UserCategory.Add')}}"
                                                   class="btn btn-danger mr-1 mb-1">انصراف</a>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    @if(!$usersCategory->isEmpty())
                        <div class="card">
                            <div class="scrollbar-external_wrapper">
                                <div class="scrollbar-external">
                                    <div class="table-">
                                        <table id="table-extended-chechbox" class="table table-transparent">
                                            <thead>
                                            <tr>
                                                <th style="display: none"></th>
                                                <th>شناسه</th>
                                                <th>عنوان</th>
                                                <th>وضعیت</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($usersCategory as $item)
                                                <tr class="text-center" id="tr_{{$item['id']}}">
                                                    <td style="display: none"></td>
                                                    <td class="text-bold-500">{{$item['id']}}</td>
                                                    <td>{{$item['title']}}</td>
                                                    <td id="status_{{$item['id']}}">
                                                        @if($item['status']==1)
                                                            {{'فعال'}}
                                                        @else
                                                            {{'غیر فعال'}}
                                                        @endif
                                                    </td>
                                                </tr>
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

                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
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
                var url = '{{ route("UserCategory.Edit", ":id") }}';

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
                        required: "لطفا عنوان را وارد نمایید.",
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
                "targets": [0, 3]
            }, //to disable sortying in col 0,3 & 4

            ],
            'select': 'multi',
            'order': [
                [1, 'desc']
            ]
        });
        @if(session()->has('success'))
        $(document).ready(function () {
            Command: toastr["success"]("{{session()->get('success')}}", "");
        });
        @endif
    </script>
    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
@stop

@extends('Master_Admin::MasterPage')
@section('title')
     مدیریت تنظیمات
@endsection
@section('CSS')
    <style>
        .custom-switch {
            width: 13% !important;
            text-align: center;
            max-width: 13% !important;
        }

        .custom-form-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed;
        }
        .btn-image {
            width: 90px;
            margin-right: 10px;
            margin-top: 20px;
        }
        .btn-danger.btn-floating {
            margin-top: 20px;
        }
    </style>
         <!-- begin::Crop -->
     <link rel="stylesheet" type="text/css"
          href="{{ asset('Assets/Admin/css/fineCrop.css')}}">
     <!-- begin::Crop -->
@stop
@section('content')

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{route('list')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active"><a> مدیریت تنظیمات</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body"><!-- Basic Horizontal form layout section start -->
        <style>
            #page-account-settings .bx{
                margin-left: 10px;
            }

        </style>
                    <section id="page-account-settings">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <!-- left menu section -->
                                    <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                                        <ul class="nav nav-pills flex-column">
                                            <li class="nav-item">

                                                <a aria-expanded="true" class="nav-link d-flex align-items-center active" data-toggle="pill" href="#account-vertical-general" id="account-pill-general">
                                                    <i class="bx bxs-pencil"></i>
                                                    <span>
                                                        متن ها
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a aria-expanded="false" class="nav-link d-flex align-items-center" data-toggle="pill" href="#account-vertical-password" id="account-pill-password">
                                                    <i class="bx bxs-image-add"></i>
                                                    <span>
                                                        تصاویر
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- right content section -->
                                    <div class="col-md-9 mb-10">
                                        <form id="form" class="form form-vertical" name="form" method="post"
                                            action="{{route('Setting.Edit', 1)}}" enctype="multipart/form-data">
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="tab-content">
                                                            <div aria-expanded="true" aria-labelledby="account-pill-general" class="tab-pane active" id="account-vertical-general" role="tabpanel">


                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="title">عنوان سایت</label>
                                                                                <div class="position-relative">
                                                                                    <input type="text" class="form-control" id="title"
                                                                                           name="title"
                                                                                           value="{{$data['title']}}"
                                                                                           placeholder="عنوان سایت"
                                                                                           required="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-12">
                                                                            <fieldset class="form-label-group">
                                                                              <textarea class="form-control" id="software_text" name="software_text" rows="2" placeholder="عنوان نرم افزار">{{$data['software_text']}}</textarea>
                                                                              <label for="software_text">نام نرم افزار</label>
                                                                          </fieldset>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-12">
                                                                            <fieldset class="form-label-group">
                                                                              <textarea class="form-control" id="owner_text" name="owner_text" rows="2" placeholder="نام صاحب نرم افزار">{{$data['owner_text']}}</textarea>
                                                                              <label for="keywords">نام صاحب نرم افزار</label>
                                                                          </fieldset>
                                                                        </div>
                                                                    </div>

                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-12">
                                                                            <fieldset class="form-label-group">
                                                                              <textarea class="form-control" id="powered_text" name="powered_text" rows="2" placeholder="متن قدرت یافته">{{$data['powered_text']}}</textarea>
                                                                              <label for="powered_text">متن قدرت یافته</label>
                                                                          </fieldset>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-12">
                                                                            <fieldset class="form-label-group">
                                                                              <textarea class="form-control" id="license_text" name="license_text" rows="2" placeholder="متن لایسنس">{{$data['license_text']}}</textarea>
                                                                              <label for="license_text">متن لایسنس</label>
                                                                          </fieldset>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </div>
                                                            <div aria-expanded="false" aria-labelledby="account-pill-password" class="tab-pane fade " id="account-vertical-password" role="tabpanel">
                                                                <div class="form-body">
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-7 col-12">
                                                                            <div class="form-group">
                                                                                <label for="login_image">تصویر ورودیه</label>
                                                                                <input type="hidden" name="login_imageuploud" id="login_imageuploud" value="{{$data['login_image']}}">
                                                                                <input type="file" name="login_image" id="login_image" class="inputfile inputfile-6">
                                                                                <label for="login_image" class="form-control">
                                                                                    <strong class="image-lable"> (png.)
                                                                                        <svg class="uploadIconSvg" xmlns="http://www.w3.org/2000/svg"
                                                                                             width="20"
                                                                                             height="17" viewBox="0 0 20 17">
                                                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                                                        </svg>
                                                                                    </strong>
                                                                                    <span class="uploader-text-icon uploader-text-icon1">{{$data['login_image']}}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            @if ($data['login_image'])
                                                                                <a type="button" class="btn btn-danger btn-floating sweet-multiple_1 removeImageLink1"
                                                                                   data-toggle="modal"
                                                                                   data-target="#exampleModal1" id="deleteImgBtn1" style="">
                                                                                   <i class="livicon-evo" data-options="name: trash.svg; size: 50px; style: original;"></i>
                                                                                </a>
                                                                                <input type="hidden" name="originallogin_image" id="originallogin_image"
                                                                                       value="{{$data['login_image']}}">
                                                                                <img class="btn-image" id="croppedImg1" src="{{asset('upload/setting/'.$data['login_image'])}}">

                                                                                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                                                                                     aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                                                    <div class="modal-dialog" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-body">
                                                                                                ﺁﯾﺎ اﺯ ﺣﺬﻑ اﯾﻦ تصویر اﻃﻤﯿﻨﺎﻥ ﺩاﺭﯾﺪ؟
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        data-dismiss="modal">خیر
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-danger" id="deleteImg1"
                                                                                                        rel="{{$data['id']}}" data-dismiss="modal">بله
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-7 col-12">
                                                                            <div class="form-group">
                                                                                <label for="top_menu_image">تصویر بالای منو</label>
                                                                                <input type="hidden" name="top_menu_imageuploud" id="top_menu_imageuploud" value="{{$data['top_menu_image']}}">
                                                                                <input type="file" name="top_menu_image" id="top_menu_image" class="inputfile inputfile-6">
                                                                                <label for="top_menu_image" class="form-control">
                                                                                    <strong class="image-lable"> (png.)
                                                                                        <svg class="uploadIconSvg" xmlns="http://www.w3.org/2000/svg"
                                                                                             width="20"
                                                                                             height="17" viewBox="0 0 20 17">
                                                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                                                        </svg>
                                                                                    </strong>
                                                                                    <span class="uploader-text-icon uploader-text-icon2">{{$data['top_menu_image']}}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            @if ($data['top_menu_image'])
                                                                                <a type="button" class="btn btn-danger btn-floating sweet-multiple_2 removeImageLink2"
                                                                                   data-toggle="modal"
                                                                                   data-target="#exampleModal2" id="deleteImgBtn2" style="">
                                                                                   <i class="livicon-evo" data-options="name: trash.svg; size: 50px; style: original;"></i>
                                                                                </a>
                                                                                <input type="hidden" name="originaltop_menu_image" id="originaltop_menu_image"
                                                                                       value="{{$data['top_menu_image']}}">
                                                                                <img class="btn-image" id="croppedImg2" src="{{asset('upload/setting/'.$data['top_menu_image'])}}">

                                                                                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                                                                                     aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                                                                    <div class="modal-dialog" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-body">
                                                                                                ﺁﯾﺎ اﺯ ﺣﺬﻑ اﯾﻦ تصویر اﻃﻤﯿﻨﺎﻥ ﺩاﺭﯾﺪ؟
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        data-dismiss="modal">خیر
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-danger" id="deleteImg2"
                                                                                                        rel="{{$data['id']}}" data-dismiss="modal">بله
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-7 col-12">
                                                                            <div class="form-group">
                                                                                <label for="signature_image">تصویر امضاء</label>
                                                                                <input type="hidden" name="signature_imageuploud" id="signature_imageuploud" value="{{$data['signature_image']}}">
                                                                                <input type="file" name="signature_image" id="signature_image" class="inputfile inputfile-6">
                                                                                <label for="signature_image" class="form-control">
                                                                                    <strong class="image-lable"> (png.)
                                                                                        <svg class="uploadIconSvg" xmlns="http://www.w3.org/2000/svg"
                                                                                             width="20"
                                                                                             height="17" viewBox="0 0 20 17">
                                                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                                                        </svg>
                                                                                    </strong>
                                                                                    <span class="uploader-text-icon uploader-text-icon3">{{$data['signature_image']}}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-12">
                                                                            @if ($data['signature_image'])
                                                                                <a type="button" class="btn btn-danger btn-floating sweet-multiple_3 removeImageLink3"
                                                                                   data-toggle="modal"
                                                                                   data-target="#exampleModal3" id="deleteImgBtn3" style="">
                                                                                    <i class="livicon-evo" data-options="name: trash.svg; size: 50px; style: original;"></i>
                                                                                </a>
                                                                                <input type="hidden" name="originalsignature_image" id="originalsignature_image"
                                                                                       value="{{$data['signature_image']}}">
                                                                                <img class="btn-image" id="croppedImg3" src="{{asset('upload/setting/'.$data['signature_image'])}}">

                                                                                <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
                                                                                     aria-labelledby="exampleModalLabel3" aria-hidden="true">
                                                                                    <div class="modal-dialog" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-body">
                                                                                                ﺁﯾﺎ اﺯ ﺣﺬﻑ اﯾﻦ تصویر اﻃﻤﯿﻨﺎﻥ ﺩاﺭﯾﺪ؟
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        data-dismiss="modal">خیر
                                                                                                </button>
                                                                                                <button type="button" class="btn btn-danger" id="deleteImg3"
                                                                                                        rel="{{$data['id']}}" data-dismiss="modal">بله
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            @endif
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 col-12 d-flex justify-content-end">
                                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">ویرایش</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- account setting page ends -->
        <!-- // Basic Vertical form layout section end -->
    </div>
@stop
@section('js')

    <!-- begin::Custom File -->
    <script type="text/javascript" charset="utf-8"
            src="{{ asset('Assets/Admin/js/custom-file-input.js')}}"></script>
    <!-- end::Custom File -->


    <!-- begin::CKEditor -->
    <script type="text/javascript"
            src="{{asset('Assets/Admin/ckeditor/ckeditor.js')}}"></script>
    <!-- end::CKEditor -->

    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#deleteImg1").click(function () {
                $("#originallogin_image").val('');
                $("#croppedImg1").removeAttr('src');
                $(".uploader-text-icon1").text('');
                $("#deleteImgBtn1").fadeOut('slow');
            });
            $("#deleteImg2").click(function () {
                $("#originaltop_menu_image").val('');
                $("#croppedImg2").removeAttr('src');
                $(".uploader-text-icon2").text('');
                $("#deleteImgBtn2").fadeOut('slow');
            });
            $("#deleteImg3").click(function () {
                $("#originalsignature_image").val('');
                $("#croppedImg3").removeAttr('src');
                $(".uploader-text-icon3").text('');
                $("#deleteImgBtn3").fadeOut('slow');
            });

            $("#lat").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#lat").val(persianToEnglish($(this).val()));
                }
            });
            $("#long").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#long").val(persianToEnglish($(this).val()));
                }
            });
        });

        function persianToEnglish(input) {
            var inputstring = input;
            var persian = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"]
            var english = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]
            for (var i = 0; i < 10; i++) {
                var regex = new RegExp(persian[i], "g");
                inputstring = inputstring.toString().replace(regex, english[i]);
            }
            return inputstring;
        }


        $('#login_image').bind('change', function () {
            var ext = $('#login_image').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png','jpg','jpeg']) == -1) {
                toastr.error("تصوير حتما بايد با پسوند 'png' یا 'jpg' یا' jpeg' باشد.").css("width", "100%")
                $('#login_image').val("");
                $('.uploader-text-icon1').text("");
                a = 0;
            } else {
                var picsize = (this.files[0].size);
                if (picsize > 2000000) {
                     toastr.error("حداکثر حجم تصوير ۲ مگابايت مي باشد.").css("width", "100%")
                    $('#login_image').val("");
                    $('.uploader-text-icon1').text("");
                    a = 0;
                } else {
                    a = 1;

                }
            }
        });

        $('#top_menu_image').bind('change', function () {
            var ext = $('#top_menu_image').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png','jpg','jpeg']) == -1) {
                toastr.error("تصوير حتما بايد با پسوند 'png' یا 'jpg' یا' jpeg' باشد.").css("width", "100%")
                $('#top_menu_image').val("");
                $('.uploader-text-icon2').text("");
                a = 0;
            } else {
                var picsize = (this.files[0].size);
                if (picsize > 2000000) {
                     toastr.error("حداکثر حجم تصوير ۲ مگابايت مي باشد.").css("width", "100%")
                    $('#top_menu_image').val("");
                    $('.uploader-text-icon2').text("");
                    a = 0;
                } else {
                    a = 1;

                }
            }
        });

        $('#signature_image').bind('change', function () {
            var ext = $('#signature_image').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png','jpg','jpeg']) == -1) {
                toastr.error("تصوير حتما بايد با پسوند 'png' یا 'jpg' یا' jpeg' باشد.").css("width", "100%")
                $('#signature_image').val("");
                $('.uploader-text-icon3').text("");
                a = 0;
            } else {
                var picsize = (this.files[0].size);
                if (picsize > 2000000) {
                     toastr.error("حداکثر حجم تصوير ۲ مگابايت مي باشد.").css("width", "100%")
                    $('#signature_image').val("");
                    $('.uploader-text-icon3').text("");
                    a = 0;
                } else {
                    a = 1;

                }
            }
        });
        CKEDITOR.replace('software_text');
        CKEDITOR.replace('owner_text');
        CKEDITOR.replace('powered_text');
        CKEDITOR.replace('license_text');
        CKEDITOR.editorConfig = function (config) {
            config.direction = 'rtl';
            // Define changes to default configuration here. For example:
            config.language = 'fa';
            config.uiColor = '#EEF1F9';
            // config.filebrowserBrowseUrl = '/kiabours/public/elfinder/ckeditor';
        };

        $(function () {
            $("form#form").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    title: {
                        required: "لطفا عنوان را وارد نمایید.",
                        minlength: "حداقل کاراکتر برای عنوان باید ۳ حرف باشد."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
        @if(session()->has('successSettingEdit'))
            $(document).ready(function () {
                Command: toastr["success"]("{{session()->get('successSettingEdit')}}", "");
            });
        @endif
        @foreach($errors->all() as $error)
         toastr.error("{{$error}}").css("width", "100%")
        @endforeach
    </script>

@stop

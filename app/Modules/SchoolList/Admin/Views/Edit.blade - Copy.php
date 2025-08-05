@extends('Master_Admin::MasterPage')
@section('title')
    ویرایش مرکز آموزش
@endsection
@section('CSS')
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('Assets/Admin/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/jquery.scrollbar.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>
        .jconfirm .jconfirm-box div.jconfirm-content-pane .jconfirm-content {
            overflow: hidden !important;
        }
        #postal_code-error {
            /* Firefox */
            width: -moz-calc(100% - 40px);
            /* WebKit */
            width: -webkit-calc(100% - 40px);
            /* Opera */
            width: -o-calc(100% - 40px);
            /* Standard */
            width: calc(100% - 40px);
        }
        #register_type-error {
            position: absolute;
            width: 200px;
            bottom: -30px;
            right: 0;
            color: red;
            font-size: 10px;
            text-align: right;
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
                            <li class="breadcrumb-item "><a>ویرایش مرکز آموزش</a>
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
                          action="{{route('SchoolList.Edit', [$data['id']])}}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ $data['id'] }}" id="schoolId">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="_token">
                        <input type="hidden" value="{{$userId}}" name="user_id" id="user_id">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <div class="form-group">
                                                    <label for="title">عنوان مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="title"
                                                               name="title"
                                                               value="{{$data['title']}}"
                                                               placeholder="عنوان">
                                                        <div class="form-control-position">
                                                            <i class="bx bxs-school"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="float-right" style="position: relative;width: 150px;">
                                                <span style="position: absolute;top: 10px;">آدرس پستی مرکز آموزش</span>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group mb0" style="position: relative">
                                                    <select class="select2 form-control _province" name="province"
                                                            id="province">
                                                        <option value="">انتخاب استان</option>
                                                        @foreach($state as $item)
                                                            <option
                                                                @if($data['province'] == $item->id) selected @endif
                                                            value="{{$item->id}}">{{$item->State_Name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group mb0" style="position: relative">
                                                    <select class="select2 form-control _city" name="city"
                                                            id="city">
                                                        <option value="">انتخاب شهر</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group mb0">
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="address"
                                                               name="address"
                                                               value="{{$data['address']}}"
                                                               placeholder="آدرس">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-id-card"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group mb0">
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control char-textarea"
                                                               id="postal_code"
                                                               name="postal_code"
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               value="{{$data['postal_code']}}"
                                                               placeholder="کد پستی مرکز آموزش">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mail-send"></i>
                                                        </div>
                                                        <small class="counter-value float-right"><span
                                                                class="char-count">0</span> / 10 </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="float-right" style="position: relative;width: 150px;">
                                                <span style="position: absolute;top: 10px;">شماره تلفن مرکز آموزش</span>
                                            </div>
                                            <div class="col-3 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                                                <div class="form-group mb0">
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="phone"
                                                               name="phone"
                                                               value="{{$data['phone']}}"
                                                               placeholder="شماره">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-phone-call"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2 col-sm-3 col-md-2 col-lg-1 col-xl-1">
                                                <div class="form-group mb0">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control pl0 pr0 text-center"
                                                               id="area_code"
                                                               name="area_code"
                                                               value="{{$data['area_code']}}"
                                                               minlength="2" maxlength="5"
                                                               placeholder="پیش شماره">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="float-right" style="position: relative;width: 150px;">
                                                <span
                                                    style="position: absolute;top: 10px;">نوع ثبت نام دانش آموز</span>
                                            </div>
                                            <div style="margin-top: 7px;margin-right: 15px">
                                                <div
                                                    class="custom-control custom-switch custom-switch-status custom-switch-success mr-2 mb-1 text-center">
                                                    <label class="mb-0" for="register_type_1">توسط معاون آموزشگاه</label>
                                                    <input name="register_type" type="radio"
                                                           class="custom-control-input"
                                                           id="register_type_1"
                                                           @if($data['register_type']=="1")
                                                           checked
                                                           @endif
                                                           value="1">
                                                    <label class="custom-control-label" for="register_type_1">
                                                        <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                        <span class="switch-icon-right"><i
                                                                class="bx bx-x"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div style="margin-top: 7px;margin-right: 15px">
                                                <div
                                                    class="custom-control custom-switch custom-switch-status custom-switch-success mr-2 mb-1 text-center">
                                                    <label class="mb-0" for="register_type_2">توسط ولی دانش آموز</label>
                                                    <input name="register_type" type="radio"
                                                           class="custom-control-input"
                                                           id="register_type_2"
                                                           @if($data['register_type']=="2")
                                                           checked
                                                           @endif
                                                           value="2">
                                                    <label class="custom-control-label" for="register_type_2">
                                                        <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                        <span class="switch-icon-right"><i
                                                                class="bx bx-x"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div style="margin-top: 7px;margin-right: 15px">
                                                <div
                                                    class="custom-control custom-switch custom-switch-status custom-switch-success mr-2 mb-1 text-center">
                                                    <label class="mb-0" for="register_type_3">توسط دانش آموز</label>
                                                    <input name="register_type" type="radio"
                                                           class="custom-control-input"
                                                           id="register_type_3"
                                                           @if($data['register_type']=="3")
                                                           checked
                                                           @endif
                                                           value="3">
                                                    <label class="custom-control-label" for="register_type_3">
                                                        <span class="switch-icon-left"><i
                                                                class="bx bx-check"></i></span>
                                                        <span class="switch-icon-right"><i
                                                                class="bx bx-x"></i></span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="grade_id">مقطع تحصیلی</label>
                                                <select
                                                    class="form-control __web-inspector-hide-shortcut__ _grade_id"
                                                    name="grade_id"
                                                    id="grade_id">
                                                    <option value="">انتخاب نشده</option>
                                                    @foreach($grade as $item)
                                                        <option  @if($assignFirst->grade_id == $item->id) selected @endif
                                                            value="{{$item['id']}}">{{$item['title']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-6 col-sm-12 col-md-12 col-lg-6 col-xl-6 float-right"
                                                 style="position: relative">
                                                <div class="lds-ripple-content"
                                                     style="text-align: right;text-indent: 19%;background: #fff;opacity: .6;padding-top: 6%;">
                                                    <div class="lds-ripple">
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-6">
                                                        <div class="form-group">
                                                            <label for="base_id">پایه تحصیلی</label>
                                                            <select
                                                                class="form-control __web-inspector-hide-shortcut__ _base_id"
                                                                name="base_id"
                                                                id="base_id">
                                                                <option value="">انتخاب نشده</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-6">
                                                        <a href="#" class="btn btn-primary mr-1 mb-1 "
                                                           style="margin-top: 27px;" id="assignBtn">اضافه شود</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-12 col-md-12 col-lg-6 col-xl-6"
                                                 style="position: relative">
                                                <div class="lds-ripple-content"
                                                     style="text-align: right;text-indent: 19%;background: #fff;opacity: .6;padding-top: 6%;">
                                                    <div class="lds-ripple">
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                                <div id="assignResult">
                                                    <div class="card">
                                                        <div class="scrollbar-external_wrapper">
                                                            <div class="scrollbar-external"
                                                                 id="scrollbar-externalSchoolAdd">
                                                                <div class="table-">
                                                                    <table class="table table-transparent mb0">
                                                                        <tbody>
                                                                        <tr style="text-align: center;background: #DBE5F4;">
                                                                            <th style="border: none">
                                                                                <div style="padding: 15px;">
                                                                                    <b>پایه های تحصیلی انتخاب شده برای
                                                                                        مرکز آموزش</b></div>
                                                                            </th>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table id="table-extended-chechbox"
                                                                           class="table table-transparent">
                                                                        <thead>
                                                                        <tr>
                                                                            <th style='width: 24px !important;'><i
                                                                                    class='bx bx-x'></i></th>
                                                                            <th>ردیف</th>
                                                                            <th>مقطع تحصیلی</th>
                                                                            <th>پایه تحصیلی</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="table_data">
                                                                       @php($row1 = 0)
                                                                            @foreach($assignSelect as $item)
                                                                                <tr id='tr{{$item->id}}'>
                                                                                    <td>
                                                                                        <fieldset class='fieldset'>
                                                                                            <div class='radio radio-shadow'>
                                                                                                <input type='radio' class='radioshadow radioshadowEdit'
                                                                                                       id='radioshadow{{$item->id}}'
                                                                                                       name='edit'
                                                                                                       rel="{{$baseSelect[$row1]->id}}"
                                                                                                       value='{{$item->id}}'>
                                                                                                <label for='radioshadow{{$item->id}}'></label>
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </td>
                                                                                    <td><input type='hidden' class='grade_base' name='grade_base[]' value='{{$gradeSelect[$row1]->id}}*{{$baseSelect[$row1]->id}}#'> {{$item->id}}</td>
                                                                                    <td> {{$gradeSelect[$row1]->title}}</td>
                                                                                    <td>{{$baseSelect[$row1]->title}}</td>


                                                                                </tr>
                                                                                @php($row1++)
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
                                                        <div id="checkBaseResult"></div>
                                                        <div class="stocks_list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-6 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right">
                                                <h5>دسترسی مدیر مرکز آموزش</h5>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name_principal">نام مدیر مرکز آموزش:</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="name_principal"
                                                               name="name_principal"
                                                               value="{{$principalSelect->name}}"
                                                               placeholder="نام">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="family_principal">نام خانوادگی مدیر مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="family_principal"
                                                               name="family_principal"
                                                               value="{{$principalSelect->family}}"
                                                               placeholder="نام خانوادگی">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-group"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="national_code_principal">نام کاربری (کد ملی) مدیر
                                                        مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="national_code_principal"
                                                               class="form-control char-textarea1"
                                                               name="national_code_principal"
                                                               readonly
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               value="{{$principalSelect->national_code}}"
                                                               placeholder="نام کاربری (کد ملی)">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-id-card"></i>
                                                        </div>
                                                        <small class="counter-value1 float-right"><span
                                                                class="char-count1">0</span> / 10 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password_principal">رمز عبور مدیر مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_principal"
                                                               class="form-control"
                                                               name="password_principal"
                                                               placeholder="رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_principal"
                                                               class="bx bxs-show  toggle-password_principal"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation_principal">تکرار رمز عبور مدیر
                                                        مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_confirmation_principal"
                                                               class="form-control"
                                                               name="password_confirmation_principal"
                                                               placeholder="تکرار رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock-alt"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_confirmation_principal"
                                                               class="bx bxs-show  toggle-re-password_principal"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone_principal">شماره همراه مدیر مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="phone_principal"
                                                               class="form-control char-textarea2"
                                                               name="phone_principal"
                                                               value="{{$principalSelect->phone}}"
                                                               data-length="11"
                                                               minlength="11" maxlength="11"
                                                               placeholder="شماره همراه">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                        <small class="counter-value2 float-right"><span
                                                                class="char-count2">0</span> / 11 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email_principal">ایمیل مدیر مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="email_principal" class="form-control"
                                                               value="{{$principalSelect->email}}"
                                                               name="email_principal" placeholder="ایمیل">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-6 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right">
                                                <h5>دسترسی معاون مرکز آموزش</h5>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name_deputy">نام معاون مرکز آموزش:</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="name_deputy"
                                                               name="name_deputy"
                                                               value="{{$deputySelect->name}}"
                                                               placeholder="نام">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="family_deputy">نام خانوادگی معاون مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="family_deputy"
                                                               name="family_deputy"
                                                               value="{{$deputySelect->family}}"
                                                               placeholder="نام خانوادگی">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-group"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="national_code_deputy">نام کاربری (کد ملی) معاون مرکز آموزش
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="national_code_deputy"
                                                               class="form-control char-textarea3"
                                                               name="national_code_deputy"
                                                               value="{{$deputySelect->national_code}}"
                                                               readonly
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               placeholder="نام کاربری (کد ملی)">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-id-card"></i>
                                                        </div>
                                                        <small class="counter-value3 float-right"><span
                                                                class="char-count3">0</span> / 10 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password_deputy">رمز عبور معاون مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_deputy"
                                                               class="form-control"
                                                               name="password_deputy"
                                                               placeholder="رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_deputy"
                                                               class="bx bxs-show  toggle-password_deputy"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation_deputy">تکرار رمز عبور معاون مرکز آموزش
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_confirmation_deputy"
                                                               class="form-control"
                                                               name="password_confirmation_deputy"
                                                               placeholder="تکرار رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock-alt"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_confirmation_deputy"
                                                               class="bx bxs-show  toggle-re-password_deputy"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone_deputy">شماره همراه معاون مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="phone_deputy"
                                                               class="form-control char-textarea4"
                                                               name="phone_deputy"
                                                               value="{{$deputySelect->phone}}"
                                                               data-length="11"
                                                               minlength="11" maxlength="11"
                                                               placeholder="شماره همراه">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                        <small class="counter-value4 float-right"><span
                                                                class="char-count4">0</span> / 11 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email_deputy">ایمیل معاون مرکز آموزش :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="email_deputy" class="form-control"
                                                               value="{{$deputySelect->email}}"
                                                               name="email_deputy" placeholder="ایمیل">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-6 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right">
                                                <h5>دسترسی معاون اجرائی (ناظم) مرکز آموزش</h5>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name_supervisor">نام معاون اجرائی (ناظم):</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="name_supervisor"
                                                               name="name_supervisor"
                                                               value="{{$supervisorSelect->name}}"
                                                               placeholder="نام">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="family_supervisor">نام خانوادگی معاون اجرائی (ناظم)
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="family_supervisor"
                                                               name="family_supervisor"
                                                               value="{{$supervisorSelect->family}}"
                                                               placeholder="نام خانوادگی">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-group"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="national_code_supervisor">نام کاربری (کد ملی) معاون
                                                        اجرائی (ناظم)
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="national_code_supervisor"
                                                               class="form-control char-textarea5"
                                                               name="national_code_supervisor"
                                                               value="{{$supervisorSelect->national_code}}"
                                                               readonly
                                                               data-length="10"
                                                               minlength="10" maxlength="10"
                                                               placeholder="نام کاربری (کد ملی)">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-id-card"></i>
                                                        </div>
                                                        <small class="counter-value5 float-right"><span
                                                                class="char-count5">0</span> / 10 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password_supervisor">رمز عبور معاون اجرائی (ناظم)
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_supervisor"
                                                               class="form-control"
                                                               name="password_supervisor"
                                                               placeholder="رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_supervisor"
                                                               class="bx bxs-show  toggle-password_supervisor"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation_supervisor">تکرار رمز عبور معاون
                                                        اجرائی (ناظم)
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password_confirmation_supervisor"
                                                               class="form-control"
                                                               name="password_confirmation_supervisor"
                                                               placeholder="تکرار رمز عبور">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-lock-alt"></i>
                                                        </div>
                                                        <div class="eIcov">
                                                            <i toggle="#password_confirmation_supervisor"
                                                               class="bx bxs-show  toggle-re-password_supervisor"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone_supervisor">شماره همراه معاون اجرائی (ناظم)
                                                        :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="phone_supervisor"
                                                               class="form-control char-textarea6"
                                                               name="phone_supervisor"
                                                               value="{{$supervisorSelect->phone}}"
                                                               data-length="11"
                                                               minlength="11" maxlength="11"
                                                               placeholder="شماره همراه">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-mobile"></i>
                                                        </div>
                                                        <small class="counter-value6 float-right"><span
                                                                class="char-count6">0</span> / 11 </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email_supervisor">ایمیل معاون اجرائی (ناظم) :</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="email_supervisor" class="form-control"
                                                               value="{{$supervisorSelect->email}}"
                                                               name="email_supervisor" placeholder="ایمیل">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr style="width: 100%">
                                        </div>
                                    </div>‍
                                </div>
                            </div>
                        </div>
                        <div id="btnVerifyDiv">
                            <a onClick="$(this).closest('#form').submit();"
                               class="btn btn-primary mr-1 mb-1" id="btnVerify">دریافت
                                تاییدیه تلفن همراه</a>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
    <input type="hidden" id="provinceCur" value="{{$data['province']}}">
    <input type="hidden" id="gradeCur" value="{{$assignFirst->grade_id}}">
    <input type="hidden" id="cityCur" value="{{$data['city']}}">

@stop
@section('js')

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('Assets/Admin/js/jquery.scrollbar.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('Assets/Admin/js/scripts/pages/jquery.validate.min.js')}}"></script>

    <script type="text/javascript">

        $(function () {
            $("#postal_code").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#postal_code").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#phone").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#phone").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#area_code").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#area_code").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#national_code_principal").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#national_code_principal").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#phone_principal").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#phone_principal").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#national_code_deputy").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#national_code_deputy").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#phone_deputy").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#phone_deputy").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#national_code_supervisor").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#national_code_supervisor").val(persianToEnglish($(this).val()));
                }
            });
        });
        $(function () {
            $("#phone_supervisor").keyup(function (e) {
                var ctrlKey = 67, vKey = 86;
                if (e.keyCode != ctrlKey && e.keyCode != vKey) {
                    $("#phone_supervisor").val(persianToEnglish($(this).val()));
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
        baseSelect();
        $("#grade_id").change(function () {
            var Grade = $(this).val();
            $("#gradeCur").val(Grade);
            $('#table_data').html("");
            baseSelect();
        });
        function baseSelect() {
            var grade_id = $("#gradeCur").val();
            var _token = $("#_token").val();
            @if($gradeFirst->forced)
                $('#table_data').html("");
            @endif
            $.ajax({
                type: 'POST',
                url: '{{route('School.BaseSelect')}}',
                data: {grade_id: grade_id, _token: _token},
                success: function (baseResult) {
                    $('#base_id').html(baseResult);
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{route('School.ForceAssign')}}',
                data: {grade_id: grade_id, _token: _token},
                success: function (Forcetable_data) {
                    $('#table_data').append(Forcetable_data);
                }
            });
        }
        @if($data['subdomain']==1)
        $("#subdomain_name").show();
        @elseif($data['another_domain']==1)
        $("#another_domain_name").show();
        @endif

        $('#this_domain').change(function () {
            if (this.checked) {
                $('#subdomain').prop('checked', false);
                $('#another_domain').prop('checked', false);
                $("#subdomain_name").val('');
                $("#another_domain_name").val('');
                $("#subdomain_name").fadeOut('slow');
                $("#another_domain_name").fadeOut('slow');
            }
        });


        $('#subdomain').change(function () {
            if (this.checked) {
                $("#subdomain_name").fadeIn('slow');
                $('#this_domain').prop('checked', false);
                $('#another_domain').prop('checked', false);
                $("#another_domain_name").fadeOut('slow');
                $("#another_domain_name").val('');
            } else {
                $("#subdomain_name").fadeOut('slow');
            }
        });


        $('#another_domain').change(function () {
            if (this.checked) {
                $('#this_domain').prop('checked', false);
                $('#subdomain').prop('checked', false);
                $("#subdomain_name").fadeOut('slow');
                $("#another_domain_name").fadeIn('slow');
                $("#subdomain_name").val('');
            } else {
                $("#another_domain_name").fadeOut('slow');
            }
        });
        provinceSelect();
        $("#province").change(function () {
            var prvnc = $(this).val();
            $("#provinceCur").val(prvnc);
            provinceSelect();
        });

        function provinceSelect() {
            var province = $("#provinceCur").val();
            var cityOld = $("#cityCur").val();
            var _token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: '{{route('School.provinceSelect')}}',
                data: {province: province, cityOld: cityOld, _token: _token},
                success: function (cityResult) {
                    $('#city').html(cityResult);
                }
            });
        }

        var counter ={{$item->id}}+1;
        $("#assignBtn").click(function () {
            $(".stocks_list a").remove();
            var grade_id = $("#grade_id").val();
            var base_id = $("#base_id").val();
            var rows = counter++;
            var _token = $("#_token").val();
            var info = 'grade_id=' + grade_id + '&base_id=' + base_id + '&rows=' + rows + '&_token=' + _token;
            if (base_id) {
                $.ajax({
                    type: "POST",
                    url: '{{route('School.assign')}}',
                    data: info,
                    success: function (table_data) {
                        $('#table_data').append(table_data);
                        $(".radioshadow").change(function () {
                            $(".stocks_listEdit a").remove();
                            $(".stocks_list a").remove();
                            var url = this.value;
                            $(".stocks_list a").remove();
                            $(".stocks_listEdit a").remove();
                            $(".stocks_list").append("<a onclick='stocks_list(" + url + ")'>پایه انتخاب شده حذف شود.</a>");
                            $(".stocks_list a").addClass("btn btn-danger mr-1 mb-1 edit-btn stocks_listBtn");
                            $(".stocks_list a").attr("id", url);
                            $(".bx-x").css("display", "block");
                        });
                    }
                });
            } else {
                alert('لطفا پایه تحصیلی را انتخاب نمایید')
            }
            return false
        });
        $(".radioshadowEdit").change(function () {
            $(".stocks_listEdit a").remove();
            $(".stocks_list a").remove();
            var assignId = $(this).val();
            var base_id = $(this).attr('rel');
            var schoolId = $("#schoolId").val();
            var _token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: '{{route('SchoolList.checkBase')}}',
                data: {schoolId: schoolId,base_id: base_id,assignId: assignId, _token: _token},
                success: function (checkBaseResult) {
                    $('#checkBaseResult').html(checkBaseResult);
                }
            });
        });
        $(".bx-x").click(function () {
            $(".radioshadow").prop("checked", false);
            $(".bx-x").css("display", "none");
            $(".stocks_list a").remove();
            $(".stocks_listEdit a").remove();
        });

        function stocks_list(url) {

            swal({
                    title: "آیا از حذف شدن پایه اطمینان دارید؟",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "بله, حذف شود!",
                    cancelButtonText: "خیر, حذف نشود!",
                    cancelButtonClass: "btn-success",
                    showLoaderOnConfirm: false,
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $("#tr" + url + "").remove();
                        swal("", "محتوا شما حذف شد.", "success");
                        $(".stocks_list a").remove();
                        $(".bx-x").css("display", "none");
                    } else {
                        swal("", "محتوا شما در امان است!", "error");
                    }
                });
        }

        $(function () {
            $("form#form").validate({
                rules: {
                    title: {
                        required: true
                    },
                    province: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    postal_code: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    phone: {
                        required: true,
                        number: true
                    },
                    area_code: {
                        required: true,
                        number: true,
                        minlength: 2,
                        maxlength: 5
                    },


                    name_principal: {
                        required: true,
                        minlength: 3
                    },
                    family_principal: {
                        required: true,
                        minlength: 3
                    },
                    email_principal: {
                        required: true,
                        email: true,
                    },
                    phone_principal: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    national_code_principal: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password_principal: {
                        minlength: 5
                    },
                    password_confirmation_principal: {
                        minlength: 5,
                        equalTo: "#password_principal"
                    },


                    name_deputy: {
                        required: true,
                        minlength: 3
                    },
                    family_deputy: {
                        required: true,
                        minlength: 3
                    },
                    email_deputy: {
                        required: true,
                        email: true,
                    },
                    phone_deputy: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    national_code_deputy: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password_deputy: {
                        minlength: 5
                    },
                    password_confirmation_deputy: {
                        minlength: 5,
                        equalTo: "#password_deputy"
                    },

                    name_supervisor: {
                        required: true,
                        minlength: 3
                    },
                    family_supervisor: {
                        required: true,
                        minlength: 3
                    },
                    email_supervisor: {
                        required: true,
                        email: true,
                    },
                    phone_supervisor: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    national_code_supervisor: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password_supervisor: {
                        minlength: 5
                    },
                    password_confirmation_supervisor: {
                        minlength: 5,
                        equalTo: "#password_supervisor"
                    },
                },
                messages: {
                    title: {
                        required: "لطفا عنوان مرکز آموزش را وارد نمایید.",
                    },
                    province: {
                        required: "لطفا استان را انتخاب نمایید.",
                    },
                    city: {
                        required: "لطفا شهر را انتخاب نمایید.",
                    },
                    address: {
                        required: "لطفا آدرس را وارد نمایید.",
                    },
                    postal_code: {
                        required: "لطفا کد پستی مرکز آموزش را وارد نمایید.",
                        number: "کد پستی مرکز آموزش باید عدد باشد.",
                        minlength: "کد پستی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد پستی حداکثر باید ۱۰ کاراکتر باشد.",
                    },
                    phone: {
                        required: "لطفا شماره تلفن مرکز آموزش را وارد نمایید.",
                        number: "شماره تلفن مرکز آموزش باید عدد باشد."
                    },
                    area_code: {
                        required: "لطفا پیش شماره را وارد نمایید.",
                        minlength: "پیش شماره حداقل باید ۲ کاراکتر باشد.",
                        maxlength: "پیش شماره حداکثر باید ۵ کاراکتر باشد.",
                    },


                    name_principal: {
                        required: "لطفا نام مدیر مرکز آموزش را وارد نمایید.",
                        minlength: "نام حداقل باید ۳ حرف باشد."
                    },
                    family_principal: {
                        required: "لطفا نام خانوادگی مدیر مرکز آموزش را وارد نمایید.",
                        minlength: "نام خانوادگی حداقل باید ۳ حرف باشد."
                    },
                    email_principal: {
                        required: "لطفا ایمیل مدیر مرکز آموزش را وارد نمایید.",
                        email: "لطفا یک آدرس ایمیل معتبر وارد کنید"
                    },

                    phone_principal: {
                        required: "لطفا شماره همراه مدیر مرکز آموزش را وارد نمایید.",
                        minlength: "شماره همراه حداقل باید ۱۱ کاراکتر باشد.",
                        maxlength: "شماره همراه حداکثر باید ۱۱ کاراکتر باشد.",
                        number: "شماره همراه باید عدد باشد."
                    },
                    national_code_principal: {
                        required: "لطفا کد ملی مدیر مرکز آموزش را وارد نمایید.",
                        minlength: "کد ملی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد ملی حداکثر باید ۱۰ کاراکتر باشد.",
                        number: "کد ملی باید عدد باشد."
                    },
                    password_principal: {
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation_principal: {
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },


                    name_deputy: {
                        required: "لطفا نام معاون مرکز آموزش را وارد نمایید.",
                        minlength: "نام حداقل باید ۳ حرف باشد."
                    },
                    family_deputy: {
                        required: "لطفا نام خانوادگی معاون مرکز آموزش را وارد نمایید.",
                        minlength: "نام خانوادگی حداقل باید ۳ حرف باشد."
                    },
                    email_deputy: {
                        required: "لطفا ایمیل معاون مرکز آموزش را وارد نمایید.",
                        email: "لطفا یک آدرس ایمیل معتبر وارد کنید"
                    },

                    phone_deputy: {
                        required: "لطفا شماره همراه معاون مرکز آموزش را وارد نمایید.",
                        minlength: "شماره همراه حداقل باید ۱۱ کاراکتر باشد.",
                        maxlength: "شماره همراه حداکثر باید ۱۱ کاراکتر باشد.",
                        number: "شماره همراه باید عدد باشد."
                    },
                    national_code_deputy: {
                        required: "لطفا کد ملی معاون مرکز آموزش را وارد نمایید.",
                        minlength: "کد ملی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد ملی حداکثر باید ۱۰ کاراکتر باشد.",
                        number: "کد ملی باید عدد باشد."
                    },
                    password_deputy: {
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation_deputy: {
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },


                    name_supervisor: {
                        required: "لطفا نام معاون اجرائی (ناظم) را وارد نمایید.",
                        minlength: "نام حداقل باید ۳ حرف باشد."
                    },
                    family_supervisor: {
                        required: "لطفا نام خانوادگی معاون اجرائی (ناظم) را وارد نمایید.",
                        minlength: "نام خانوادگی حداقل باید ۳ حرف باشد."
                    },
                    email_supervisor: {
                        required: "لطفا ایمیل معاون اجرائی (ناظم) را وارد نمایید.",
                        email: "لطفا یک آدرس ایمیل معتبر وارد کنید"
                    },

                    phone_supervisor: {
                        required: "لطفا شماره همراه معاون اجرائی (ناظم) را وارد نمایید.",
                        minlength: "شماره همراه حداقل باید ۱۱ کاراکتر باشد.",
                        maxlength: "شماره همراه حداکثر باید ۱۱ کاراکتر باشد.",
                        number: "شماره همراه باید عدد باشد."
                    },
                    national_code_supervisor: {
                        required: "لطفا کد ملی معاون اجرائی (ناظم) را وارد نمایید.",
                        minlength: "کد ملی حداقل باید ۱۰ کاراکتر باشد.",
                        maxlength: "کد ملی حداکثر باید ۱۰ کاراکتر باشد.",
                        number: "کد ملی باید عدد باشد."
                    },
                    password_supervisor: {
                        minlength: " رمز عبور حداقل باید ۵ کاراکتر باشد."
                    },
                    password_confirmation_supervisor: {
                        minlength: " تکرار رمز عبور حداقل باید ۵ کاراکتر باشد.",
                        equalTo: "تکرار رمز عبور با رمز عبور وارد شده همسان نمی باشد."
                    },
                },
                submitHandler: function (form) {
                    $(document).on("click", "#btnVerify", function () {
                        $("#btnVerify").hide();
                        var schoolId = $("#schoolId").val();
                        var title = $("#title").val();
                        var province = $("#province").val();
                        var city = $("#city").val();
                        var address = $("#address").val();
                        var postal_code = $("#postal_code").val();
                        var area_code = $("#area_code").val();
                        var phone = $("#phone").val();
                        if ($("input#this_domain").is(":checked")) {
                            var this_domain = $("input#this_domain").val();
                        } else {
                            var this_domain = null;
                        }
                        if ($("input#subdomain").is(":checked")) {
                            var subdomain = $("input#subdomain").val();
                        } else {
                            var subdomain = null;
                        }
                        var subdomain_name = $("#subdomain_name").val();
                        if ($("input#another_domain").is(":checked")) {
                            var another_domain = $("input#another_domain").val();
                        } else {
                            var another_domain = null;
                        }
                        var another_domain_name = $("#another_domain_name").val();
                        var name_principal = $("#name_principal").val();
                        var family_principal = $("#family_principal").val();
                        var email_principal = $("#email_principal").val();
                        var phone_principal = $("#phone_principal").val();
                        var national_code_principal = $("#national_code_principal").val();
                        if ($("#password_principal").val()) {
                            var password_principal = $("#password_principal").val();
                        } else {
                            var password_principal = null;
                        }

                        var name_deputy = $("#name_deputy").val();
                        var family_deputy = $("#family_deputy").val();
                        var email_deputy = $("#email_deputy").val();
                        var phone_deputy = $("#phone_deputy").val();
                        var national_code_deputy = $("#national_code_deputy").val();
                        if ($("#password_deputy").val()) {
                            var password_deputy = $("#password_deputy").val();
                        } else {
                            var password_deputy = null;
                        }
                        var name_supervisor = $("#name_supervisor").val();
                        var family_supervisor = $("#family_supervisor").val();
                        var email_supervisor = $("#email_supervisor").val();
                        var phone_supervisor = $("#phone_supervisor").val();
                        var national_code_supervisor = $("#national_code_supervisor").val();
                        if ($("#password_supervisor").val()) {
                            var password_supervisor = $("#password_supervisor").val();
                        } else {
                            var password_supervisor = null;
                        }
                        var grade_base = [];
                        $('input[name="grade_base[]"]').each(function () {
                            grade_base.push(this.value);
                        });
                        var _token = $("#_token").val();
                        $.ajax({
                            type: "post",
                            url: "{{route('SchoolList.sendCode')}}",
                            data: {
                                title: title,
                                province: province,
                                city: city,
                                address: address,
                                postal_code: postal_code,
                                area_code: area_code,
                                phone: phone,
                                this_domain: this_domain,
                                subdomain: subdomain,
                                subdomain_name: subdomain_name,
                                another_domain: another_domain,
                                another_domain_name: another_domain_name,
                                name_principal: name_principal,
                                family_principal: family_principal,
                                email_principal: email_principal,
                                phone_principal: phone_principal,
                                national_code_principal: national_code_principal,
                                password_principal: password_principal,
                                name_deputy: name_deputy,
                                family_deputy: family_deputy,
                                email_deputy: email_deputy,
                                phone_deputy: phone_deputy,
                                national_code_deputy: national_code_deputy,
                                password_deputy: password_deputy,
                                name_supervisor: name_supervisor,
                                family_supervisor: family_supervisor,
                                email_supervisor: email_supervisor,
                                phone_supervisor: phone_supervisor,
                                national_code_supervisor: national_code_supervisor,
                                password_supervisor: password_supervisor,
                                grade_base: grade_base,
                                schoolId: schoolId,
                                _token: _token
                            },
                            success: function (btnVerifyDiv) {
                                if ($.isEmptyObject(btnVerifyDiv.error)) {
                                    Command: toastr["success"]("کد چهار رقمی به شماره همراه شما ارسال گردید.", "");
                                    // $("#btnVerify").attr('disable');
                                    $("#btnVerifyDiv").html("").html(btnVerifyDiv);
                                } else {
                                    // $("#btnVerify").attr('disable');
                                    printErrorMsg(btnVerifyDiv.error);
                                }
                            }
                        });
                        return false;
                    });
                }
            });
        });



        $(document).on("click", "#disabled", function () {
            return false;
        });
        $(document).on("click", "#checkVerify", function () {
            var code = $("#code").val();
            var verify_code = $("#verify_code").val();
            if (code == "") {
                Command: toastr["error"]("لطفا کد ۴ رقمی را وارد نمایید", "");
            } else {
                if (verify_code == code) {
                    var user_idVerify = $("#user_idVerify").val();
                    var titleVerify = $("#titleVerify").val();
                    var provinceVerify = $("#provinceVerify").val();
                    var cityVerify = $("#cityVerify").val();
                    var addressVerify = $("#addressVerify").val();
                    var postal_codeVerify = $("#postal_codeVerify").val();
                    var area_codeVerify = $("#area_codeVerify").val();
                    var phoneVerify = $("#phoneVerify").val();
                    var this_domainVerify = $("#this_domainVerify").val();
                    var subdomainVerify = $("#subdomainVerify").val();
                    var subdomain_nameVerify = $("#subdomain_nameVerify").val();
                    var another_domainVerify = $("#another_domainVerify").val();
                    var another_domain_nameVerify = $("#another_domain_nameVerify").val();
                    var grade_baseVerify = [];
                    $('input[name="grade_baseVerify[]"]').each(function () {
                        grade_baseVerify.push(this.value);
                    });
                    var name_principalVerify = $("#name_principalVerify").val();
                    var family_principalVerify = $("#family_principalVerify").val();
                    var phone_principalVerify = $("#phone_principalVerify").val();
                    var national_code_principalVerify = $("#national_code_principalVerify").val();
                    var password_principalVerify = $("#password_principalVerify").val();
                    var email_principalVerify = $("#email_principalVerify").val();

                    var name_deputyVerify = $("#name_deputyVerify").val();
                    var family_deputyVerify = $("#family_deputyVerify").val();
                    var phone_deputyVerify = $("#phone_deputyVerify").val();
                    var national_code_deputyVerify = $("#national_code_deputyVerify").val();
                    var password_deputyVerify = $("#password_deputyVerify").val();
                    var email_deputyVerify = $("#email_deputyVerify").val();

                    var name_supervisorVerify = $("#name_supervisorVerify").val();
                    var family_supervisorVerify = $("#family_supervisorVerify").val();
                    var phone_supervisorVerify = $("#phone_supervisorVerify").val();
                    var national_code_supervisorVerify = $("#national_code_supervisorVerify").val();
                    var password_supervisorVerify = $("#password_supervisorVerify").val();
                    var email_supervisorVerify = $("#email_supervisorVerify").val();
                    var schoolId = $("#schoolId").val();
                    var _token = $("#_token").val();
                    $.ajax({
                        type: "post",
                        url: "{{route('SchoolList.checkCode')}}",
                        data: {
                            user_idVerify: user_idVerify,
                            titleVerify: titleVerify,
                            provinceVerify: provinceVerify,
                            cityVerify: cityVerify,
                            addressVerify: addressVerify,
                            postal_codeVerify: postal_codeVerify,
                            area_codeVerify: area_codeVerify,
                            phoneVerify: phoneVerify,
                            this_domainVerify: this_domainVerify,
                            subdomainVerify: subdomainVerify,
                            subdomain_nameVerify: subdomain_nameVerify,
                            another_domainVerify: another_domainVerify,
                            another_domain_nameVerify: another_domain_nameVerify,
                            grade_baseVerify: grade_baseVerify,
                            name_principalVerify: name_principalVerify,
                            family_principalVerify: family_principalVerify,
                            phone_principalVerify: phone_principalVerify,
                            national_code_principalVerify: national_code_principalVerify,
                            password_principalVerify: password_principalVerify,
                            email_principalVerify: email_principalVerify,
                            name_deputyVerify: name_deputyVerify,
                            family_deputyVerify: family_deputyVerify,
                            phone_deputyVerify: phone_deputyVerify,
                            national_code_deputyVerify: national_code_deputyVerify,
                            password_deputyVerify: password_deputyVerify,
                            email_deputyVerify: email_deputyVerify,
                            name_supervisorVerify: name_supervisorVerify,
                            family_supervisorVerify: family_supervisorVerify,
                            phone_supervisorVerify: phone_supervisorVerify,
                            national_code_supervisorVerify: national_code_supervisorVerify,
                            password_supervisorVerify: password_supervisorVerify,
                            email_supervisorVerify: email_supervisorVerify,
                            schoolId: schoolId,
                            _token: _token
                        },
                        success: function (checkCode) {
                            Command: toastr["success"]("مرکز آموزش با موفقیت ویرایش گردید.", "");
                            $("#btnVerifyDiv").remove();
                            window.setTimeout(function () {
                                location.reload()
                            }, 3000)
                        }
                    });
                } else {
                    Command: toastr["error"]("کد ۴ رقمی وارد شده اشتباه می باشد", "");
                }
            }
            return false;
        });

        function printErrorMsg(msg2) {
            $.each(msg2, function (key2, value2) {
                Command: toastr["error"](value2);
            });
        }

        $(".toggle-password_principal").show();
        $(".toggle-password_principal").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password_deputy").show();
        $(".toggle-password_deputy").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password_supervisor").show();
        $(".toggle-password_supervisor").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-re-password_principal").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-re-password_deputy").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-re-password_supervisor").click(function () {
            $(this).toggleClass("bxs-show bxs-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
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


        $(".scrollbar-external").scrollbar({
            "autoScrollSize": false,
            "scrollx": $(".external-scroll_x"),
            "scrolly": $(".external-scroll_y")
        });

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
        var tablecheckbox = $("#table-extended-chechbox").DataTable({
            "searching": false,
            "lengthChange": false,
            "paging": false,
            "bInfo": false,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 1, 2, 3, 4]
            }, //to disable sortying in col 0,3 & 4

            ],
            "select": "multi",
            "order": [
                [0, "desc"]
            ]
        });
    </script>

    <script src="{{asset('Assets/Admin/js/scripts/pages/table-extended.js')}}"></script>
    <script src="{{asset('Assets/Admin/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('Assets/Admin/js/scripts/forms/select/form-select2.js')}}"></script>
@stop


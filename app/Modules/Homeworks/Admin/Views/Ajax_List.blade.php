<div class="card">
    <div class="scrollbar-external_wrapper">
        <div class="scrollbar-external">
            <div class="table-">
                @if($data['app'] == null)
                    <div class="text-center">
                        <img src="{{asset('Assets/Admin/images/noResult3.png')}}"
                             style="width: 200px;margin: 0 auto" alt="">
                        <p class="pt10">
                            لطفا پایه ، کلاس و درس مورد نظر را انتخاب نمایید.
                        </p>
                    </div>
                @else
                    @if(!$data['app']->isEmpty())
                        <table class="table table-transparent mb0">
                            <tbody>
                            <tr style="text-align: center;background: #DBE5F4;">
                                <th style="border: none"><div style="padding: 15px;"><b>فهرست تکالیف </b></div></th>
                            </tr>
                            </tbody>
                        </table>
                        <table id="table-extended-chechbox" class="table table-transparent">
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>دانش آموز</th>
                                <th>عنوان</th>
                                <th>درس</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                                <th>مشاهده</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['app'] as $item)
                                <tr class="text-center" id="tr_{{$item['id']}}">
                                    <td class="text-bold-500">{{$item['id']}}</td>
                                    <td>
                                        @if($item->student)
                                            {{$item->student->name}} {{$item->student->family}}
                                        @endif
                                    </td>
                                    <td>{{$item['title']}}</td>
                                    <td>
                                        @if($item->lesson)
                                            {{$item->lesson->title}}
                                        @endif
                                    </td>
                                    <td>
                                        {{\Morilog\Jalali\Jalalian::forge($item['date'])->format('%d %B %Y')}}
                                    </td>
                                    <td>
                                        @if($item['status'] == '0')
                                            <b style="color: #5A8DEE">بررسی نشده</b>
                                        @elseif($item['status'] == '1')
                                            <b style="color: #39DA8A">کامل</b>
                                        @elseif($item['status'] == '2')
                                            <b style="color: #FDAC41">ناقص</b>
                                        @elseif($item['status'] == '3')
                                            <b style="color: #FF5B5C">مورد تایید نیست</b>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('Homeworks.Edit.View',$item['id'])}}" class="btn btn-icon btn-light-secondary"><i class="bx bx-archive"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
<script>
    $("input[type=radio][name=edit]").change(function () {
        var url = "'.route("ClassAssign.Edit", ":id").'";
        url = url.replace(":id", this.value);
        $(".stocks_list a").remove();
        $(".stocks_list").append("<a>ویرایش</a></li>");
        $(".stocks_list a").addClass("btn btn-primary mr-1 mb-1 edit-btn float_right");
        $(".stocks_list a").attr("href" , url);
    });
    $(".radioshadow").click(function () {
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".bx-x").not(targetBox).css("display", "block");
        $(".edit-btn").not(targetBox).css("display", "block");
        $(targetBox).hide();
    });
    $(".bx-x").click(function () {
        $(".radioshadow").prop("checked", false);
        $(".bx-x").css("display", "none");
        $(".stocks_list a").remove();
    });

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
        "searching": true,
        "lengthChange": true,
        "paging": false,
        "bInfo": false,
        "columnDefs": [{
            "orderable": false,
            "targets": [0,2]
        }, //to disable sortying in col 0,3 & 4
        ],
        "select": "multi",
        "order": [
            [1, "desc"]
        ]
    });
</script>

@if(!$data['app']->isEmpty())
    <div class="card">
        <div class="scrollbar-external_wrapper">
            <div class="scrollbar-external">
                <div class="table-">
                    <div class="table-responsive">
                        <table class="table table-transparent mb0">
                            <tbody>
                            <tr style="text-align: center;background: #DBE5F4;">
                                <th style="border: none"><div style="padding: 15px;"><b>فهرست مراکز آموزش موجود</b></div></th>
                            </tr>
                            </tbody>
                        </table>
                        <table id="table-extended-chechbox" class="table table-transparent">
                            <thead>
                            <tr>
                                <th style="width: 24px !important;"><i class="bx bx-x" style=""></i></th>
                                <th>شماره</th>
                                <th>عنوان</th>
                                @if($userCategorySelect->id == '1')
                                    <th>کاربر ایجاد کننده</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php($row=0)
                            @foreach($data['app'] as $item)
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
                                    @if($userCategorySelect->id == '1')
                                        <td>
                                            @if($item->user_id)
                                                {{$item->userSelect->name}} {{$item->userSelect->family}}
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                @php($row++)
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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


        <script>
            $(document).ready(function () {
                $('input[type=radio][name=edit]').change(function () {
                    var url = '{{ route("SchoolList.Edit", ":id") }}';
                    url = url.replace(':id', this.value);
                    $(".stocks_list a").remove();
                    $('.stocks_list').append('<a class="btn btn-primary mr-1 mb-1 edit-btn" style="float:none;display: block;" href="' + url + '">مشاهده و اصلاح </a></li>');
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
                "searching": false,
                "lengthChange": true,
                "paging": false,
                "bInfo": false,
                'columnDefs': [{
                    "orderable": false,
                    "targets": [0]
                }, //to disable sortying in col 0,3 & 4
                ],
                'select': 'multi',
                'order': [
                    [1, 'asc']
                ]
            });
        </script>
    </div>
    <div class="stocks_list text-center"></div>
@else
    <div class="text-center">
        <img src="{{asset('Assets/Admin/images/noResult3.png')}}" style="width: 200px;margin: 0 auto" alt="">
        <p class="pt10">
            آیتمی جهت نمایش وجود ندارد!
        </p>
    </div>
@endif



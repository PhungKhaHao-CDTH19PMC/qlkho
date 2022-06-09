@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
            <div class="ms-auto">
                <div class="row mb-3">
                <div class="col-sm-12 col-md-3">
                    <label class="form-label" for="mo-ta">Họ và tên</label>
                    <select multiple="multiple" class="form-control" id="fullname" name="fullname" >
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="form-label" for="mo-ta">Tháng </label>
                    <select multiple="multiple" class="form-control" id="monthPaySalary" name="monthPaySalary" >
                        @foreach($dateTimesheets as $dateTimesheet)
                        <option value="{{ $dateTimesheet['substring(in_hour,4,7)']}}">{{ $dateTimesheet['substring(in_hour,4,7)'] }}</option>
                        @endforeach
                    </select>
                </div>
              
                <div class="col-sm-12 col-md-9 mt-4">
                    <div class="d-lg-flex justify-content-end">
                        <a href="{{ route('Timesheet.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
                            <i class="bx bxs-plus-square"></i>Thêm mới
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="mb-3">
                    <select id="select-chon-hang-loat" class="form-select">
                        <option value=""></option>
                        <option value="delete"> Xoá</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <button id="btn-ap-dung" class="btn btn-outline-primary form-control " type="button" disabled>Áp dụng</button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="user" class="table table-striped table-bordered table-custom-text">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Họ và tên</th>
                        <th>Chức danh</th>
                        @for($i=1; $i <= $endate; $i++)
                        <th  style="width: 5%">{{$i}}</th>
                        @endfor
                        <th>Tổng cộng</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $key=>$user)
                <?php
                    $Timesheet_reals = App\Models\Timesheet::where('user_id', $user->id)->get();
                ?>
                <tr>
                        <th>{{$key+1}}</th>
                        <th>{{$user->fullname}}</th>
                        <th>Chức danh</th>
                        <?php
                            $tong = 0 ;
                        ?>                       
                        @for($i=1; $i <= $endate; $i++)
                            <?php
                                $check = 0;
                            ?>
                            @foreach($Timesheet_reals as $Timesheet_real)
                                @if((int)Carbon\Carbon::parse($Timesheet_real->in_hour)->format('d') == $i)
                                    <?php
                                        if(Carbon\Carbon::parse($Timesheet_real->in_hour)->diffInHours(Carbon\Carbon::parse($Timesheet_real->out_hour)) > 4)
                                        {
                                            $check = 1;
                                            $tong+=1;
                                        }
                                        else{
                                            $check = 1/2;
                                            $tong+=1/2;
                                        }
                                    ?>
                                @endif
                            @endforeach

                            @if($check)
                                <th>{{$check}}</th>
                            @else
                                <th></th>
                            @endif
                        @endfor

                        <th>{{$tong}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('page-css')
@endsection

@section('page-js')
<script type="text/javascript">
    $("#fullname").multipleSelect({
        placeholder: "Chọn tên nhân viên",
        filter: true,
        showClear: true,
        //placeholder: 'Chọn mã hợp đồng',
        position: 'bottom',
        minimumCountSelected: 1,
        filterPlaceholder: 'Tìm kiếm',
        openOnHover: false,
        formatSelectAll () {
            return 'Chọn tất cả'
        },
        formatAllSelected () {
            return 'Đã chọn tất cả'
        },
        formatCountSelected (count, total) {
            return 'Đã chọn ' + count + ' trên ' + total
        },
        formatNoMatchesFound () {
            return 'Không tìm thấy kết quả'
        },
        onClose: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            table.columns(2).search(filterFullname).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },

        onClear: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            table.columns(2).search(filterFullname).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        }
    });
   
    // $("#select-chon-hang-loat").select2({
    //    placeholder: "Chọn thao tác",
    //    allowClear: true,
    //    minimumResultsForSearch: -1
    // });
</script>
<script type="text/javascript">
    $("#monthPaySalary").multipleSelect({
        placeholder: "Chọn tháng",
        filter: true,
        showClear: true,
        //placeholder: 'Chọn mã hợp đồng',
        position: 'bottom',
        minimumCountSelected: 1,
        filterPlaceholder: 'Tìm kiếm',
        openOnHover: false,
        formatSelectAll () {
            return 'Chọn tất cả'
        },
        formatAllSelected () {
            return 'Đã chọn tất cả'
        },
        formatCountSelected (count, total) {
            return 'Đã chọn ' + count + ' trên ' + total
        },
        formatNoMatchesFound () {
            return 'Không tìm thấy kết quả'
        },
        onClose: function () {
            var filterFullname = JSON.stringify($("#monthPaySalary").val())
            table.columns(2).search(filterFullname).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },

        onClear: function () {
            var filterFullname = JSON.stringify($("#monthPaySalary").val())
            table.columns(2).search(filterFullname).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        }
    });
   
    $("#select-chon-hang-loat").select2({
       placeholder: "Chọn thao tác",
       allowClear: true,
       minimumResultsForSearch: -1
    });
</script>

{{-- Load danh sách --}}
<!-- <script>
    var table;
        resetTable()
        function resetTable () {
            table = $('#user').DataTable({
                processing  : true,
                serverSide  : true,
                autoWidth   : false,
                pageLength  : 10,
                language: {
                    emptyTable: "Không tồn tại dữ liệu",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    info: "Hiển thị từ _START_ đến _END_ trong _TOTAL_ mục",
                    infoEmpty: "0 bảng ghi được hiển thị",
                    infoFiltered: "",
                    select:{
                        rows:"",
                    },
                    lengthMenu: "Hiển thị _MENU_ mục",
                    processing: "<span class='text-primary'>Đang tải dữ liệu...</span>",
                    oPaginate: {
                       sNext: '<i class="fa-solid fa-angle-right"></i>',
                       sPrevious: '<i class="fa-solid fa-angle-left"></i>',
                       sFirst: '<i class="fa fa-step-backward"></i>',
                       sLast: '<i class="fa fa-step-forward"></i>'
                    }
                },
                ajax: {
                    url: "{{route('Timesheet.load_ajax_list_Timesheet')}}",
                    type: 'get'
                },
                select: {
                    style:    'multi',
                    selector: 'td:first-child'
                },
                initComplete: function(settings, json) {
                    table.on( 'click', 'tbody tr', function () {
                        $(this).toggleClass('selected');
                        if (table.rows('.selected').data().length == 0) {
                            $("#btn-ap-dung").attr('disabled', true)
                        }
                        else {
                            $("#btn-ap-dung").attr('disabled', false)
                        }
                        if ($("th.select-checkbox").hasClass("selected")) {
                            $("th.select-checkbox").removeClass("selected");
                        }
                        if(json.aaData.length == table.rows('.selected').data().length ) {
                            $("th.select-checkbox").addClass("selected");
                        }
                    });

                    table.on("click", "th.select-checkbox", function() {
                        if ($("th.select-checkbox").hasClass("selected")) {
                            $("tbody tr").removeClass('selected');
                            $("th.select-checkbox").removeClass("selected");
                        } else {
                            $("tbody tr").addClass('selected');
                            $("th.select-checkbox").addClass("selected");
                        }
                        if (table.rows('.selected').data().length == 0) {
                            $("#btn-ap-dung").attr('disabled', true)
                        }
                        else {
                            $("#btn-ap-dung").attr('disabled', false)
                        }
                    })

                    $("#user").parent().addClass(' table-responsive');
                    $("#user").parent().parent().addClass(' d-inline');

                },
                drawCallback: function(oSettings) {
                    if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
                        $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                    } else {
                         $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
                    }

                    if (oSettings.fnRecordsDisplay() == 0) {
                       $(oSettings.nTableWrapper).find('.dataTables_info').hide();
                    }
                },
                columns: [
                    { data: null, defaultContent: '', bSortable: false },
                    { name: 'id', defaultContent: '',data: 'id',visible: false,bSortable: true},
                    { name: 'user_id', defaultContent: '',data: 'user.fullname',bSortable: true},
                    { name: 'salary_name', defaultContent: '',data: 'salarys.name',bSortable: true},
                    { name: 'salary_name', defaultContent: '',data: 'salarys.name',bSortable: true},
                   
                ],
                columnDefs: [
                    {
                        targets:   0,
                        orderable: false,
                        className: 'select-checkbox'
                    },
                    {
                        
                        // targets:$endate+4,
                        // render: function(data,type, columns){
                        //     var urlRenewal = "./bang-luong/cap-nhat/"+ columns.id;
                        //     return '<div class="d-flex order-actions">'
                        //         +'<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="'+ urlRenewal +'" class="btn-edit"><i class="bx bxs-edit"></i></a>'
                        //         +'<a data-toggle="tooltip" data-placement="right" title="Xoá" onclick="deleteRow(this)" data-id="'+columns.id+'" href="javascript:;" class="text-danger ms-3 btn-del"><i class="bx bxs-trash"></i></a>'
                        //         +'</div>'
                        // }
                    },

                ],
                ordering: true,
                order: [[ 1, 'asc' ]],
            });
        }

</script> -->

@endsection

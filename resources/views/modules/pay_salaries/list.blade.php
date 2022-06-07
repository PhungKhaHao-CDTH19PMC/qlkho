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
                        @foreach($monthPaySalarys as $monthPaySalary)
                        <option value="{{ $monthPaySalary['substring(month,4,7)']}}">{{ $monthPaySalary['substring(month,4,7)'] }}</option>
                        @endforeach
                    </select>
                </div>
              
                <div class="col-sm-12 col-md-9 mt-4">
                    <div class="d-lg-flex justify-content-end">
                        <a href="{{ route('pay_salaries.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
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
                        <th style="width: 5%"></th>
                        <th>ID</th>
                        <th>Họ và tên</th>
                        <th>Chức danh</th>
                        <th>Mức lương cơ bản</th>
                        <th>Ngày công </th>
                        <th>Lương</th>
                        <th>Phụ cấp</th>
                        <th>Tổng cộng</th>
                        <th>Tạm ứng</th>
                        <th>Lương thực nhận</th>
                        <th>Trạng thái</th>
                        <th>Ngày tính</th>
                        <th></th>
                    </tr>
                </thead>
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
   
    $("#select-chon-hang-loat").select2({
       placeholder: "Chọn thao tác",
       allowClear: true,
       minimumResultsForSearch: -1
    });
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
<script>
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
                    url: "{{route('pay_salaries.load_ajax_list_pay_salaries')}}",
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
                    { name: 'salary.salary_payable', defaultContent: '',data: 'salarys.salary_payable',bSortable: true},
                    { name: 'working_day', defaultContent: '',data: 'working_day',bSortable: true},
                    { name: 'salary', defaultContent: '',data: 'salary',bSortable: true},
                    { name: 'allowance', defaultContent: '',data: 'allowance',bSortable: true},
                    { name: 'total', defaultContent: '',data: 'total',bSortable: true},
                    { name: 'advance', defaultContent: '',data: 'advance',bSortable: true},
                    { name: 'actual_salary', defaultContent: '',data: 'actual_salary',bSortable: true},
                    { name: 'status', defaultContent: '',data: 'status',bSortable: true},
                    { name: 'month', defaultContent: '',data: 'month',bSortable: true},
                ],
                columnDefs: [
                    {
                        targets:   0,
                        orderable: false,
                        className: 'select-checkbox'
                    },
                    {
                        targets:13,
                        render: function(data,type, columns){
                            var urlRenewal = "./bang-luong/cap-nhat/"+ columns.id;
                            return '<div class="d-flex order-actions">'
                                +'<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="'+ urlRenewal +'" class="btn-edit"><i class="bx bxs-edit"></i></a>'
                                +'<a data-toggle="tooltip" data-placement="right" title="Xoá" onclick="deleteRow(this)" data-id="'+columns.id+'" href="javascript:;" class="text-danger ms-3 btn-del"><i class="bx bxs-trash"></i></a>'
                                +'</div>'
                        }
                    },

                ],
                ordering: true,
                order: [[ 1, 'asc' ]],

            });
        }

</script>
{{-- Delete --}}
<script type="text/javascript">
    function deleteRow(a) {
        var id = $(a).data("id");
        Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            confirmButtonText: 'Xóa'
        }).then((result) => {
            if (result.value) {

                        $.ajax({
                                    url: "{{route('pay_salaries.destroy')}}",
                                    type: 'post',
                                    data: {id:id},
                        }).done(function(res) {
                            if (res.status == 'success') {
                                swal.fire({
                                    title: res.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    padding: '2em',
                                    timer: 1500,
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    title: res.message,
                                    icon: 'error',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    padding: '2em',
                                    timer: 1500,
                                })
                            }
                        });
                    }
                })
    }
</script>
{{-- Xóa hàng loạt --}}
<script>
    $('#btn-ap-dung').click( function () {
            if($("#select-chon-hang-loat").val() == "") {
                 Swal.fire({
                    title: 'Bạn chưa chọn thao tác',
                    icon: 'error',
                    padding: '2em',
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                var data = table.rows('.selected').data();
                var formData = new FormData();
                data.map(function(item){ formData.append('id[]', item.id)});
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    confirmButtonText: 'Xóa'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                                    url: "{{route('pay_salaries.destroy')}}",
                                    type: 'post',
                                    data: formData,
                                    cache:false,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                        }).done(function(res) {
                            if (res.status == 'success') {
                                swal.fire({
                                    title: res.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    padding: '2em',
                                    timer: 1500,
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    title: res.message,
                                    icon: 'error',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    position: 'center',
                                    padding: '2em',
                                    timer: 1500,
                                })
                            }
                        });
                    }
                })
            }
        });
</script>
@endsection

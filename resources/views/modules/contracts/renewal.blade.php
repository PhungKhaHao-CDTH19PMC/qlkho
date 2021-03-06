@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
        <div class="col-sm-12 col-md-12 mt-4">
            <div class="d-lg-flex justify-content-end">
                <a href="{{ route('contracts.renewal_create',['contract_id' => $id])}}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
                    <i class="bx bxs-plus-square"></i>Thêm mới
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table id="user" class="table table-striped table-bordered table-custom-text">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%"></th>
                        <th>ID</th>
                        <th>Mã hợp đồng</th>
                        <th>Họ tên nhân viên</th>
                        <th>Gia hạn từ</th>
                        <th>Gia hạn đến</th>
                        <th>Hệ số lương</th>
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
                    url: "{{route('contracts.load_ajax_list_renewal')}}",
                    data: {contract_id: "{{$id}}"},
                    type: "get"
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
                    { name: 'code', defaultContent: '',data: 'contract.code',bSortable: true},
                    { name: 'user_id', defaultContent: '',data: 'user.fullname',bSortable: true},
                    { name: 'renewal_date_start', defaultContent: '',data: 'renewal_date_start',bSortable: true},
                    { name: 'renewal_date_finish', defaultContent: '',data: 'renewal_date_finish',bSortable: true},
                    { name: 'salary_factor', defaultContent: '',data: 'salary_factor',bSortable: true},
                ],
                columnDefs: [
                    {
                        targets:   0,
                        orderable: false,
                        className: 'select-checkbox'
                    },
                    {
                        targets:7,
                        render: function(data,type, columns){
                            var urlUpdate = "cap-nhat/"+ columns.id;
                            return '<div class="d-flex order-actions">'
                                +'<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="'+ urlUpdate +'" class="btn-edit ms-3 "><i class="bx bxs-edit"></i></a>'
                                +'<a data-toggle="tooltip" data-placement="right" title="Xoá" onclick="deleteRow(this)" data-id="'+columns.id+'" href="javascript:;" class="text-danger ms-3 btn-del"><i class="bx bxs-trash"></i></a>'
                                +'</div>'
                                ;
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
                            url: "{{route('contracts.renewal_destroy')}}",
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
                                    url: "{{route('contracts.destroy')}}",
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
<script type="text/javascript">
     function onGetPayEdit(contract_id, id) {
        $('#form-edit-renewal-'+ id).submit();
     }
</script>
@endsection

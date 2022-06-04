@extends('master')
@section('page-content')
@include('inc.sweetalert')

<div class="card">
    <div class="card-body">
            <div class="ms-auto">
                <div class="row mb-3">
                <div class="col-sm-12 col-md-3">
                    <label class="form-label" for="mo-ta">Tên nhân viên</label>
                    <select multiple="multiple" class="form-control" id="fullname" name="fullname" >
                        @foreach($user_fullname as $fullname)
                        <option value="{{ $fullname }}">{{ $fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="form-label" for="mo-ta">Số điện thoại</label>
                    <select multiple="multiple" class="form-control" id="phone" name="phone" >
                        @foreach($user_phone as $phone)
                        <option value="{{ $phone }}">{{ $phone }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="form-label" for="mo-ta">Chức vụ</label>
                    <select multiple="multiple" class="form-control" id="role_id" name="role_id" >
                        @foreach($role as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-3 mt-4">
                    <div class="d-lg-flex justify-content-end">
                        <a href="{{ route('user.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
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
                        <th>Mã nhân viên</th>
                        <th>Họ tên</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Chức vụ</th>
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
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }
            });
        },
        onClear: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }
            });
        }
    });
    $("#phone").multipleSelect({
        placeholder: "Chọn số điện thoại",
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
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
        },
        onClear: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['role_id'].length>0)
                {
                    $("#role_id option").remove();
                    $('#role_id').multipleSelect("refresh");
                    res['role_id'].forEach(element => {
                        $('#role_id').append($('<option>', {
                            value: element["id"],
                            text: element["name"]
                        }));
                    });
                    $('#role_id').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
        }
    });
    $("#role_id").multipleSelect({
        placeholder: "Chọn chức vụ",
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
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
        },
        onClear: function () {
            var filterFullname = JSON.stringify($("#fullname").val())
            var filterPhone = JSON.stringify($("#phone").val())
            var filterRole = JSON.stringify($("#role_id").val())
            table.columns(3).search(filterFullname).draw();
            table.columns(5).search(filterPhone).draw();
            table.columns(6).search(filterRole).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");

            $.ajax({
                url: "{{route('user.load_filter_user')}}",
                type: 'get',
                data: {
                    fullname: filterFullname,
                    phone: filterPhone,
                    role_id: filterRole
                },
                dataType: 'json',
            }).done(function(res) {
                if(res['phone'].length>0)
                {
                    $("#phone option").remove();
                    $('#phone').multipleSelect("refresh");
                    res['phone'].forEach(element => {
                        $('#phone').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#phone').multipleSelect("refresh");
                }

                if(res['fullname'].length>0)
                {
                    $("#fullname option").remove();
                    $('#fullname').multipleSelect("refresh");
                    res['fullname'].forEach(element => {
                        $('#fullname').append($('<option>', {
                            value: element,
                            text: element
                        }));
                    });
                    $('#fullname').multipleSelect("refresh");
                }
            });
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
                    url: "{{route('user.load_ajax_list_user')}}",
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
                    { name: 'code', defaultContent: '',data: 'code',bSortable: true},
                    { name: 'fullname', defaultContent: '',data: 'fullname',bSortable: true},
                    { name: 'address', defaultContent: '',data: 'address',bSortable: true},
                    { name: 'phone', defaultContent: '',data: 'phone',bSortable: true},
                    { name: 'role_id', defaultContent: '',data: 'role.name',bSortable: true},
                ],
                columnDefs: [

                    {
                        targets:   0,
                        orderable: false,
                        className: 'select-checkbox'
                    },
                    {
                        targets: 7,
                        render: function(data,type, columns){
                             var url = "./nguoi-dung/cap-nhat/"+ columns.id;
                            return '<div class="d-flex order-actions">'
                                +'<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="'+ url +'" class="btn-edit"><i class="bx bxs-edit"></i></a>'
                                +'<a data-toggle="tooltip" data-placement="right" title="Xoá" onclick="deleteRow(this)" data-id="'+columns.id+'" href="javascript:;" class="text-danger ms-3 btn-del"><i class="bx bxs-trash"></i></a>'
                                +'</div>'
                        }
                    },

                ],
                ordering: true,
                order: [[ 2, 'asc' ]],

            });
        }

</script>
{{-- Delete --}}
<script type="text/javascript">
    function deleteRow(a) {
        var id = $(a).data("id");
        console.log(id);
        $.ajax({
            url:"{{route('checkRole')}}",
            type:'GET',

        }).done(function (result)
        {
            if(result)
            {
            Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            confirmButtonText: 'Xóa'
              }).then((result) => {
            if (result.value) {
                    $.ajax({
                                url: "{{route('user.destroy')}}",
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
            else{
                swal.fire({
                title:  "Bạn không được sử dụng quyền này!",
                icon:"error",
                type: 'error',
                padding: '2em',
                showConfirmButton: false,
                timer: 1500,
                 })
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
                ///
                $.ajax({
            url:"{{route('checkRole')}}",
            type:'GET',

        }).done(function (result)
        {
            if(result)
            {
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    confirmButtonText: 'Xóa'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                                    url: "{{route('user.destroy')}}",
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
                })//////
            }
            else{
                swal.fire({
                title:  "Bạn không được sử dụng quyền này!",
                icon:"error",
                type: 'error',
                padding: '2em',
                showConfirmButton: false,
                timer: 1500,
                 })
            }
          
        })
            }
        });
</script>
@endsection

@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
            <div class="ms-auto">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-3">
                        <label class="form-label" for="mo-ta">Tên phòng ban</label>
                        <select multiple="multiple" class="form-control" id="name" name="name" >
                            @foreach($department as $dep)
                            <option value="{{ $dep->name }}">{{ $dep->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-9 mt-4">
                    <div class="d-lg-flex justify-content-end">
                    <button type="button" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1">
                        <i class="bx bxs-plus-square"></i>Thêm mới
                    </button>
                    </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                    <select id="select-chon-hang-loat" class="form-select">
                        <option value=""></option>
                        <option value="delete"> Xoá</option>
                    </select>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <button id="btn-ap-dung" class="btn btn-outline-primary form-control " type="button" disabled>Áp dụng</button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="department" class="table table-striped table-bordered table-custom-text">
                <thead class="table-light">
                    <tr department="row">
                        <th style="width: 5%"></th>
                        <th>Tên phòng ban</th>
                        <th style="width: 20%"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


@include('modules.department.create-modal')
@include('modules.department.update-modal')


@endsection

@section('page-css')
@endsection

@section('page-js')
<script type="text/javascript">
    $("#name").multipleSelect({
        placeholder: "Chọn phòng ban",
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
            var filterName = JSON.stringify($("#name").val())
            table.columns(1).search(filterName).draw();
            $("#btn-ap-dung").attr('disabled', true);
            $("th.select-checkbox").removeClass("selected");
        },
        onClear: function () {
            var filterName = JSON.stringify($("#name").val())
            table.columns(1).search(filterName).draw();
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
{{-- Load --}}
<script>
    var table;
    resetTable()
    function resetTable () {
        table = $('#department').DataTable({
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
                url: "{{route('department.load_ajax_list_department')}}",
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

                $("#department").parent().addClass(' table-responsive');
                $("#department").parent().parent().addClass(' d-inline');

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
                { name: 'name',defaultContent: '', data: 'name',bSortable: true},
            ],
            columnDefs: [

                {
                    targets:   0,
                    orderable: false,
                    className: 'select-checkbox'
                },
                {
                    targets: 2,
                    render: function(data,type, columns){
                        if(columns.name == "Super Admin")
                        {
                            return '<div class="d-flex order-actions">'
                            +'<a data-toggle="tooltip" data-placement="right" title="Cập nhật" href="javascript:;" class="btn-edit"><i class="bx bxs-edit"></i></a>'
                            +'<a data-toggle="tooltip" data-placement="right" title="Xoá"  href="javascript:;" class="text-danger ms-3 btn-del"><i class="bx bxs-trash"></i></a>'
                            +'</div>'
                        }
                        else
                        {
                            return '<div class="d-flex order-actions">'
                            +'<a data-toggle="tooltip" data-placement="right" title="Cập nhật"  onclick="updateRow(this)" data-target="#update-modal" data-toggle="modal" data-id="'+columns.id+'" data-name="'+columns.name+'"  href="javascript:;" class="btn-edit"><i class="bx bxs-edit"></i></a>'
                            +'<a data-toggle="tooltip" data-placement="right" title="Xoá" onclick="deleteRow(this)" data-id="'+columns.id+'" href="javascript:;" class="text-danger ms-3 btn-del"><i class="bx bxs-trash"></i></a>'
                            +'</div>'
                        }
                    }
                },
            ],
            // ordering: true,
            order: [[1, 'asc' ]],

        });
    };

</script>
{{-- Xóa tìm kiếm mặc định --}}
<script>
    const box = document.getElementById('department_filter');
    box.remove();
</script>
{{-- Thêm-Sửa --}}
<script type="text/javascript">
    $(document).ready(function() {
        @include('inc.notify')

        var modal = $("#create-modal");

        $('#btn-them-moi').click(function() {
            modal.modal('show')
        });

        // Modal shown
        modal.on('shown.bs.modal', function() {
            document.getElementById("name").focus();
            document.getElementById("name").value = "";

        });

        // Modal hidden
        modal.on('hidden.bs.modal', function() {
            $('#frm-them-moi').parsley().reset();

        });

        $('#btn-save-modal').click(function() {
            if($('#frm-them-moi').parsley().validate()) {
               $.ajax({
                    url: "{{ route('department.store') }}",
                    type: 'POST',
                    data: $('form.create_form').serialize(),
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
                            icon: res.status,
                            showCancelButton: false,
                            showConfirmButton: false,
                            position: 'center',
                            padding: '2em',
                            timer: 1500,
                        })
                    }
                });
            }
        });
        $('#btn-update-modal').click(function(e) {
            if($('#frm-cap-nhat').parsley().validate()) {
                $.ajax({
                    url: "{{ route('department.update') }}",
                    type: 'POST',
                    data: $('form.update_form').serialize(),
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
                            icon: res.status,
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
    });
</script>
{{-- Load modal --}}
<script type="text/javascript">
    function updateRow(a) {
        var id = $(a).data("id");
        var name = $(a).data("name");
        var modal = $("#update-modal");
        modal.modal('show')
        modal.on('shown.bs.modal', function(e) {
             $(e.currentTarget).find('input[name="id"]').val(id);
             $(e.currentTarget).find('input[name="name"]').val(name);

        });
        modal.on('hidden.bs.modal', function() {
            $('#frm-cap-nhat').parsley().reset();

        });
    };
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
                    url: "{{route('department.destroy')}}",
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
{{-- Xóa hàng hoạt --}}
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
                                    url: "{{route('department.destroy')}}",
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

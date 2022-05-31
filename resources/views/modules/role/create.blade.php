@extends('master')
@section('page-content')
    <style>


    </style>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-3" style="margin-bottom:1%">
                                <label class="form-label" for="ten">Tên phân quyền<span class="required">
                                        *</span></label>
                            </div>
                            <div class="col-sm-9" style="margin-bottom:1%">

                                <input type="text" class="form-control" id="role_name" name="role_name"
                                    placeholder="Tên phân quyền..."
                                    data-parsley-required-message="Vui lòng nhập tên phân quyền"
                                    data-parsley-maxlength="191"
                                    data-parsley-maxlength-message="Họ tên người dùng không thể nhập quá 191 ký tự"
                                    data-check-checkname 
                                    data-check-checkname-message="Tên phân quyền đã tồn tại"
                                     required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Danh sách quyền:</label>
                </div>
                {{-- <div class="page__toggle">
                    <label class="toggle">
                        <input class="toggle__input permission" id="select-all"
                            type="checkbox">
                        <span class="toggle__label">
                            <span class="toggle__text">Tất cả</span>
                        </span>
                    </label>
                </div> --}}
                @foreach ($permissions as $permission)
                    <div class="page__toggle">
                        <label class="toggle">
                            <input class="toggle__input permission" name="id" value="{{ $permission->id }}"
                                type="checkbox" required data-parsley-required-message="Vui lòng chọn ít nhất một quyền">
                            <span class="toggle__label">
                                <span class="toggle__text">{{ $permission->name }}</span>
                            </span>
                        </label>
                    </div>
                @endforeach

        </div>


        <div class="d-lg-flex justify-content-end">
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Lưu</button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('user.list') }}" class="btn btn-outline-primary px-5">Hủy</a>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div>
@endsection

@section('page-css')
@endsection

@section('page-js')
{{-- <script>
        $(document).ready(function() {
            $('#role_name').parsley();
            window.ParsleyValidator.addValidator('checkname', {
                validateString: function(value) {
                    return $.ajax({
                        url: "{{route('role.load_Ajax_Check_Role')}}",
                        method: 'POST',
                        data: {name: value},
                        dataType: "json",
                        success:function(data)
                         {
                            return true;
                         }
                    });
                }
            });
        })
    </script> --}}
    <script type="text/javascript">
        $("#role_id").multipleSelect({
            filter: true,
            selectAllText: 'Chọn tất cả',
            allSelected: 'Đã chọn tất cả',
            countSelected: 'Đã chọn # trên %',
            noMatchesFound: 'Không tìm thấy kết quả',
            minimumCountSelected: 1
        });
    </script>
    {{-- Validation phone --}}
    <script type="text/javascript">
        function isNumberKey(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function myFunction() {
            var x = document.getElementById("phone").value;
            if (isNaN(x)) {
                document.getElementById("phone").value = "";
            }
        }
    </script>
    {{-- Xử lý thêm --}}
    <script>
        $('#btn-submit-form').click(function() {
            if ($('#frm-them-moi').parsley().validate()) {
                var formData = new FormData();
                $(".permission").each(function(i) {
                    if (this.checked) {
                        formData.append('permission[]', this.value);
                    }
                });
                $("input[name='role_name']").map(function() {
                    formData.append('name', this.value)
                }).get();
                $.ajax({
                    url: "{{ route('role.store') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
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
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.replace(res.redirect)
                            }
                        })
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
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
    $('#select-all').click(function() {
        var checked = this.checked;
        $('input[type="checkbox"]').each(function() {
        this.checked = checked;
    });
    })
});
        </script> --}}
    
@endsection

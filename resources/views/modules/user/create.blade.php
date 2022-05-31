@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
        <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Họ Tên<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname"
                    placeholder="Họ tên người dùng..."
                    data-parsley-required-message="Vui lòng nhập họ tên người dùng"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Họ tên người dùng không thể nhập quá 191 ký tự"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Tên đăng nhập<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="username" name="username"
                    onkeypress="return isSpaceKey(event)"
                    placeholder="Tên đăng nhập..."
                    data-parsley-required-message="Vui lòng nhập tên đăng nhập"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Tên đăng nhập không thể nhập quá 191 ký tự"
                    required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Mật khẩu<span class="required"> *</span></label>
                    <input type="password" class="form-control" id="password" name="password"
                    placeholder="Mật khẩu..."
                    data-parsley-minlength="6"
                    data-parsley-minlength-message="Vui lòng nhập mật khẩu ít nhất 6 kí tự"
                    data-parsley-required-message="Vui lòng nhập mật khẩu"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Mật khẩu không thể nhập quá 191 ký tự"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Ngày sinh<span class="required"> *</span></label>
                    <input type="date" class="form-control" id="birthday" name="birthday"
                    data-parsley-required-message="Vui lòng nhập ngày sinh"
                    required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="dien-thoai">Số điện thoại<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="phone" name="phone"
                    maxlength="20"
                    placeholder="Số điện thoại..."
                    data-parsley-required-message="Vui lòng nhập số điện thoại"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="dia-chi">Địa chỉ<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="address" name="address"
                    placeholder="Địa chỉ..."
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Địa chỉ không thể nhập quá 191 ký tự"
                    data-parsley-required-message="Vui lòng nhập địa chỉ"
                    required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">CMND/CCCD<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="citizen_identification" name="citizen_identification"
                    placeholder="CCCD/CMND..."
                    data-parsley-required-message="Vui lòng nhập cccd/cmnd"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="CCCD/CMND không thể nhập quá 191 ký tự"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Email<span class="required"> *</span></label>
                    <input type="email" class="form-control" id="email" name="email"
                    placeholder="Email..."
                    data-parsley-type="email"
                    data-parsley-type-message="Email không đúng định dạng"
                    data-parsley-required-message="Vui lòng nhập email"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Email không thể nhập quá 191 ký tự"
                    required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="chuc-vu">Chức vụ<span class="required"> *</span></label>
                    <select class="form-select "
                    data-parsley-required-message="Vui lòng chọn chức vụ"
                    data-parsley-errors-container="#error-parley-select-cv"
                    required
                    id="role_id" name="role_id">
                    <option value=""></option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <div id="error-parley-select-cv"></div>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="chuc-vu">Phòng ban<span class="required"> *</span></label>
                    <select class="form-select "
                    data-parsley-required-message="Vui lòng chọn phòng ban"
                    data-parsley-errors-container="#error-parley-select-pb"
                    required
                    id="department_id" name="department_id">
                    <option value=""></option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <div id="error-parley-select-pb"></div>
                </div>
            </div>
            <div class="d-lg-flex justify-content-end">
                <div class="row mt-3" >
                    <div class="col-md-6 mb-3">
                        <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Lưu</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('user.list')}}"class="btn btn-outline-primary px-5">Hủy</a>
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

<script type="text/javascript">
    $("#role_id").select2({
       placeholder: "Chọn chức vụ",
       closeOnSelect : true,
        tags: false, 
    });

    $("#department_id").select2({
       placeholder: "Chọn phòng ban",
       closeOnSelect : true,
        tags: false, 
    });
</script>

<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
                $("input[name='fullname']").map(function(){ formData.append('fullname', this.value)}).get();
                $("input[name='username']").map(function(){ formData.append('username', this.value)}).get();
                $("input[name='password']").map(function(){ formData.append('password', this.value)}).get();
                $("input[name='birthday']").map(function(){ formData.append('birthday', this.value)}).get();
                $("input[name='phone']").map(function(){ formData.append('phone', this.value)}).get();
                $("input[name='address']").map(function(){ formData.append('address', this.value)}).get();
                $("input[name='citizen_identification']").map(function(){ formData.append('citizen_identification', this.value)}).get();
                $("input[name='email']").map(function(){ formData.append('email', this.value)}).get();
                $("select[name='role_id']").map(function(){ formData.append('role_id', this.value)}).get();
                $("select[name='department_id']").map(function(){ formData.append('department_id', this.value)}).get();
                $.ajax({
                    url: "{{ route('user.store') }}",
                    type: 'POST',
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
                    }).then((result) => {
                       if (result.dismiss === Swal.DismissReason.timer) 
                        {
                            window.location.replace(res.redirect)
                        }
                    })
                    }else {
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
@endsection


@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
        <form id="frm-cap-nhat" method="POST" data-parsley-validate="" novalidate>
            @csrf
            <input name="id" type="hidden" value="{{$user->id}}">
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                <label class="form-label" for="ten">Họ Tên<span class="required"> *</span></label>
                <input type="text" class="form-control" id="fullname" name="fullname"
                value="{{$user->fullname}}"
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
                    value="{{$user->username}}"
                    placeholder="Tên đăng nhập..."
                    data-parsley-required-message="Vui lòng nhập tên đăng nhập"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Tên đăng nhập không thể nhập quá 191 ký tự"
                    required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Email<span class="required"> *</span></label>
                    <input type="email" class="form-control" id="email" name="email"
                    value="{{$user->email}}"
                    placeholder="Email..."
                    data-parsley-type="email"
                    data-parsley-type-message="Email không đúng định dạng"
                    data-parsley-required-message="Vui lòng nhập email"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="email không thể nhập quá 191 ký tự"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="dien-thoai">Số điện thoại<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="phone" name="phone"
                    value="{{$user->phone}}"
                    maxlength="20"
                    placeholder="Số điện thoại..."
                    data-parsley-required-message="Vui lòng nhập số điện thoại"
                    required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="dia-chi">Địa chỉ<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="address" name="address"
                    value="{{$user->address}}"
                    placeholder="Địa chỉ..."
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Địa chỉ không thể nhập quá 191 ký tự"
                    data-parsley-required-message="Vui lòng nhập địa chỉ"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="mo-ta">Chức vụ<span class="required"> *</span></label>
                    <select class="form-select "
                    data-parsley-required-message="Vui lòng chọn chức vụ"
                    data-parsley-errors-container="#error-parley-select-cv"
                    required
                    id="role_id" name="role_id">
                        @foreach($roles as $role)
                            @if($role->id==$user->role_id)
                                <option value="{{ $role->id}} " selected>{{ $role->name }}</option>
                            @else
                                <option value="{{ $role->id}} ">{{ $role->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div id="error-parley-select-cv"></div>
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
    
</script>
{{-- Validation phone --}}
<script type="text/javascript">
    function isSpaceKey(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode ==32)
            return false;
        return true;
    }
   function isNumberKey(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    function myFunction() {
        var x=document.getElementById("phone").value;
        if(isNaN(x))
        {
            document.getElementById("phone").value="";
        }
    }
</script>
{{-- Xử lý cập nhật --}}
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-cap-nhat').parsley().validate()) {

            var formData = new FormData();
                $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
                $("input[name='fullname']").map(function(){ formData.append('fullname', this.value)}).get();
                $("input[name='username']").map(function(){ formData.append('username', this.value)}).get();
                $("input[name='password']").map(function(){ formData.append('password', this.value)}).get();
                $("input[name='email']").map(function(){ formData.append('email', this.value)}).get();
                $("input[name='phone']").map(function(){ formData.append('phone', this.value)}).get();
                $("input[name='address']").map(function(){ formData.append('address', this.value)}).get();
                $("select[name='role_id']").map(function(){ formData.append('role_id', this.value)}).get();

                $.ajax({
                    url: "{{ route('user.update') }}",
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
                       if (result.dismiss === Swal.DismissReason.timer) {
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
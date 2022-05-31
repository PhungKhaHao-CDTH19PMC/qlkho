@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
        <form method="POST" id="frm-cap-nhat" data-parsley-validate="" novalidate>
            @csrf
            <input type="hidden" id="id" name="id" value="{{$annual_leave->id}}">
            <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                <label class="form-label" for="ten">Tên nhân viên<span class="required"> *</span></label>
                <select class="form-select "
                    data-parsley-required-message="Vui lòng chọn nhân viên"
                    data-parsley-errors-container="#error-parley-select-nv"
                    required
                    id="user_id" name="user_id">
                    <option value=""></option>
                        @foreach($users as $user)
                            @if($user->id==$annual_leave->user_id)
                                <option value="{{ $user->id}} " selected>{{ $user->fullname }}</option>
                            @else
                                <option value="{{ $user->id}} ">{{ $user->fullname}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div id="error-parley-select-cv"></div>
            </div>
            <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                <label class="form-label" for="ten">Ngày bắt đầu<span class="required"> *</span></label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                value="{{$annual_leave->start_date}}"
                data-parsley-required-message="Vui lòng nhập ngày bắt đầu"
                required>
            </div>
            <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                <label class="form-label" for="ten">Ngày kết thúc<span class="required"> *</span></label>
                <input type="date" class="form-control" id="finish_date" name="finish_date"
                value="{{$annual_leave->finish_date}}"
                data-parsley-required-message="Vui lòng nhập ngày kết thúc"
                required>
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
        if($('#frm-cap-nhat').parsley().validate()) {
            var formData = new FormData();
                $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
                $("input[name='start_date']").map(function(){ formData.append('start_date', this.value)}).get();
                $("input[name='finish_date']").map(function(){ formData.append('finish_date', this.value)}).get();
                $("select[name='user_id']").map(function(){ formData.append('user_id', this.value)}).get();
                $.ajax({
                    url: "{{ route('annual_leave.update') }}",
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
<script type="text/javascript">
    $("#user_id").select2({
       placeholder: "Chọn nhân viên",
       closeOnSelect : true,
        tags: false, 
    });

</script>
@endsection


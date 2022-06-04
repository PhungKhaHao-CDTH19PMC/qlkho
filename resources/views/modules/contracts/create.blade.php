@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
        <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Ngày bắt đầu<span class="required"> *</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                    data-parsley-required-message="Vui lòng nhập ngày bắt đầu"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Ngày kết thúc<span class="required"> *</span></label>
                    <input type="date" class="form-control" id="finish_date" name="finish_date"
                    data-parsley-required-message="Vui lòng nhập ngày kết thúc"
                    required>
                    <!-- <div id="error-parley-select-fd" 
                        style="color: #e7515a;
                        font-size: 13px;
                        font-weight: 700;
                        letter-spacing: 1px;
                        margin: 0.5rem 0 0 0 !important;
                        list-style: none;"
                    ></div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Ngày kí hợp đồng<span class="required"> *</span></label>
                    <input type="date" class="form-control" id="signing_date" name="signing_date"
                    data-parsley-required-message="Vui lòng nhập ngày kí hợp đồng"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Nội dung<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="content" name="content"
                    placeholder="Nội dung"
                    data-parsley-required-message="Vui lòng nhập nội dung"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Họ tên người dùng không thể nhập quá 191 ký tự"
                    required>
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Số lần gia hạn<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="renewal_number" name="renewal_number"
                    placeholder="Số lần gia hạn"
                    readonly>
                </div> -->
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Tên nhân viên<span class="required"> *</span></label>
                    <select class="form-select "
                        data-parsley-required-message="Vui lòng chọn nhân viên"
                        data-parsley-errors-container="#error-parley-select-nv"
                        required
                        id="user_id" name="user_id">
                        <option value=""></option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                        @endforeach
                    </select>
                    <div id="error-parley-select-cv"></div>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Ngày gia hạn hợp đồng<span class="required"> *</span></label>
                    <input type="date" class="form-control" id="renewal_date" name="renewal_date"
                    data-parsley-required-message="Vui lòng nhập ngày kí hợp đồng"
                    required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Hệ số lương<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="salary_factor" name="salary_factor"
                    data-parsley-required-message="Vui lòng nhập hệ số lương"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Loại lương<span class="required"> *</span></label>
                    <select class="form-select "
                        data-parsley-required-message="Vui lòng chọn nhân viên"
                        data-parsley-errors-container="#error-parley-select-nv"
                        required
                        id="salary_id" name="salary_id">
                        <option value=""></option>
                        @foreach($salary as $sa)
                        <option value="{{ $sa->id }}">{{ $sa->name }}</option>
                        @endforeach
                    </select>
                    <div id="error-parley-select-cv"></div>
                </div>
            </div>
            <div class="row">
               
            </div>
            <div class="d-lg-flex justify-content-end">
                <div class="row" >
                    <div class="col-md-6 mb-3">
                        <button id="btn-submit-form" type="button" class="btn btn-primary px-5">Lưu</button>
                    </div>
                    <div class="col-md-6 mb-3">
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
                $("input[name='start_date']").map(function(){ formData.append('start_date', this.value)}).get();
                $("input[name='finish_date']").map(function(){ formData.append('finish_date', this.value)}).get();
                $("select[name='user_id']").map(function(){ formData.append('user_id', this.value)}).get();
                $("input[name='signing_date']").map(function(){ formData.append('signing_date', this.value)}).get();
                $("input[name='content']").map(function(){ formData.append('content', this.value)}).get();
                $("select[name='renewal_number']").map(function(){ formData.append('renewal_number', this.value)}).get();
                $("input[name='renewal_number']").map(function(){ formData.append('renewal_number', this.value)}).get();
                $("input[name='renewal_date']").map(function(){ formData.append('renewal_date', this.value)}).get();
                $("input[name='salary_factor']").map(function(){ formData.append('salary_factor', this.value)}).get();
                $("select[name='salary_id']").map(function(){ formData.append('salary_id', this.value)}).get();

                $.ajax({
                    url: "{{ route('contracts.store') }}",
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

<script type="text/javascript">
    $("#salary_id").select2({
       placeholder: "Chọn loại lương",
       closeOnSelect : true,
        tags: false, 
    });

</script>

<!-- <script>
    $("#finish_date").blur(function(){
        var ngay_bat_dau  = $("#start_date").val();
        var ngay_ket_thuc = $("#finish_date").val();
        var date1 = new Date(ngay_bat_dau);
        var date2 = new Date(ngay_ket_thuc);
        var difference = date2.getTime() - date1.getTime();
        var days = Math.ceil(difference / (1000 * 3600 * 24)) + 1;
        
        var d = new Date(ngay_ket_thuc);
        if(!isNaN(d))
        {
            if(ngay_bat_dau !='')
            {
                if(ngay_bat_dau>ngay_ket_thuc)
                {
                    $("#error-parley-select-fd").html("Ngày nghĩ đến không được nhỏ hơn ngày nghĩ từ");
                    $( "#btn-submit-form" ).prop( "disabled", true );
                    $("#total_day").val('');
                }
                else
                {
                    $("#error-parley-select-fd").html("");
                    $( "#btn-submit-form" ).prop( "disabled", false );
                    $("#total_day").val(days);
                }
            }
        }
        else
        {
            document.getElementById("finish_date").value="";
            document.getElementById("error-parley-select-fd").innerHTML=""
        }
    });
</script>
<script>
  $("#start_date").blur(function(){
    var ngay_bat_dau  = $("#start_date").val();
    var ngay_ket_thuc = $("#finish_date").val("");
    var d = new Date(ngay_bat_dau);
    if(isNaN(d))
    {
        $("#start_date").val("");
        $("#total_day").val('');
    }
  });
</script> -->
@endsection


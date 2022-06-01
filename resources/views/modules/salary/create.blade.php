@extends('master')
@section('page-content')
<div class="card">
    <div class="card-body">
        <form method="POST" id="frm-them-moi" data-parsley-validate="" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin-bottom:1%">
                    <label class="form-label" for="ten">Tên lương<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                    placeholder="Nội dung"
                    data-parsley-required-message="Vui lòng nhập tên lương"
                    data-parsley-maxlength="191"
                    data-parsley-maxlength-message="Tên lương không thể nhập quá 191 ký tự"
                    required>
                </div>
                <div class="col-md-6 col-sm-12" style="margin-bottom:2%">
                    <label class="form-label" for="ten">Lương cơ bản<span class="required"> *</span></label>
                    <input type="text" class="form-control" id="salary_payable" name="salary_payable"
                    placeholder="Nội dung"
                    data-parsley-required-message="Vui lòng nhập lương cơ bản"
                    required>
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
            $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
                $("input[name='name']").map(function(){ formData.append('name', this.value)}).get();
                $("input[name='salary_payable']").map(function(){ formData.append('salary_payable', this.value)}).get();

                $.ajax({
                    url: "{{ route('salary.store') }}",
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


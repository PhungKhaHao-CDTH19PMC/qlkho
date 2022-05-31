@extends('master')
@section('page-content')
    <div class="card">
        <div class="card-body">
            <form id="frm-cap-nhat" method="POST" data-parsley-validate="" novalidate>
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label" for="mo-ta">Tên phân quyền</label>
                            </div>
                            <div class="col-md-9">
                                <span>{{ $role->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label" for="mo-ta">Danh sách quyền</label>
                            </div>
                            {{-- {{dd($permissionOfUser)}} --}}
                            <div class="col-md-9">
                                <input type="hidden" value="{{$role->id}}" name="id">
                                <select multiple="multiple" class="form-control"
                                    data-parsley-required-message="Vui lòng chọn chức vụ"
                                    data-parsley-errors-container="#error-parley-select-cv" required id="role_id"
                                    name="role_id">
                                    @foreach ($Permission as $value)
                                        <option value="{{ $value->id }}"
                                            @foreach ($permissionOfRole as $permision)
                                             @if ($value->id == $permision->permission_id) 
                                             selected
                                             @endif
                                            @endforeach>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="d-lg-flex justify-content-end">
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <button id="btn-update-modal" type="button" class="btn btn-primary px-5">Lưu</button>
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
    <script>
        $("#role_id").multipleSelect({
            filter: true,
            selectAllText: 'Chọn tất cả',
            allSelected: 'Đã chọn tất cả',
            countSelected: 'Đã chọn # trên %',
            noMatchesFound: 'Không tìm thấy kết quả',
            minimumCountSelected: 1
        });
    </script>
    <script>
        
            $('#btn-update-modal').click(function(e) {
                
                var role = ($("#role_id").val());
                var formData = new FormData();
                formData.append('role_id', role);
                $("input[name='id']").map(function() {
                    formData.append('id', this.value)
                }).get();
                $.ajax({
                    url: "{{ route('role.update') }}",
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
            })
    </script>
@endsection

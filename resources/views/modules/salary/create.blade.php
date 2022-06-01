<div class="modal fade" id="create-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="create_form" id="frm-them-moi" method="POST" data-parsley-validate="" novalidate>
                    @csrf
                    <div style="margin-bottom:1%">
                        <label class="form-label" for="ten">Tên lương<span class="required"> *</span></label>
                        <input type="text" class="form-control" id="name_create" name="name_create"
                        placeholder="Tên lương"
                        data-parsley-required-message="Vui lòng nhập tên lương"
                        data-parsley-maxlength="191"
                        data-parsley-maxlength-message="Tên lương không thể nhập quá 191 ký tự"
                        required>
                    </div>
                    <div style="margin-bottom:2%">
                        <label class="form-label" for="ten">Lương cơ bản<span class="required"> *</span></label>
                        <input type="text" class="form-control" id="salary_payable" name="salary_payable"
                        placeholder="Lương"
                        data-parsley-required-message="Vui lòng nhập lương cơ bản"
                        required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <input id="btn-save-modal" type="submit" class="btn btn-primary" value="Lưu">
            </div>
        </div>
    </div>
</div>

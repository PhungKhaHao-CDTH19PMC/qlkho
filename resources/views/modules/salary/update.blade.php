<div class="modal fade" id="update-modal" tabindex="-1"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="update_form" id="frm-cap-nhat" data-parsley-validate="" novalidate>
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div style="margin-bottom:1%">
                        <label class="form-label" for="ten">Tên lương<span class="required"> *</span></label>
                        <input type="text" class="form-control" id="name_update" name="name_update"
                        placeholder="Nội dung"
                        data-parsley-required-message="Vui lòng nhập tên lương"
                        data-parsley-maxlength="191"
                        data-parsley-maxlength-message="Tên lương không thể nhập quá 191 ký tự"
                        required>
                    </div>
                    <div style="margin-bottom:2%">
                        <label class="form-label" for="ten">Lương cơ bản<span class="required"> *</span></label>
                        <input type="text" class="form-control" id="salary_payable" name="salary_payable"
                        placeholder="Nội dung"
                        data-parsley-required-message="Vui lòng nhập lương cơ bản"
                        required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <input id="btn-update-modal" type="submit" class="btn btn-primary" value="Lưu">
            </div>
        </div>
    </div>
</div>

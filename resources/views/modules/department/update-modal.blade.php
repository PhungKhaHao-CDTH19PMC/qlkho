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
                    <div class="mb-3 needs-validation">
                        <input type="hidden" id = "id" name = "id">
                        <label class="form-label" for="ten-loai">Tên phòng ban<span class="required"> *</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                        placeholder="Tên phòng ban"
                        data-parsley-required-message="Vui lòng nhập tên phòng ban"
                        data-parsley-maxlength="191"
                        data-parsley-maxlength-message="Tên phòng ban không thể nhập quá 191 ký tự"
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
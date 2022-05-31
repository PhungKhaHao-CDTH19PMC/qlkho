
<!doctype html>
<html lang="vi">

<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('inc.common-css')
	<title>Đăng nhập - Quản lý Kho</title>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<img src="{{ asset('assets/images/logo-img.png') }}" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Đăng nhập</h3>
									</div>
									<div class="form-body">
										<form class="row g-3" action="{{ route('do_login') }}" method="POST" id = "frm-dang-nhap" data-parsley-validate="" novalidate>
											@csrf
											<div class="col-12 needs-validation">
												<label for="username" class="form-label">Tên đăng nhập</label>
												<input type="text" class="form-control"
                                                name="username" id="username"
                                                data-parsley-required-message="Vui lòng nhập tên đăng nhập"
                                                data-parsley-maxlength="191"
                                                data-parsley-maxlength-message="Tên đăng nhập không thể nhập quá 191 ký tự"
                                                placeholder="Tên đăng nhập" required>
											</div>
											<div class="col-12 needs-validation">
												<label for="password" class="form-label">Mật khẩu</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0"
                                                    name="password" id="password" placeholder="Mật khẩu"
                                                    data-parsley-required-message="Vui lòng nhập mật khẩu"
                                                    data-parsley-errors-container="#error-parley-select-pw"
                                                    data-parsley-maxlength="191"
                                                    data-parsley-maxlength-message="Mật khẩu không thể nhập quá 191 ký tự"
                                                    required>
													<a href="javascript:;" id = "showPass" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>

                                                </div>
                                                <div id="error-parley-select-pw"></div>
                                                @if (session('status_admin'))
                                                    <ul class="error-login-cms parsley-errors-list filled">
                                                        <li class="parsley-required"> {{ session('status_admin') }}</li>
                                                    </ul>
                                                @endif
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="remmber-me" checked>
													<label class="form-check-label" for="remmber-me">Ghi nhớ</label>
												</div>
											</div>
											<div class="col-md-6 text-end">	<a href="#">Quên mật khẩu?</a>
											</div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button id="btn-submit-form" type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Đăng Nhập</button>
                                                </div>
                                            </div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	@include('inc.common-js')
    <script type="text/javascript">
        $('#showPass').click(function() {
            var input = document.getElementById('password');
            if(input.type == 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
            console.log(document.getElementById('mat-khau'));
            //type="password"
        });
    </script>
	<!--end wrapper-->
</body>

</html>

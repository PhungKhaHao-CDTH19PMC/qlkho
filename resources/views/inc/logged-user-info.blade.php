<div class="user-box dropdown">
    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ asset('assets/images/avatars/avatar-2.png') }}" class="user-img" alt="user avatar">
        <div class="user-info ps-3">
            <p class="user-name mb-0">{{ auth()->user()->fullname }}</p>
            <p class="designattion mb-0">{{ auth()->user()->role->name }}</p>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item"href="{{ route('account.edit',['id' => auth()->user()->id])}}"><i class="bx bx-user"></i><span>Thông tin Tài khoản</span></a>
        </li>
        <li>
            <div class="dropdown-divider mb-0"></div>
        </li>
        <li><a class="dropdown-item" href="{{ route('logout') }}"><i class='bx bx-log-out-circle'></i><span>Đăng xuất</span></a>
        </li>
    </ul>
</div>
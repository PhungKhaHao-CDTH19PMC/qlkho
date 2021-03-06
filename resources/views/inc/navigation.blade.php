@php
$menuItems = [
    [
        'title'     => 'Dashboard',
        'icon'      => 'bx-home-circle',
        'module'    => 'dashboard',
        'link'      => 'dashboard'
    ],
    [
        'title'     => 'Hợp đồng',
        'icon'      => 'bx-home-circle',
        'module'    => 'contracts',
        'link'      => 'contracts.list'
    ],
    [
        'title'     => 'Người dùng',
        'icon'      => 'bx-user-circle',
        'module'    => 'user',
        'link'      => 'user.list'
    ],
    [
        'title'     => 'Phân quyền',
        'icon'      => 'bx-user-check',
        'module'    => 'role',
        'link'      => 'role.list'
    ],
    [
        'title'     => 'Phòng ban',
        'icon'      => 'bx-building-house',
        'module'    => 'department',
        'link'      => 'department.list'
    ],
    [
        'title'     => 'Nghĩ phép',
        'icon'      => 'bx-building-house',
        'module'    => 'annual_leave',
        'link'      => 'annual_leave.list'
    ],
    [
        'title'     => 'Loại lương',
        'icon'      => 'bx-home-circle',
        'module'    => 'salary',
        'link'      => 'salary.list'
    ],
    [
        'title'     => 'Bảng lương',
        'icon'      => 'bx-home-circle',
        'module'    => 'pay_salaries',
        'link'      => 'pay_salaries.list'
    ],
    [
        'title'     => 'Chấm công',
        'icon'      => 'bx-home-circle',
        'module'    => 'Timesheet',
        'link'      => 'Timesheet.list'
    ],
];
@endphp
<ul class="metismenu" id="menu">
    @foreach($menuItems as $menu)
    @if (empty($menu['sub-menu']))
    <li @if($menu["module"] == $module) class="mm-active" @endif>
        <a href="{{ route($menu['link']) }}">
            <div class="parent-icon">
                <i class="bx {{ $menu['icon'] }}"></i>
            </div>
            <div class="menu-title">{{ $menu['title'] }}</div>
        </a>
    </li>
    @else
    <li @if($menu["module"] == $module) class="mm-active" @endif>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
                <i class="bx {{ $menu['icon'] }}"></i>
            </div>
            <div class="menu-title">{{ $menu['title'] }}</div>
        </a>
        <ul>
            @foreach($menu['sub-menu'] as $sub)
            <li  @if(!empty($module) && $sub["module"] == $module) class="mm-active" @endif> 
                <a href="{{ route($sub['link']) }}"><i class="bx bx-right-arrow-alt"></i>{{ $sub['title'] }}</a>
            </li>
            @endforeach
        </ul>
    </li>
    @endif
    @endforeach
</ul>
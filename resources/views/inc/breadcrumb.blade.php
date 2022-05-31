<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{ $breadcrumb['object'] }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                @if (!empty($breadcrumb['page']))
                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['page'] }}</li>
                @endif
            </ol>
        </nav>
    </div>
</div>
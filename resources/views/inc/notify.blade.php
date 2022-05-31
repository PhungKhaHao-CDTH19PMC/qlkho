@if (session('type') && session('message'))
    Lobibox.notify("{{ session('type') }}", {
        pauseDelayOnHover: false,
        size: 'mini',
        delay: 1500,
        sound: false,    
        rounded: true,
        icon: 'bx bx-check-circle',
        position: 'top right',
        msg: "{{ session('message') }}"
    })
@endif
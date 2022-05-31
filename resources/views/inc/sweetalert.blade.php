<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
@if(session('status'))
<script type="text/javascript">
        swal.fire({
            title:  "{{session('status')}}",
            type: 'success',
            padding: '2em',
            showConfirmButton: false,
            timer: 1500,
        })
    </script>
@endif
@if(session('error'))
    <script type="text/javascript">
        swal.fire({
            title:  "{{session('error')}}",
            type: 'error',
            padding: '2em',
            showConfirmButton: false,
            timer: 1500,
        })
    </script>
@endif
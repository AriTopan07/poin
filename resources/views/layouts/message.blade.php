<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (Session::has('error'))
    <script>
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).fire({
            icon: 'error',
            text: '{{ session('error') }}',
        });
    </script>
@endif

@if (Session::has('success'))
    <script>
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        }).fire({
            icon: 'success',
            text: '{{ session('success') }}',
        });
    </script>
@endif

@if (Session::has('warning'))
    <script type="text/javascript">
        window.onload = function() {
            @if (Session::has('warning'))
                Swal.fire({
                    icon: 'warning',
                    text: '{{ Session::get('warning') }}',
                    onClose: () => {
                        window.close();
                    }
                }).then((result) => {
                    if (!result.dismiss) {
                        window.close();
                    }
                });
            @endif
        }
    </script>
@endif

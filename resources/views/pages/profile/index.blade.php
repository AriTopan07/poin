@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <h5 class="card-header">Profile</h5>
                            <div class="card-body">
                                <form action="" method="POST" id="change-password-form">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                                    @if (Auth::user()->role == 1)
                                        <div class="form-group">
                                            <label for="name" class="form-label">Username</label>
                                            <input type="text" name="nip" id="nip" class="form-control"
                                                value="{{ $user->username }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                value="{{ $user->name }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    @endif
                                    @if (Auth::user()->role == 2)
                                        <div class="form-group">
                                            <label for="name" class="form-label">NIP</label>
                                            <input type="text" name="nip" id="nip" class="form-control"
                                                value="{{ $data->nip }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                value="{{ $data->nama }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="username" class="form-label">No Hp</label>
                                            <input type="text" name="nohp" id="nohp" class="form-control"
                                                value="{{ $data->nohp }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    @endif
                                    <div class="form-group mt-3">
                                        <label class="text-danger" style="font-size: 12px">
                                            Kosongkan jika tidak ingin merubah password
                                        </label>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">Password Sekarang</label>
                                        <input type="password" name="current_password" id="current_password"
                                            class="form-control" placeholder="Password sekarang" autocomplete="off">
                                        <p class="invalid-feedback"></p>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control"
                                            placeholder="Password baru" minlength="8" autocomplete="off">
                                        <p class="invalid-feedback"></p>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">Konfirmasi Password Baru</label>
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation" class="form-control"
                                            placeholder="Konfirmasi password baru" minlength="8" autocomplete="off">
                                        <div id="password-mismatch" class="text-danger"></div>
                                        <p class="invalid-feedback"></p>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" value="Simpan" class="btn btn-primary w-100">Simpan
                                            Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('new_password_confirmation');
            const passwordMismatch = document.getElementById('password-mismatch');
            const submitButton = document.querySelector('button[type="submit"]');

            confirmPassword.addEventListener('input', function() {
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity(
                        'Konfirmasi password tidak sesuai dengan password baru');
                    passwordMismatch.textContent = 'Konfirmasi password tidak sesuai dengan password baru';
                } else {
                    confirmPassword.setCustomValidity('');
                    passwordMismatch.textContent = '';
                }

                submitButton.disabled = !document.getElementById('change-password-form').checkValidity();
            });
        });

        $(document).ready(function() {
            $('#change-password-form').submit(function(event) {
                event.preventDefault(); // Mencegah pengiriman form secara default

                let formData = $(this).serialize();
                let submitButton = $("button[type='submit']");
                submitButton.prop('disabled', true);

                let spinnerHtml =
                    '<div class="spinner-border text-light spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                let originalButtonHtml = submitButton.html();
                submitButton.html(spinnerHtml);

                let uid = $('#id').val();
                let url = '{{ route('profile.update-password', ':id') }}';
                url = url.replace(':id', uid);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);

                        if (data.success === true) {
                            // Menghapus feedback kesalahan dan kelas is-invalid
                            $('.invalid-feedback').removeClass('invalid-feedback').html('');
                            $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                                .removeClass('is-invalid');

                            // Reload halaman jika sukses
                            window.location.reload();
                        } else {
                            // Menghapus feedback kesalahan sebelumnya
                            $('.invalid-feedback').removeClass('invalid-feedback').html('');
                            $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                                .removeClass('is-invalid');

                            // Menampilkan pesan kesalahan di form
                            $.each(data.errors, function(field, errorMessage) {
                                $("#" + field).addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errorMessage[0]);
                            });
                        }
                    },
                    error: function() {
                        console.log('Terjadi kesalahan');
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);
                    }
                });
            });
        });
    </script>
@endsection

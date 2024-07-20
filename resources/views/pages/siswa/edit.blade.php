@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ url()->previous() }}">Data Siswa</a>
                </li>
                <li class="breadcrumb-item active">Edit Data Siswa</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="card-title">Tambah data siswa</h5>
                            </div>
                            <div class="card-body">
                                <form method="PUT" action="" enctype="multipart/form-data" id="siswaForm">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $data['siswa']->id }}">
                                    <div class="row mb-3">
                                        <h6>Identitas Siswa</h6>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Kelas</label>
                                            <select name="kelas" id="kelas" class="form-control">
                                                <option value="">Pilih kelas</option>
                                                @foreach ($data['kelas'] as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $data['siswa']->kelas_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">NISN</label>
                                            <input type="text" class="form-control" id="nisn" name="nisn"
                                                autocomplete="off" value="{{ $data['siswa']->nisn }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa"
                                                autocomplete="off" value="{{ $data['siswa']->nama_siswa }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="jk" class="form-label mt-3">Jenis kelamin</label>
                                            <div class="row mt-2">
                                                <div class="col">
                                                    <input name="jk" class="form-check-input" type="radio"
                                                        value="Laki - laki" id="men"
                                                        {{ $data['siswa']->jk == 'Laki - laki' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="men">Laki - laki</label>
                                                </div>
                                                <div class="col">
                                                    <input name="jk" class="form-check-input" type="radio"
                                                        value="Perempuan" id="woman"
                                                        {{ $data['siswa']->jk == 'Perempuan' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="woman">Perempuan</label>
                                                </div>
                                            </div>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                                autocomplete="off" value="{{ $data['siswa']->tempat_lahir }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir"
                                                name="tanggal_lahir" autocomplete="off"
                                                value="{{ $data['siswa']->tanggal_lahir }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">No Hp</label>
                                            <input type="text" class="form-control" id="telp_siswa" name="telp_siswa"
                                                autocomplete="off" placeholder="628xxxxxxxxxx"
                                                value="{{ $data['siswa']->telp_siswa }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control">{{ $data['siswa']->alamat }}</textarea>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <h6 class="mt-3">Identitas Wali</h6>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Nama Wali</label>
                                            <input type="text" class="form-control" id="nama_wali" name="nama_wali"
                                                autocomplete="off" value="{{ $data['siswa']->nama_wali }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">No Hp</label>
                                            <input type="text" class="form-control" id="telp_wali" name="telp_wali"
                                                autocomplete="off" placeholder="628xxxxxxxxxx"
                                                value="{{ $data['siswa']->telp_wali }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Status</label>
                                            <input type="text" class="form-control" id="status" name="status"
                                                autocomplete="off" value="{{ $data['siswa']->status }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kelas" class="form-label mt-3">Alamat</label>
                                            <textarea name="alamat_wali" id="alamat_wali" class="form-control">{{ $data['siswa']->alamat_wali }}</textarea>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="float-end">
                                        <button type="submit" value="Simpan"
                                            class="btn btn-sm btn-primary fw-bold">Simpan</button>
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
        $(document).ready(function() {
            $('#siswaForm').submit(function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                let submitButton = $("button[type='submit']");
                let studentId = $('#id').val();

                submitButton.prop('disabled', true);

                let spinnerHtml =
                    '<div class="spinner-border text-light spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                let originalButtonHtml = submitButton.html();
                submitButton.html(spinnerHtml);

                let url = '{{ route('siswa.update', ':id') }}';
                url = url.replace(':id', studentId);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        submitButton.prop('disabled', false);
                        submitButton.html('Simpan');

                        if (data['success'] === true) {
                            $('.invalid-feedback').removeClass('invalid-feedback').html('');
                            $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                                .removeClass('is-invalid');
                            window.location.reload();
                        } else {
                            $('.invalid-feedback').removeClass('invalid-feedback').html('');
                            $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                                .removeClass('is-invalid');

                            $.each(data.errors, function(field, errorMessage) {
                                $("#" + field).addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errorMessage[0]);
                            });
                            console.log(errorMessage);
                        }
                    },
                    error: function() {
                        console.log('terjadi kesalahan');
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);
                    }
                });
            });
        });
    </script>
@endsection

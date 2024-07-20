@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('siswa.index') }}">Kelas</a>
                </li>
                <li class="breadcrumb-item active">Data Siswa</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="card-title">Data Siswa Kelas <span
                                        class="fw-bold">{{ $data['kelas']->kelas }}</span></h5>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-hover" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Nama Wali</th>
                                            <th>No Hp Wali</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['siswa']->where('kelas_id', $data['kelas']->id) as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nisn }}</td>
                                                <td>{{ $item->nama_siswa }}</td>
                                                <td>{{ $item->nama_wali }}</td>
                                                <td>{{ $item->telp_wali }}</td>
                                                <td>
                                                    @if (Auth::user()->role == 1)
                                                        <a href="{{ route('siswa.edit', ['id' => $item->siswa_id]) }}"
                                                            class="text-primary" title="edit">
                                                            <i class="menu-icon tf-icons bx bx-pencil"></i>
                                                        </a>
                                                        <a onclick="showData({{ $item->id }})" href="javascript:void(0)"
                                                            class="text-info" title="detail">
                                                            <i class="menu-icon tf-icons bx bx-show"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('siswa.point-pelanggaran', $item->siswa_id) }}"
                                                        class="text-warning" title="point">
                                                        <i class="menu-icon tf-icons bx bx-book"></i>
                                                    </a>
                                                    @if (Auth::user()->role == 1)
                                                        <a onclick="deleteData({{ $item->id }})"
                                                            href="javascript:void(0)" class="text-danger" title="delete">
                                                            <i class="menu-icon tf-icons bx bx-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- show --}}
    <div class="modal fade modal-xl" id="modalShow" tabindex="-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Detail Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <h6>Identitas Siswa</h6>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="jk" name="jk" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">Tempat lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">No Hp Siswa</label>
                            <input type="text" class="form-control" id="telp_siswa" name="telp_siswa" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-12 mb-2">
                            <label for="kelas" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <h6>Identitas Wali</h6>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">Nama Wali</label>
                            <input type="text" class="form-control" id="nama_wali" name="nama_wali" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">No Hp Wali</label>
                            <input type="text" class="form-control" id="telp_wali" name="telp_wali" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label for="kelas" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" required
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-sm-12 mb-2">
                            <label for="kelas" class="form-label">Alamat</label>
                            <textarea name="alamat_wali" id="alamat_wali" class="form-control" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary fw-bold"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        function showData(id) {
            $('#modalShow').modal('show');
            let url = '{{ route('siswa.show', 'ID') }}';
            let newUrl = url.replace('ID', id);

            console.log(id);

            $.ajax({
                url: newUrl,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        $('#nisn').val(response.data.nisn);
                        $('#nama_siswa').val(response.data.nama_siswa);
                        $('#telp_siswa').val(response.data.telp_siswa);
                        $('#jk').val(response.data.jk);
                        $('#tempat_lahir').val(response.data.tempat_lahir);
                        $('#tanggal_lahir').val(response.data.tanggal_lahir);
                        $('#alamat').val(response.data.alamat);
                        $('#nama_wali').val(response.data.nama_wali);
                        $('#telp_wali').val(response.data.telp_wali);
                        $('#status').val(response.data.status);
                        $('#alamat_wali').val(response.data.alamat_wali);
                    }
                }
            });
        }

        function deleteData(id) {
            let url = '{{ route('siswa.delete', 'ID') }}';
            let newUrl = url.replace('ID', id);

            console.log(id);

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Anda tidak dapat mengembalikannya setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: newUrl,
                        type: 'delete',
                        data: {},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(results) {
                            if (results.status === true) {
                                setTimeout(function() {
                                    location.reload();
                                }, 50);
                            } else {
                                setTimeout(function() {
                                    location.reload();
                                }, 50);
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection

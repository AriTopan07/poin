@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Data Sanksi</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="card-title">Data Sanksi</h5>

                                <div class="card-header-elements ms-auto">
                                    <button onclick="createData()" type="button"
                                        class="btn btn-primary btn-sm fw-bold">Tambah
                                        Data</button>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-hover" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sanksi</th>
                                            <th>Poin dari</th>
                                            <th>Poin sampai</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['sanksi'] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->sanksi }}</td>
                                                <td>{{ $item->bobot_dari }}</td>
                                                <td>{{ $item->bobot_sampai }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    <a onclick="editData({{ $item->id }})" href="javascript:void(0)"
                                                        class="text-primary" title="edit">
                                                        <i class="menu-icon tf-icons bx bx-pencil"></i>
                                                    </a>
                                                    <a onclick="deleteData({{ $item->id }})" href="javascript:void(0)"
                                                        class="text-danger" title="delete">
                                                        <i class="menu-icon tf-icons bx bx-trash"></i>
                                                    </a>
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

    {{-- create --}}
    <div class="modal fade modal-md" id="modalCreate" tabindex="-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('sanksi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Sanksi</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="sanksi" name="sanksi" required
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Poin Dari</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="bobot_dari" name="bobot_dari" required
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Poin Sampai</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="bobot_sampai" name="bobot_sampai" required
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Keterangan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="keterangan" name="keterangan" required
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" value="Simpan" class="btn btn-sm btn-primary fw-bold">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade modal-md" id="modalEdit" tabindex="-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id">
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Sanksi</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="edit_sanksi" name="edit_sanksi" required
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Poin Dari</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="edit_bobot_dari" name="edit_bobot_dari"
                                    required autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Poin Sampai</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="edit_bobot_sampai"
                                    name="edit_bobot_sampai" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kelas" class="form-label">Keterangan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="edit_keterangan" name="edit_keterangan"
                                    required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" value="Simpan" class="btn btn-sm btn-primary fw-bold">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        function createData() {
            $('#modalCreate').modal('show');
        }

        $(document).ready(function() {

            $('#modalEdit').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let id = $('#id').val();
                let formData = {
                    '_token': csrfToken,
                    'id': id,
                    'edit_sanksi': $('#edit_sanksi').val(),
                    'edit_bobot_dari': $('#edit_bobot_dari').val(),
                    'edit_bobot_sampai': $('#edit_bobot_sampai').val(),
                    'edit_keterangan': $('#edit_keterangan').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'sanksi/' + id,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === true) {
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
            });
        });

        function editData(id) {
            $('#modalEdit').modal('show');

            $.ajax({
                url: 'sanksi/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.status) {
                        $('#id').val(response.data.id);
                        $('#edit_sanksi').val(response.data.sanksi);
                        $('#edit_bobot_dari').val(response.data.bobot_dari);
                        $('#edit_bobot_sampai').val(response.data.bobot_sampai);
                        $('#edit_keterangan').val(response.data.keterangan);
                    }
                }
            });
        }

        function deleteData(id) {
            let url = '{{ route('sanksi.delete', 'ID') }}';
            let newUrl = url.replace('ID', id);

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

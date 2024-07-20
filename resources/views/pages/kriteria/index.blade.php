@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Data Kriteria</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="card-title">Data Kriteria</h5>

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
                                            <th>Kriteria</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['kriteria'] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
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
                <form method="POST" action="{{ route('kriteria.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="name" class="form-label">Kriteria</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" required
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
                <form method="POST" action="{{ route('kelas.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id">
                        <div class="row mb-3">
                            <label for="name" class="form-label">Kriteria</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="edit_name" name="edit_name" required
                                    autocomplete="off">
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
                    'edit_name': $('#edit_name').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'kriteria/' + id,
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
                url: 'kriteria/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.status) {
                        $('#id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                    }
                }
            });
        }

        function deleteData(id) {
            console.log(id);
            let url = '{{ route('kriteria.delete', 'ID') }}';
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

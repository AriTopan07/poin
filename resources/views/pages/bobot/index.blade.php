@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Data Pembobotan</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($data['kriteria'] as $kriteria)
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header header-elements">
                                    <h5 class="card-title text-danger">Kriteria : {{ $kriteria->name }}</h5>

                                    <div class="card-header-elements ms-auto">
                                        <div class="card-header-elements ms-auto">
                                            <button data-kriteria-id="{{ $kriteria->id }}" type="button"
                                                class="btn btn-primary btn-sm d-sm-inline-block fw-bold"
                                                data-bs-toggle="modal" data-bs-target="#modalCreate">Tambah Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-striped table-hover" id="">
                                        <thead>
                                            <tr>
                                                <th>Sub Kriteria</th>
                                                <th>Bobot</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['crips'] as $crips)
                                                @if ($crips->kriteria_id === $kriteria->id)
                                                    <tr>
                                                        <td>{{ $crips->name }}</td>
                                                        <td>{{ $crips->bobot }}</td>
                                                        <td>
                                                            <a onclick="editData({{ $crips->id }})"
                                                                href="javascript:void(0)" class="text-primary"
                                                                title="edit">
                                                                <i class="menu-icon tf-icons bx bx-pencil"></i>
                                                            </a>
                                                            <a onclick="deleteData({{ $crips->id }})"
                                                                href="javascript:void(0)" class="text-danger"
                                                                title="delete">
                                                                <i class="menu-icon tf-icons bx bx-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-3">
                            <label for="name"
                                class="col-sm-3 col-form-label text-secondary fw-semibold">Kriteria</label>
                            <div class="col-sm-9">
                                <select id="kriteria_id" name="kriteria" class="form-select"
                                    aria-label="Default select example" disabled>
                                    @foreach ($data['kriteria'] as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $item->kriteria_id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="crips" class="col-sm-3 col-form-label text-secondary fw-semibold">Sub
                                Kriteria</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Inputkan sub kriteria" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="bobot" class="col-sm-3 col-form-label text-secondary fw-semibold">Bobot</label>
                            <div class="col-sm-9">
                                <input type="number" name="bobot" id="bobot" class="form-control"
                                    placeholder="Inputkan bobot" required>
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

    {{-- create --}}
    <div class="modal fade modal-md" id="modalCreate" tabindex="-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="{{ route('bobot.store') }}" action="" enctype="multipart/form-data" id="create"
                    name="create">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="name"
                                class="col-sm-3 col-form-label text-secondary fw-semibold">Kriteria</label>
                            <div class="col-sm-9">
                                <select id="kriteria" name="kriteria" class="form-select"
                                    aria-label="Default select example" disabled>
                                    @foreach ($data['kriteria'] as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $item->kriteria_id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="crips" class="col-sm-3 col-form-label text-secondary fw-semibold">Sub
                                Kriteria</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Inputkan sub kriteria" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="bobot" class="col-sm-3 col-form-label text-secondary fw-semibold">Bobot</label>
                            <div class="col-sm-9">
                                <input type="number" name="bobot" id="bobot" class="form-control"
                                    placeholder="Inputkan bobot" required>
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
@endsection

@section('customJs')
    <script>
        document.querySelectorAll('button[data-kriteria-id]').forEach(button => {
            button.addEventListener('click', function() {
                const kriteriaId = this.getAttribute('data-kriteria-id');
                const select = document.getElementById('kriteria');
                select.value = kriteriaId;
                console.log(kriteriaId);

                $(document).ready(function() {
                    $('#create').submit(function(event) {
                        event.preventDefault();

                        let csrfToken = $('meta[name="csrf-token"]').attr('content');
                        const formData = $(this).serializeArray();

                        formData.push({
                            name: 'kriteria_id',
                            value: kriteriaId
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('bobot.store') }}',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
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
                    });
                });
            });
        });

        function editData(id) {
            $('#modalEdit').modal('show');

            console.log(id);

            $.ajax({
                url: 'bobot/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.status) {
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#bobot').val(response.data.bobot);
                        $('#kriteria_id').val(response.data.kriteria_id);
                    }
                }
            });
        }

        $('#modalEdit').submit(function(event) {
            event.preventDefault();

            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            let id = $('#id').val();
            let formData = {
                '_token': csrfToken,
                'id': id,
                'name': $('#name').val(),
                'bobot': $('#bobot').val(),
                'kriteria_id': $('#kriteria_id').val(),
            };

            $.ajax({
                type: 'PUT',
                url: 'bobot/' + id,
                data: formData,
                dataType: 'json',
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
        });

        function deleteData(id) {
            let url = '{{ route('bobot.delete', 'ID') }}';
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

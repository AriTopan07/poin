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
                <li class="breadcrumb-item active">Data Pelanggaran Siswa</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="card-title">Data Pelanggaran <span
                                        class="fw-bold text-primary">{{ $data['siswa']->siswa_nama }}</span>
                                </h5>
                                <div class="card-header-elements ms-auto">
                                    @if (Auth::user()->role == 1)
                                        <a href="{{ route('report.siswa', ['id' => $data['siswa']->id]) }}">
                                            <input type="hidden" name="" value="{{ $data['siswa']->id }}">
                                            <button type="submit" class="btn btn-success btn-sm fw-bold">Download</button>
                                        </a>
                                    @endif
                                    @if (Auth::user()->role == 2)
                                        <button onclick="createData()" type="button"
                                            class="btn btn-primary btn-sm fw-bold">Tambah
                                            Pelanggaran</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-hover" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggaran</th>
                                            <th>Point</th>
                                            <th>Diinputkan Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['pelanggaran'] as $plg)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($plg->tgl)->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                                                </td>
                                                <td>Pelanggaran ({{ $plg->nama_kriteria }}) - {{ $plg->crips_nama }}</td>
                                                <td>{{ $plg->crips_bobot }}</td>
                                                <td>{{ $plg->user_nama }}</td>
                                                <td>
                                                    <a onclick="deleteData({{ $plg->pel_id }})" href="javascript:void(0)"
                                                        class="text-danger" title="delete">
                                                        <i class="menu-icon tf-icons bx bx-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-dark">
                                        <tr>
                                            <td colspan="3" class="fw-bold text-light">Jumlah Poin : </td>
                                            <td colspan="3" class="fw-bold text-light">{{ $data['total_points'] }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="card-title text-danger">Sanksi</span>
                                </h5>
                            </div>
                            <div class="card-body table-responsive">
                                @if ($data['sanksi'])
                                    <h6>
                                        Berdasarkan total point yang diterima <span
                                            class="fw-bold">{{ $data['siswa']->siswa_nama }}</span> dan
                                        termasuk dalam kategori pelanggaran <span
                                            class="fw-bold">{{ $data['sanksi']->sanksi }}</span>
                                        ,maka ia akan dikenakan sanksi berupa <span
                                            class="fw-bold">{{ $data['sanksi']->keterangan }}.</span>
                                    </h6>
                                @else
                                    <p>Tidak ada sanksi yang sesuai.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="modalCreate" tabindex="-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/store" id="formPoint" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Data Pelanggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            <th>Pelanggaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="kelas_id" id="kelas_id"
                                            value="{{ $data['siswa']->id_kelas }}">
                                        <input type="hidden" name="siswa_id" id="siswa_id"
                                            value="{{ $data['siswa']->id }}">
                                        @foreach ($data['kriteria'] as $kriteria)
                                            <tr>
                                                <td rowspan="{{ count($kriteria->crips) + 1 }}">
                                                    {{ $kriteria->kriteria_name }}</td>
                                            </tr>
                                            @foreach ($kriteria->crips as $crip)
                                                <tr>
                                                    <td>
                                                        <div class="col">
                                                            <input name="crips_id[]" class="form-check-input"
                                                                type="checkbox" value="{{ $crip->id }}"
                                                                id="crips_{{ $crip->id }}" />
                                                            <label class="form-check-label"
                                                                for="crips_{{ $crip->id }}">{{ $crip->name }}</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" value="Simpan" class="btn btn-sm btn-primary fw-bold">Simpan</button>
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
            $('#formPoint').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let submitButton = $("button[type='submit']");
                submitButton.prop('disabled', true);

                let spinnerHtml =
                    '<div class="spinner-border text-light spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                let originalButtonHtml = submitButton.html();
                submitButton.html(spinnerHtml);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('point.store') }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // console.log(data);
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);

                        if (data['success'] === true) {
                            window.location.reload();
                        } else {
                            console.log('Error: ' + data['message']);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        console.log('An error occurred.');
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);
                    }
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
            let url = '{{ route('point.delete', 'ID') }}';
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

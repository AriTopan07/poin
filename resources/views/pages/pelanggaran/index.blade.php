@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Data Pelanggaran Siswa</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-home"
                                        aria-controls="navs-pills-justified-home" aria-selected="true"><i
                                            class="tf-icons bx bx-data me-1"></i><span class="d-none d-sm-block">
                                            Data pelanggaran</span></button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-profile"
                                        aria-controls="navs-pills-justified-profile" aria-selected="false"><i
                                            class="tf-icons bx bx-data me-1"></i><span class="d-none d-sm-block">
                                            Data pelanggaran baru</span><span
                                            class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">{{ $data['count'] }}</span></button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                                    <div class="card-header header-elements mb-4">
                                        <h5 class="card-title">Data Pelanggaran Siswa</span>
                                        </h5>
                                        <div class="card-header-elements ms-auto">
                                            @if (Auth::user()->role == 1)
                                                <button type="button" onclick="downloadData()"
                                                    class="btn btn-success btn-sm fw-bold">Download</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-striped table-hover" id="datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Pelanggaran</th>
                                                    <th>Point</th>
                                                    <th>Diinputkan Oleh</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['all'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_siswa }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->tgl)->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                                                        </td>
                                                        <td>Pelanggaran ({{ $item->nama_kriteria }}) -
                                                            {{ $item->crips_nama }}
                                                        </td>
                                                        <td>{{ $item->crips_bobot }}</td>
                                                        <td>{{ $item->user_nama }}</td>
                                                        <td>
                                                            @if ($item->verified == 1)
                                                                <span class="text-success">Terverifikasi</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                                        <div class="card-header header-elements mb-4">
                                            {{-- <div class="card-header-elements ms-auto">
                                                @if (Auth::user()->role == 1)
                                                    <button type="button" onclick="downloadData()"
                                                        class="btn btn-success btn-sm fw-bold">Download</button>
                                                @endif
                                            </div> --}}
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-striped table-hover" id="datatables2">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Pelanggaran</th>
                                                        <th>Point</th>
                                                        <th>Diinputkan Oleh</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['notVerified'] as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->nama_siswa }}</td>
                                                            <td>
                                                                {{ \Carbon\Carbon::parse($item->tgl)->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                                                            </td>
                                                            <td>Pelanggaran ({{ $item->nama_kriteria }}) -
                                                                {{ $item->crips_nama }}</td>
                                                            <td>{{ $item->crips_bobot }}</td>
                                                            <td>{{ $item->user_nama }}</td>
                                                            <td>
                                                                <a href="javascript:void(0)" class="btn btn-success btn-sm"
                                                                    onclick="verifikasi({{ $item->id_pel }})">
                                                                    Terima
                                                                </a>
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                                                                    onclick="tolak({{ $item->id_pel }})">
                                                                    Tolak
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
            </div>
        </div>
    </div>


    <div class="modal fade modal-md" id="modalCreate" tabindex="-2">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="tahun" name="tahun" required>
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    <script>
                                        const startYear = 2011;
                                        const endYear = new Date().getFullYear();
                                        for (let year = startYear; year <= endYear; year++) {
                                            document.write('<option value="' + year + '">' + year + '</option>');
                                        }
                                    </script>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary fw-bold"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="button" value="Download" onclick="confirmDownload()"
                            class="btn btn-sm btn-primary fw-bold">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        function downloadData() {
            $('#modalCreate').modal('show');
        }

        function confirmDownload() {
            let tahun = $('#tahun').val();

            if (tahun == null || tahun == "") {
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
                    text: 'Tahun belum diisi',
                });
                $('#modalCreate').modal('hide');
                return;
            }

            let url = "{{ route('download.excel', ':tahun') }}";
            url = url.replace(':tahun', tahun);

            window.location.href = url;
        }

        function verifikasi(id) {
            console.log(id);
            let url = '{{ route('pelanggaran.verif', ':id') }}';
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Verifikasi data pelanggaran ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Verifikasi'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        success: function(results) {
                            if (results.status === true) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        },
                    });
                }
            });
        }

        function tolak(id) {
            console.log(id);
            let url = '{{ route('pelanggaran.tolak', ':id') }}';
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Tolak data pelanggaran ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        success: function(results) {
                            if (results.status === true) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        },
                    });
                }
            });
        }
    </script>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Riwayat</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="card-title">Data Riwayat Input Pelanggaran Siswa</h5>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-hover" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Nama Siswa</th>
                                            <th>Pelanggaran</th>
                                            <th>Point</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['riwayat'] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- <td>{{ date('d-m-Y', strtotime($item->tgl)) }}</td> --}}
                                                <td>{{ \Carbon\Carbon::parse($item->tgl)->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                                                </td>
                                                <td>{{ $item->nama_siswa }}</td>
                                                <td>Pelanggaran ({{ $item->nama_kriteria }}) - {{ $item->crips_nama }}</td>
                                                <td>{{ $item->crips_bobot }}</td>
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
@endsection

@section('customJs')
    <script>
        function deleteData(id) {
            console.log(id);
            let url = '{{ route('kelas.delete', 'ID') }}';
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

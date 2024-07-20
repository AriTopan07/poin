<table>
    <tr>
        <td><b>Pelanggaran Siswa</b></td>
    </tr>
    <tr>
        <td>Tahun : {{ date('Y', strtotime($tahun)) }}</td>
    </tr>
</table>
<br>
<table border="1">
    <thead>
        <tr>
            <th style="text-align: center; background-color: #40c668;"><b>No</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Nama Siswa</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Tanggal</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Pelanggaran</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Point</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Diinputkan Oleh</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nama_siswa }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($item->tgl)->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                </td>
                <td>{{ $item->nama_kriteria }} {{ $item->crips_nama }}</td>
                <td>{{ $item->crips_bobot }}</td>
                <td>{{ $item->user_nama }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

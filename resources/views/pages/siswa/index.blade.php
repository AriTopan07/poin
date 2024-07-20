@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Kelas</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-md-2">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button fw-bold " data-bs-toggle="collapse"
                                        data-bs-target="#xipa" aria-expanded="true" aria-controls="xipa">
                                        Kelas X IPA
                                    </button>
                                </h2>
                                <div id="xipa" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        @foreach ($data['kelas'] as $item)
                                            @if (Str::contains($item->kelas, 'X IPA'))
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="{{ route('siswa.siswa-by-kelas', ['nama_kelas' => urlencode($item->kelas)]) }}">
                                                            <button type="button" class="btn btn-dark btn-sm fw-bold">
                                                                {{ $item->kelas }}
                                                            </button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-md-2">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button fw-bold " data-bs-toggle="collapse"
                                        data-bs-target="#xiipa" aria-expanded="true" aria-controls="xiipa">
                                        Kelas XI IPA
                                    </button>
                                </h2>
                                <div id="xiipa" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        @foreach ($data['kelas'] as $item)
                                            @if (Str::contains($item->kelas, 'XI IPA'))
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="{{ route('siswa.siswa-by-kelas', ['nama_kelas' => urlencode($item->kelas)]) }}">
                                                            <button type="button" class="btn btn-dark btn-sm fw-bold">
                                                                {{ $item->kelas }}
                                                            </button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-md-2">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button fw-bold " data-bs-toggle="collapse"
                                        data-bs-target="#xiiipa" aria-expanded="true" aria-controls="xiiipa">
                                        Kelas XII IPA
                                    </button>
                                </h2>
                                <div id="xiiipa" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        @foreach ($data['kelas'] as $item)
                                            @if (Str::contains($item->kelas, 'XII IPA'))
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="{{ route('siswa.siswa-by-kelas', ['nama_kelas' => urlencode($item->kelas)]) }}">
                                                            <button type="button" class="btn btn-dark btn-sm fw-bold">
                                                                {{ $item->kelas }}
                                                            </button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-md-2">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button fw-bold " data-bs-toggle="collapse"
                                        data-bs-target="#xips" aria-expanded="true" aria-controls="xips">
                                        Kelas X IPS
                                    </button>
                                </h2>
                                <div id="xips" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        @foreach ($data['kelas'] as $item)
                                            @if (Str::contains($item->kelas, 'X IPS'))
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="{{ route('siswa.siswa-by-kelas', ['nama_kelas' => urlencode($item->kelas)]) }}">
                                                            <button type="button" class="btn btn-dark btn-sm fw-bold">
                                                                {{ $item->kelas }}
                                                            </button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-md-2">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button fw-bold " data-bs-toggle="collapse"
                                        data-bs-target="#xiips" aria-expanded="true" aria-controls="xiips">
                                        Kelas XI IPS
                                    </button>
                                </h2>
                                <div id="xiips" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        @foreach ($data['kelas'] as $item)
                                            @if (Str::contains($item->kelas, 'XI IPS'))
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="{{ route('siswa.siswa-by-kelas', ['nama_kelas' => urlencode($item->kelas)]) }}">
                                                            <button type="button" class="btn btn-dark btn-sm fw-bold">
                                                                {{ $item->kelas }}
                                                            </button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-md-2">
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button fw-bold " data-bs-toggle="collapse"
                                        data-bs-target="#xiiips" aria-expanded="true" aria-controls="xiiips">
                                        Kelas XII IPS
                                    </button>
                                </h2>
                                <div id="xiiips" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        @foreach ($data['kelas'] as $item)
                                            @if (Str::contains($item->kelas, 'XII IPS'))
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="{{ route('siswa.siswa-by-kelas', ['nama_kelas' => urlencode($item->kelas)]) }}">
                                                            <button type="button" class="btn btn-dark btn-sm fw-bold">
                                                                {{ $item->kelas }}
                                                            </button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script></script>
@endsection

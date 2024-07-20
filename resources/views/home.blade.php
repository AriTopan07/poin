@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Selamat datang {{ Auth::user()->name }}! 🎉</h5>
                                        <p class="mb-5">
                                            semoga harimu bahagia
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body">
                                        <img src="{{ asset('backend/assets/img/illustrations/man-with-laptop-light.png') }}"
                                            height="140" alt="View Badge User"
                                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Jumlah Pelanggaran Per Kelas</h5>
                                        <div id="chart"></div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var violations = @json($data['cart']->toArray());

            // Extract categories (class names) and data (total violations) from violations array
            var categories = violations.map(function(v) {
                return v.kelas;
            });
            var data = violations.map(function(v) {
                return v.total_violations;
            });

            // Log categories and data to check if they are correctly populated
            // console.log('Categories:', categories);
            // console.log('Data:', data);

            // ApexCharts configuration
            var options = {
                chart: {
                    type: 'bar'
                },
                series: [{
                    name: 'Jumlah Pelanggaran',
                    data: data
                }],
                xaxis: {
                    categories: categories
                }
            };

            // Initialize ApexCharts
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
@endsection

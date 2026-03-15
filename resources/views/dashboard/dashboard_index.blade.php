@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Hello, {{ session('nama') }}!</h4>
                                <p class="text-muted mb-0">Anda masuk ke Anggaran Tahun <strong
                                        class="bold">{{ session('tahun_anggaran') }}</strong> dalam
                                    fase {{ session('fase_tahun_anggaran') }}
                                </p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control border-0 dash-filter-picker shadow"
                                                    data-provider="flatpickr" data-range-date="true"
                                                    data-date-format="d M, Y"
                                                    data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-auto">
                                            <button type="button"
                                                class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn shadow-none"><i
                                                    class="ri-pulse-line"></i></button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>

                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                @include('layouts.content')
            </div> <!-- end col -->



        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const ctx = document.getElementById('revenueChart');
                if (!ctx) return;

                const revenueData = @json($revenueChart ?? []);
                const expenseData = @json($expenseChart ?? []);
                const ebitdaData = @json($ebitdaChart ?? []);

                const existingChart = Chart.getChart(ctx);
                if (existingChart) existingChart.destroy();

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov',
                            'Des'
                        ],
                        datasets: [{
                                label: 'Revenue',
                                data: revenueData,
                                borderColor: '#22c55e',
                                backgroundColor: 'rgba(34,197,94,0.15)',
                                tension: 0.4,
                                fill: true,
                                borderWidth: 3
                            },
                            {
                                label: 'Expense',
                                data: expenseData,
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239,68,68,0.15)',
                                tension: 0.4,
                                fill: true,
                                borderWidth: 3
                            },
                            {
                                label: 'EBITDA',
                                data: ebitdaData,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59,130,246,0.15)',
                                tension: 0.4,
                                fill: true,
                                borderWidth: 3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

            });
        </script>
    @endpush

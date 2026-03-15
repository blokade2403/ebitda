    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard Keuangan Rumah Sakit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Crypto</a></li>
                        <li class="breadcrumb-item active">Dashboard Keuangan Rumah Sakit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xxl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="loop"
                                colors="primary:#405189,secondary:#0ab39c" style="width:55px;height:55px">
                            </lord-icon>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="badge badge-soft-warning badge-border">Target
                                Tahunan</a>
                        </div>
                    </div>
                    <h3 class="mb-2">Rp. <span>{{ number_format($targetTahunan, 0, ',', '.') }}</span><small
                            class="text-muted fs-13">,-</small></h3>
                    <h6 class="text-muted mb-0">Target Tahunan</h6>
                </div>
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-xxl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                colors="primary:#405189,secondary:#0ab39c" style="width:55px;height:55px"></lord-icon>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="badge badge-soft-info badge-border">Target Harian</a>
                        </div>
                    </div>
                    <h3 class="mb-2">Rp. <span>{{ number_format($targetHarian, 0, ',', '.') }}</span><small
                            class="text-muted fs-13">,-</small></h3>
                    <h6 class="text-muted mb-0">Target Harian</h6>
                </div>
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-xxl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop"
                                colors="primary:#405189,secondary:#0ab39c" style="width:55px;height:55px">
                            </lord-icon>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="badge badge-soft-danger badge-border">Revenue Hari
                                Ini</a>
                        </div>
                    </div>
                    <h3 class="mb-2">Rp. <span>{{ number_format($revenueToday, 0, ',', '.') }}</span><small
                            class="text-muted fs-13">,-</small></h3>
                    <h6 class="text-muted mb-0">Revenue Hari Ini</h6>
                </div>
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-xxl-3 col-md-6">
            <div class="swiper default-swiper rounded">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card card-animate">
                            <div class="card-body bg-soft-warning">
                                <div class="d-flex mb-3">
                                    <div class="flex-grow-1">
                                        <lord-icon src="https://cdn.lordicon.com/vaeagfzc.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width:55px;height:55px">
                                        </lord-icon>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);"
                                            class="badge badge-soft-primary badge-border">Ebitda</a>
                                    </div>
                                </div>
                                <h3 class="mb-2">Rp.<span
                                        class="text-muted fs-23">{{ number_format($actualEbitda, 0, ',', '.') }}</span>
                                </h3>
                                <h6 class="text-muted mb-0">Ebitda</h6>
                            </div>
                        </div><!--end card-->
                    </div>
                    <div class="swiper-slide">
                        <div class="card card-animate">
                            <div class="card-body bg-soft-warning">
                                <div class="d-flex mb-3">
                                    <div class="flex-grow-1">
                                        <lord-icon src="https://cdn.lordicon.com/vaeagfzc.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width:55px;height:55px">
                                        </lord-icon>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);" class="fw-medium">Ebitda</a>
                                    </div>
                                </div>
                                <h3 class="mb-2">Rp.<span
                                        class="text-muted fs-23">{{ number_format($ebitda, 0, ',', '.') }}</span></h3>
                                <h6 class="text-muted mb-0">Ebitda</h6>
                            </div>
                        </div><!--end card-->
                    </div>
                </div>
            </div><!--end swiper-->
        </div><!--end col-->
    </div><!--end row-->

    <div class="card" id="dashboardFinance">
        <div class="card-body pb-0">
            <div class="row g-4 mb-1">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-money-dollar-circle-fill align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium fs-12 text-muted mb-1">Total
                                        Revenue</p>
                                    <h4 class=" mb-0">Rp<span> {{ number_format($actualRevenue) }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-arrow-up-circle-fill align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium fs-12 text-muted mb-1">Total
                                        Expense</p>
                                    <h4 class=" mb-0">Rp<span> {{ number_format($actualCost) }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-arrow-down-circle-fill align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium fs-12 text-muted mb-1">EBITDA</p>
                                    <h4 class=" mb-0">Rp<span> {{ number_format($actualEbitda) }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-arrow-down-circle-fill align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium fs-12 text-muted mb-1">EBITDA Margin</p>
                                    <h4 class=" mb-0"><span> {{ number_format($actualMargin, 2) }} %</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <span class="badge badge-soft-danger"><i
                                            class="ri-arrow-down-s-fill align-middle me-1"></i>4.80
                                        %<span>
                                        </span></span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
        <!-- CARD HEADER -->
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <!-- TITLE -->
                <h5 class="card-title mb-0">
                    All Transactions
                </h5>

                <!-- FILTER -->
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="d-flex align-items-center gap-2 flex-wrap">

                        <!-- QUICK FILTER -->
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('dashboard', ['range' => 'today']) }}" class="btn btn-light">
                                Today
                            </a>
                            <a href="{{ route('dashboard', ['range' => 'week']) }}" class="btn btn-light">
                                Week
                            </a>
                            <a href="{{ route('dashboard', ['range' => 'month']) }}" class="btn btn-light">
                                Month
                            </a>
                            <a href="{{ route('dashboard', ['range' => 'year']) }}" class="btn btn-light">
                                Year
                            </a>
                        </div>

                        <!-- DATE RANGE -->
                        <input type="date" name="start_date" class="form-control form-control-sm"
                            style="width:140px" value="{{ request('start_date') }}">

                        <span class="text-muted small">-</span>

                        <input type="date" name="end_date" class="form-control form-control-sm"
                            style="width:140px" value="{{ request('end_date') }}">

                        <button class="btn btn-success btn-sm">
                            <i class="ri-filter-line"></i>
                        </button>
                        <a href="{{ route('dashboard', ['range' => 'today']) }}" class="btn btn-danger btn-sm">
                            <i class="ri-refresh-line"></i> Reset
                        </a>
                        <a href="{{ route('financePerUnit') }}" class="btn btn-info btn-sm">
                            <i class="ri-download-line"></i> Report
                        </a>
                        <a href="{{ route('financeHierarchy') }}" class="btn btn-info btn-sm">
                            <i class="ri-download-line"></i> Report Hirarki
                        </a>
                        <a href="{{ route('finance.report.download') }}" class="btn btn-success btn-sm">
                            Download Finance Report
                        </a>

                    </div>
                </form>

            </div>

            <!-- RANGE INFO -->
            <div class="text-muted small mt-2">
                Data dari
                <b>{{ request('start_date') ?? now()->format('Y-m-d') }}</b>
                sampai
                <b>{{ request('end_date') ?? now()->format('Y-m-d') }}</b>
            </div>

        </div>
        <div class="card-body">
            <div class="row g-4 mb-4">
                <div class="card-body px-3 py-2">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">

                            <thead class="table-success">
                                <tr>
                                    <th style="width:40%">Category</th>
                                    <th class="text-end">Target Tahunan</th>
                                    <th class="text-end">Target Harian</th>
                                    <th class="text-end">Plan</th>
                                    <th class="text-end">Actual</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>Pendapatan</td>
                                    <td class="text-end">{{ number_format($targetTahunan) }}</td>
                                    <td class="text-end">{{ number_format($targetRevenueDaily) }}</td>
                                    <td class="text-end">{{ number_format($planRevenue) }}</td>
                                    <td class="text-end">{{ number_format($actualRevenue) }}</td>
                                </tr>

                                <tr>
                                    <td>DOC Variable</td>
                                    <td class="text-end">{{ number_format($targetDocVariable) }}</td>
                                    <td class="text-end">{{ number_format($targetDocVariableDaily) }}</td>
                                    <td class="text-end">{{ number_format($planDocVariable) }}</td>
                                    <td class="text-end">{{ number_format($actualDocVariable) }}</td>
                                </tr>

                                <tr>
                                    <td>DOC Fixed</td>
                                    <td class="text-end">{{ number_format($targetDocFixed) }}</td>
                                    <td class="text-end">{{ number_format($targetDocFixedDaily) }}</td>
                                    <td class="text-end">{{ number_format($planDocFixed) }}</td>
                                    <td class="text-end">{{ number_format($actualDocFixed) }}</td>
                                </tr>

                                <tr>
                                    <td>IOC</td>
                                    <td class="text-end">{{ number_format($targetIoc) }}</td>
                                    <td class="text-end">{{ number_format($targetIocDaily) }}</td>
                                    <td class="text-end">{{ number_format($planIoc) }}</td>
                                    <td class="text-end">{{ number_format($actualIoc) }}</td>
                                </tr>

                                <tr class="table-warning fw-bold">
                                    <td>Total Op Cost</td>
                                    <td class="text-end">{{ number_format($targetCost) }}</td>
                                    <td class="text-end">{{ number_format($targetCostDaily) }}</td>
                                    <td class="text-end">{{ number_format($planCost) }}</td>
                                    <td class="text-end">{{ number_format($actualCost) }}</td>
                                </tr>

                                <tr class="table-success fw-bold">
                                    <td>EBITDA</td>
                                    <td class="text-end">{{ number_format($targetEbitda) }}</td>
                                    <td class="text-end">{{ number_format($targetEbitdaDaily) }}</td>
                                    <td class="text-end">{{ number_format($planEbitda) }}</td>
                                    <td class="text-end">{{ number_format($actualEbitda) }}</td>
                                </tr>

                                <tr class="table-warning fw-bold">
                                    <td>EBITDA Margin</td>
                                    <td class="text-end">{{ number_format($targetMargin, 2) }}%</td>
                                    <td class="text-end">{{ number_format($targetMarginDaily, 2) }}%</td>
                                    <td class="text-end">{{ number_format($planMargin, 2) }}%</td>
                                    <td class="text-end">{{ number_format($actualMargin, 2) }}%</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>
                <!-- Revenue vs Expense -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Revenue vs Expense</h5>
                        </div>

                        <div class="card-body">
                            <canvas id="revenueChart" height="120"></canvas>
                        </div>
                    </div>
                </div>

                <!-- EBITDA Progress -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">EBITDA Target</h5>
                        </div>

                        <div class="card-body">

                            <p class="text-muted mb-2">Progress</p>

                            <div class="progress mb-3" style="height:10px">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $targetEbitda ? ($actualEbitda / $targetEbitda) * 100 : 0 }}%">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between small">
                                <span>Actual</span>
                                <span>Target</span>
                            </div>

                            <div class="d-flex justify-content-between fw-bold">
                                <span>Rp {{ number_format($actualEbitda) }}</span>
                                <span>Rp {{ number_format($targetEbitda) }}</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CARD BODY -->

    </div>

    <div class="card" id="unitTransactionTable">
        <div class="card-header">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <!-- TITLE -->
                    <h5 class="card-title mb-0">
                        All Transactions
                    </h5>

                    <!-- FILTER -->
                    <form method="GET" action="{{ route('dashboard') }}">
                        <div class="d-flex align-items-center gap-2 flex-wrap">

                            <!-- QUICK FILTER -->
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('dashboard', ['range' => 'today']) }}" class="btn btn-light">
                                    Today
                                </a>
                                <a href="{{ route('dashboard', ['range' => 'week']) }}" class="btn btn-light">
                                    Week
                                </a>
                                <a href="{{ route('dashboard', ['range' => 'month']) }}" class="btn btn-light">
                                    Month
                                </a>
                                <a href="{{ route('dashboard', ['range' => 'year']) }}" class="btn btn-light">
                                    Year
                                </a>
                            </div>

                            <!-- DATE RANGE -->
                            <input type="date" name="start_date" class="form-control form-control-sm"
                                style="width:140px" value="{{ request('start_date') }}">

                            <span class="text-muted small">-</span>

                            <input type="date" name="end_date" class="form-control form-control-sm"
                                style="width:140px" value="{{ request('end_date') }}">

                            <button class="btn btn-success btn-sm">
                                <i class="ri-filter-line"></i>
                            </button>
                            <a href="{{ route('dashboard', ['range' => 'today']) }}" class="btn btn-danger btn-sm">
                                <i class="ri-refresh-line"></i> Reset
                            </a>
                            <a href="{{ route('financePerUnit') }}" class="btn btn-info btn-sm">
                                <i class="ri-download-line"></i> Report
                            </a>
                            <a href="{{ route('financeHierarchy') }}" class="btn btn-info btn-sm">
                                <i class="ri-download-line"></i> Report Hirarki
                            </a>
                            <a href="{{ route('finance.report.download') }}" class="btn btn-success btn-sm">
                                Download Finance Report
                            </a>

                        </div>
                    </form>

                </div>

                <!-- RANGE INFO -->
                <div class="text-muted small mt-2">
                    Data dari
                    <b>{{ request('start_date') ?? now()->format('Y-m-d') }}</b>
                    sampai
                    <b>{{ request('end_date') ?? now()->format('Y-m-d') }}</b>
                </div>

            </div>
        </div><!--end card-header-->
        <div class="card-body px-5 py-4">
            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap" id="customerTable">
                    <thead class="table-success">
                        <tr>
                            <th>Unit</th>
                            <th>Revenue</th>
                            <th>Expense</th>
                            <th>EBITDA</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($positionTree as $pos)
                            @include('dashboard.unit_row', ['pos' => $pos, 'level' => 0])
                        @endforeach

                    </tbody>

                </table><!--end table-->
                <div class="noresult" style="display: none">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                            colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                        </lord-icon>
                        <h5 class="mt-2">Sorry! No Result Found</h5>
                        <p class="text-muted mb-0">We've searched more than 150+ transactions We did not find any
                            transactions for you search.</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <div class="pagination-wrap hstack gap-2">
                    <a class="page-item pagination-prev disabled" href="#">
                        Previous
                    </a>
                    <ul class="pagination listjs-pagination mb-0"></ul>
                    <a class="page-item pagination-next" href="#">
                        Next
                    </a>
                </div>
            </div>
        </div><!--end card-body-->
    </div><!--end card-->

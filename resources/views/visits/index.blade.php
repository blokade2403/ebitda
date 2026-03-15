@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Order History</h5>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target=".bs-example-modal-lg"><i class="ri-add-line align-bottom me-1"></i> Create
                                Order</button>
                            <button type="button" class="btn btn-info"><i
                                    class="ri-file-download-line align-bottom me-1"></i> Import</button>
                        </div>
                    </div>
                </div>
                <div class="container">

                    <h4 class="mb-4">Input Patient Visit</h4>

                    {{-- FORM INPUT --}}
                    <form method="POST" action="{{ route('visits.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Layanan</label>
                                <select name="service_id" class="form-control" required>
                                    <option value="">Pilih Layanan</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->nama_layanan }} (Rp
                                            {{ number_format($service->tarif, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Jumlah Pasien</label>
                                <input type="number" name="jumlah_pasien" class="form-control" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-success w-100">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="progress animated-progress bg-soft-primary rounded-bottom rounded-0" style="height: 6px;">
                        <div class="progress-bar bg-success rounded-0" role="progressbar" style="width: 30%"
                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-info rounded-0" role="progressbar" style="width: 50%" aria-valuenow="50"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar rounded-0" role="progressbar" style="width: 20%" aria-valuenow="20"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="card-body pb-0">
                        <div class="row g-4 mb-1">
                            <div class="col-lg-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                    <i class="ri-arrow-up-circle-fill align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class=" mb-0">Total
                                                    Target Pasien<span></span>
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
                                                <p class="text-uppercase fw-medium fs-12 text-muted mb-1">Jumlah Pasien</p>
                                                <h4 class=" mb-0">{{ $sumTargetPasien }}<span></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-lg-5 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                    <i class="ri-arrow-down-circle-fill align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase fw-medium fs-12 text-muted mb-1">Total Target
                                                    Revenue</p>
                                                <h4 class=" mb-0">Rp. {{ number_format($sumRevenue, 0, ',', '.') }}<span>
                                                    </span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>
                    @include('visits.modal_add_data')
                </div>
                <div class="card-body pt-0">
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @include('visits.filter', ['routePrefix' => $routePrefix])
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped align-middle" id="example2"
                                    style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                            </th>
                                            <th width="50">No</th>
                                            <th>Tanggal</th>
                                            <th>Unit</th>
                                            <th>Layanan</th>
                                            <th>Tarif</th>
                                            <th>Jumlah Pasien</th>
                                            <th>Total</th>
                                            <th>Create</th>
                                            <th width="150">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($visits as $visit)
                                            <tr>

                                                <td>
                                                    <input type="checkbox" class="form-check-input">
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $visit->tanggal }}</td>
                                                <td>{{ $visit->unit->nama_unit ?? '-' }}</td>
                                                <td>{{ $visit->service->nama_layanan }}</td>
                                                <td>
                                                    Rp {{ number_format($visit->service->tarif, 0, ',', '.') }}
                                                </td>
                                                <td>{{ $visit->jumlah_pasien }}</td>
                                                <td>
                                                    Rp
                                                    {{ number_format($visit->jumlah_pasien * $visit->service->tarif, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    {{ $visit->created_at->format('d M Y H:i') }}
                                                </td>
                                                <td>
                                                    <!-- Action buttons (Edit/Delete) can be added here -->
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548"
                                        style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete a order ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting your order will remove
                                            all of
                                            your information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-danger" id="delete-record">Yes,
                                                Delete It</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
@endsection

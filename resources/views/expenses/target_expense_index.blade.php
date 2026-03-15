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
                                data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Create
                                Order</button>
                            <button type="button" class="btn btn-info"><i
                                    class="ri-file-download-line align-bottom me-1"></i> Import</button>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <h4 class="mb-4">Input Expense Target</h4>

                    {{-- FORM INPUT --}}
                    <form method="POST" action="{{ route('target_expenses.store') }}">
                        @csrf
                        <div class="row mb-3">

                            <div class="col-md-3">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label>Kategori</label>
                                <select name="expense_category_id" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Jumlah Target Pengeluaran</label>
                                <input type="number" step="0.01" name="jumlah" class="form-control"
                                    placeholder="Jumlah">
                            </div>

                            <div class="col-md-3">
                                <label>Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
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
                        <div class="row g-2 mb-1">
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                    <i class="ri-money-dollar-circle-fill align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h4 class=" mb-0">Total Target Expense<span> </span>
                                                </h4>
                                            </div>
                                            <div class="flex-shrink-0 align-self-end">
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-lg-6 col-md-6">
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
                                                <h4 class=" mb-0">Rp<span> {{ number_format($totalJumlah) }}</span>
                                                </h4>
                                            </div>
                                            <div class="flex-shrink-0 align-self-end">
                                                <span class="badge badge-soft-success"><i
                                                        class="ri-arrow-up-s-fill align-middle me-1"></i>3.67
                                                    %<span>
                                                    </span></span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>

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
                        @include('expenses.filter', ['routePrefix' => $routePrefix])
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
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Create</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($expenses as $rev)
                                        <tr>

                                            <td>
                                                <input type="checkbox" class="form-check-input">
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rev->tanggal }}</td>
                                            <td>{{ $rev->category->nama }}</td>
                                            <td>Rp {{ number_format($rev->jumlah, 0, ',', '.') }}</td>
                                            <td>{{ $rev->created_at }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('expenses.destroy', $rev->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

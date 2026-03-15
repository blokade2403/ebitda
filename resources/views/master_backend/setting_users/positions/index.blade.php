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
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active All py-3" data-bs-toggle="tab" id="All" href="#home1"
                                    role="tab" aria-selected="true">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> All Categories
                                </a>
                            </li>
                        </ul>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped align-middle" id="example2"
                                style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40">
                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                        </th>
                                        <th width="50">No</th>
                                        <th>Nama Jabatan</th>
                                        <th>Parent</th>
                                        <th>Unit</th>
                                        <th>Create</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($positions as $key)
                                        <tr>

                                            <td>
                                                <input type="checkbox" class="form-check-input">
                                            </td>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                <span class="text-primary">{{ $key->nama_jabatan }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $key->parent->nama_jabatan ?? 'N/A' }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-primary">{{ $key->unit->nama_unit ?? 'N/A' }}</span>
                                            </td>
                                            </td>
                                            <td>
                                                {{ $key->created_at->format('d M Y H:i') }}
                                            <td>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $key->id }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="ri-pencil-line"></i>
                                                </a>

                                                <form action="{{ route('positions.destroy', $key->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Hapus data ini?')"><i
                                                            class="ri-delete-bin-line"></i></button>
                                                </form>
                                            </td>
                                        </tr>

                                        @include('master_backend.setting_users.positions.modal_edit_data')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @include('master_backend.setting_users.positions.modal_add_data')

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



{{-- @extends('layouts.main')

@section('content')
    <div class="container">

        <h4>Tambah Position</h4>

        <form action="{{ route('positions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Jabatan</label>
                <input type="text" name="nama_jabatan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Parent Position</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- Tidak Ada --</option>
                    @foreach ($positions as $pos)
                        <option value="{{ $pos->id }}">
                            {{ $pos->nama_jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Unit</label>
                <select name="unit_id" class="form-control">
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">
                            {{ $unit->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success">Simpan</button>

        </form>
    </div>
@endsection --}}

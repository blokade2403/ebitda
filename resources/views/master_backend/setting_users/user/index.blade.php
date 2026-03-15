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
                            <table id="responsive-reorder"
                                class="table table-hover table-centered align-middle table-nowrap mb-0" id="example2"
                                style="width:100%">
                                <thead class="table-light">
                                    <tr>

                                        <th width="50">No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Jabatan</th>
                                        <th>Unit</th>
                                        <th>Role</th>
                                        <th>Create</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                <ul class="list-unstyled product-desc-list">
                                                    <li class="py-0">
                                                        <h6 class="mb-0"><span class="fa-sm text-primary"></span></strong>
                                                        </h6>
                                                    </li>
                                                    <small class="text-muted">
                                                        <span class="text-muted">Status User :
                                                            @if ($user->status_user)
                                                                <span
                                                                    class="badge badge-soft-success"><small>Active</small></span>
                                                            @else
                                                                <span
                                                                    class="badge badge-soft-danger"><small>Inactive</small></span>
                                                            @endif
                                                        </span>
                                                    </small>
                                                </ul>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/products/img-1.png') }}"
                                                        class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                                    <div class="flex-1">
                                                        <h6 class="mt-0 mb-1 fs-14">
                                                            <a href="apps-ecommerce-product-details.html"
                                                                class="text-reset">
                                                            </a>
                                                        </h6>
                                                        <p class="mb-0 fs-12 text-muted">
                                                            Username: <span>{{ $user->username }}</span></br>
                                                            <span class="text-primary">NIP: {{ $user->nip }}</span></br>
                                                            <small>ID: {{ $user->id }}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $user->nama }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-primary">{{ $user->email }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-primary">{{ $user->position->nama_jabatan ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="text-primary">{{ $user->unit->nama_unit ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-info">{{ $role->nama_role }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $user->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $user->id }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="ri-pencil-line"></i>
                                                </a>

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Hapus data ini?')"><i
                                                            class="ri-delete-bin-line"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @include('master_backend.setting_users.user.modal_edit_data')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @include('master_backend.setting_users.user.modal_add_data')


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

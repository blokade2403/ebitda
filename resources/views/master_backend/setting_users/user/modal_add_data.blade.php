<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title">Form User</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <form action="{{ route('users.store') }}" method="POST" id="add-edit-form">
                @csrf

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jabatan</label>

                            <select name="position_id" class="form-control">

                                <option value="">-- Pilih Jabatan --</option>

                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">
                                        {{ $position->nama_jabatan }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit</label>

                            <select name="unit_id" class="form-control">

                                <option value="">-- Pilih Unit --</option>

                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">
                                        {{ $unit->nama_unit }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Edit</label>

                            <select name="status_edit" class="form-control">
                                <option value="aktif">Boleh Edit</option>
                                <option value="nonaktif">Tidak Boleh Edit</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fase</label>

                            <select name="fase_id" class="form-control">

                                <option value="">-- Pilih Fase --</option>

                                @foreach ($fases as $fase)
                                    <option value="{{ $fase->id }}">
                                        {{ $fase->nama_fase }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>

                            <select name="roles[]" class="form-control" multiple>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->nama_role }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status User</label>

                            <select name="status_user" class="form-control">

                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

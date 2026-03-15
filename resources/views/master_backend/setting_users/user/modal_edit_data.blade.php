<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title">Form User</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST" id="add-edit-form">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" value="{{ $user->nip }}" class="form-control"
                                placeholder="Masukkan NIP">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" value="{{ $user->nama }}" class="form-control"
                                placeholder="Masukkan Nama" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="{{ $user->username }}" class="form-control"
                                placeholder="Masukkan Username">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                placeholder="Masukkan Email">
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
                                    <option value="{{ $position->id }}"
                                        {{ $user->position_id == $position->id ? 'selected' : '' }}>
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
                                    <option value="{{ $unit->id }}"
                                        {{ $user->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama_unit }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Edit</label>
                            <select name="status_edit" class="form-control">
                                <option value="aktif" {{ $user->status_edit == 'aktif' ? 'selected' : '' }}>Boleh Edit
                                </option>
                                <option value="nonaktif" {{ $user->status_edit == 'nonaktif' ? 'selected' : '' }}>
                                    Tidak Boleh Edit</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fase</label>

                            <select name="fase_id" class="form-control">

                                <option value="">-- Pilih Fase --</option>

                                @foreach ($fases as $fase)
                                    <option value="{{ $fase->id }}"
                                        {{ $user->fase_id == $fase->id ? 'selected' : '' }}>
                                        {{ $fase->nama_fase }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="roles[]" class="form-control" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $role->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status User</label>
                            <select name="status_user" class="form-control">
                                <option value="aktif" {{ $user->status_user == 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="nonaktif" {{ $user->status_user == 'nonaktif' ? 'selected' : '' }}>
                                    Nonaktif</option>
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

@foreach ($positions as $position)
    <div class="modal fade" id="editModal{{ $position->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title">Form User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('positions.update', $position->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Jabatan</label>
                                <input type="text" name="nama_jabatan" value="{{ $position->nama_jabatan }}"
                                    class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Unit</label>
                                <select name="unit_id" class="form-control">
                                    <option value="">-- Pilih Unit --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ $unit->id == $position->unit_id ? 'selected' : '' }}>
                                            {{ $unit->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Parent</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">-- Pilih Parent --</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos->id }}"
                                            {{ $pos->id == $position->parent_id ? 'selected' : '' }}>
                                            {{ $pos->nama_jabatan }}
                                        </option>
                                    @endforeach
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
@endforeach

<div class="card-body border-bottom-dashed border-bottom">
    <form action="{{ route($routePrefix . '.index') }}" method="GET">

        <div class="d-flex flex-wrap gap-3">

            <!-- Filter Sub Kategori RKBU -->
            <div class="flex-grow-1" style="min-width:260px;">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="flex-grow-1" style="min-width:260px;">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <!-- Filter Sub Kategori RKBU -->
            <div class="flex-grow-1" style="min-width:260px;">
                <label class="form-label">Filter by Unit</label>
                <select name="unit_id" class="form-control" data-choices data-choices-sorting="true">
                    <option value="">Semua Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status Validasi -->
            <div class="flex-grow-1" style="min-width:240px;">
                <label class="form-label">Filter by Status Validasi</label>
                <select name="service_id" class="form-control" data-choices data-choices-sorting="true">
                    <option value="">Semua Layanan</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}"
                            {{ request('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->nama_layanan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol -->
            <div class="d-flex flex-wrap gap-2 align-items-end">

                <button type="submit" class="btn btn-primary btn-label">
                    <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>
                    Filter
                </button>

                <a href="{{ url()->current() }}" class="btn btn-secondary btn-label">
                    <i class="ri-repeat-fill label-icon align-middle fs-16 me-2"></i>
                    Reset
                </a>

            </div>

        </div>

    </form>
</div>

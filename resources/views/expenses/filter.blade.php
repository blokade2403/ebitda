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

            <!-- Filter Status Validasi -->
            <div class="flex-grow-1" style="min-width:240px;">
                <label class="form-label">Filter by Status Validasi</label>
                <select name="expense_category_id" class="form-control" data-choices data-choices-sorting="true">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('expense_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}
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

<div class="modal fade" id="addTarget" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('financial-targets.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Financial Target</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- Unit --}}
                    <div class="mb-3">
                        <label>Unit</label>
                        <select name="unit_id" class="form-select" required>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div class="mb-3">
                        <label>Year</label>
                        <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label for="categoryType" class="form-label">Category Type</label>
                        <select id="categoryType" name="category_type" class="form-select">
                            <option value="revenue">Revenue</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="categorySelect" class="form-label">Category</label>
                        <select id="categorySelect" name="category_id" class="form-select">
                            <!-- options akan diisi JS -->
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="mb-3">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Target</button>
                </div>
            </form>
        </div>
    </div>
</div>

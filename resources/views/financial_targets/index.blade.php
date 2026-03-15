@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">

                        <h5 class="card-title mb-0 flex-grow-1">
                            Financial Target {{ $year }}
                        </h5>

                        <div class="flex-shrink-0">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTarget">
                                <i class="ri-add-line"></i> Add Target
                            </button>
                        </div>

                    </div>
                </div>

                <div class="card-body">
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
                                    <th width="50">No</th>
                                    <th>Unit</th>
                                    <th width="90">Year</th>
                                    <th width="120">Category</th>
                                    <th>Kelompok</th>
                                    <th class="text-end">Amount</th>
                                    <th width="160">Created</th>
                                    <th width="120" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach ($targets as $target)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $target->unit->nama_unit ?? '-' }}</td>
                                        <td>{{ $target->tahun }}</td>
                                        <td>
                                            @if ($target->category_type == 'revenue')
                                                <span class="badge bg-success">Revenue</span>
                                            @else
                                                <span class="badge bg-warning">Expense</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $target->kelompok ?? '-' }}
                                        </td>
                                        <td class="text-end">
                                            {{ number_format($target->amount) }}
                                        </td>
                                        <td>
                                            {{ $target->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="text-center">

                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $target->id }}">
                                                <i class="ri-pencil-line"></i>
                                            </button>

                                            <form action="{{ route('financial-targets.destroy', $target->id) }}"
                                                method="POST" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete target?')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                    @include('financial_targets.modal_edit')
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

        </div>
    </div>

    @include('financial_targets.modal_add')
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const categoryType = document.getElementById("categoryType");
        const categorySelect = document.getElementById("categorySelect");

        const revenueCategories = @json($revenueCategories ?? []);
        const expenseCategories = @json($expenseCategories ?? []);

        function loadCategories() {
            categorySelect.innerHTML = '';

            let data = categoryType.value === 'revenue' ? revenueCategories : expenseCategories;

            data.forEach(function(item) {
                let option = document.createElement('option');
                option.value = item.id; // tetap ID
                option.text = item.nama; // tampilkan nama untuk Revenue & Expense
                categorySelect.appendChild(option);
            });
        }

        loadCategories();

        categoryType.addEventListener('change', loadCategories);
    });
</script>

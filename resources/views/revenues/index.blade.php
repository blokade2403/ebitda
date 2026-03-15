@extends('layouts.main')

@section('content')
    <div class="container">

        <h4>Input Pendapatan Harian</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        {{-- FILTER DATA --}}
        <form method="GET" class="mb-3">
            <div class="row">

                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>

                <div class="col-md-2">
                    <select name="bulan" class="form-control">
                        <option value="">-- Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="number" name="tahun" class="form-control" placeholder="Tahun"
                        value="{{ request('tahun') }}">
                </div>

                <div class="col-md-2">
                    <select name="unit_id" class="form-control">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

            </div>
        </form>



        {{-- FORM INPUT --}}
        <form method="POST" action="{{ route('revenues.store') }}">
            @csrf

            <div class="row">

                <div class="col-md-2">
                    <input type="date" name="tanggal" class="form-control" required>
                </div>


                <div class="col-md-3">
                    <select name="revenue_category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="number" step="0.01" name="jumlah" class="form-control" placeholder="Jumlah">
                </div>

                <div class="col-md-2">
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
                </div>

                <div class="col-md-1">
                    <button class="btn btn-success">+</button>
                </div>

            </div>
        </form>


        <hr>


        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Unit</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($revenues as $rev)
                    <tr>
                        <td>{{ $rev->tanggal }}</td>
                        <td>{{ $rev->unit->nama_unit ?? '-' }}</td>
                        <td>{{ $rev->category->nama }}</td>
                        <td>Rp {{ number_format($rev->jumlah, 0, ',', '.') }}</td>

                        <td>
                            <form method="POST" action="{{ route('revenues.destroy', $rev->id) }}">
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
@endsection

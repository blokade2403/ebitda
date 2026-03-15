@extends('layouts.main')

@section('content')
    <div class="container">

        <h3>Finance Harian</h3>

        <table border="1" cellpadding="6">
            <tr>
                <th>Tanggal</th>
                <th>Layanan</th>
                <th>Pasien</th>
                <th>Tarif</th>
                <th>Revenue</th>
            </tr>

            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->service->nama_layanan }}</td>
                    <td>{{ $row->jumlah_pasien }}</td>
                    <td>{{ number_format($row->service->tarif, 0, ',', '.') }}</td>
                    <td>{{ number_format($row->revenue, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <h3>Total Revenue : Rp {{ number_format($total, 0, ',', '.') }}</h3>


    </div>
@endsection

<table border="1">

    <tr style="background:#5f8f3b;color:white;">
        <th colspan="5">Direktur</th>
    </tr>

    <tr style="background:#8bc34a">
        <th></th>
        <th>Target/Tahun</th>
        <th>Target Harian</th>
        <th>Rencana Harian</th>
        <th>Aktual Harian</th>
    </tr>

    <tr>
        <td>Pendapatan</td>
        <td>{{ $data['target']['revenue'] }}</td>
        <td>{{ $data['target']['daily'] }}</td>
        <td>{{ $data['plan']['revenue'] }}</td>
        <td>{{ $data['actual']['revenue'] }}</td>
    </tr>

    <tr>
        <td>DOC Variable</td>
        <td>{{ $data['target']['variable'] }}</td>
        <td></td>
        <td>{{ $data['plan']['variable'] }}</td>
        <td>{{ $data['actual']['variable'] }}</td>
    </tr>

    <tr>
        <td>DOC Fixed</td>
        <td>{{ $data['target']['fixed'] }}</td>
        <td></td>
        <td>{{ $data['plan']['fixed'] }}</td>
        <td>{{ $data['actual']['fixed'] }}</td>
    </tr>

    <tr>
        <td>IOC</td>
        <td>{{ $data['target']['ioc'] }}</td>
        <td></td>
        <td>{{ $data['plan']['ioc'] }}</td>
        <td>{{ $data['actual']['ioc'] }}</td>
    </tr>

    <tr style="background:#e0e0e0">
        <td>Total Op Costs</td>
        <td>{{ $data['target']['total_cost'] }}</td>
        <td></td>
        <td>{{ $data['plan']['total_cost'] }}</td>
        <td>{{ $data['actual']['total_cost'] }}</td>
    </tr>

    <tr style="background:#9ccc65">
        <td>EBITDA</td>
        <td>{{ $data['target']['ebitda'] }}</td>
        <td></td>
        <td>{{ $data['plan']['ebitda'] }}</td>
        <td>{{ $data['actual']['ebitda'] }}</td>
    </tr>

    <tr style="background:yellow">
        <td>EBITDA Margin</td>
        <td>{{ $data['target']['margin'] }}%</td>
        <td></td>
        <td>{{ $data['plan']['margin'] }}%</td>
        <td>{{ $data['actual']['margin'] }}%</td>
    </tr>

</table>

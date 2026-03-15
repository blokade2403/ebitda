<tr>

    <td style="padding-left: {{ $level * 25 }}px">

        @if (count($pos->children))
            <button class="toggle btn btn-sm btn-light">+</button>
        @endif

        {{ $pos->nama_position ?? ($pos->unit->nama_unit ?? '-') }}

    </td>

    <td class="text-end">
        {{ number_format($pos->revenue) }}
    </td>

    <td class="text-end">
        {{ number_format($pos->expense) }}
    </td>

    <td class="text-end fw-bold">
        {{ number_format($pos->ebitda) }}
    </td>

</tr>

@if (count($pos->children))

    @foreach ($pos->children as $child)
        @include('dashboard.unit_row', ['pos' => $child, 'level' => $level + 1])
    @endforeach

@endif

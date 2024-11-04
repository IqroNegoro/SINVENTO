<table>
    <thead>
        <tr>
            <td colspan="7" align="center">Warung Sembako Ibu Elis</td>
        </tr>
        <tr>
            <td colspan="7" align="center">Laporan Penjualan</td>
        </tr>
        <tr>
            <td colspan="7" align="center">Periode {{ $dates[0] }} @if($dates[0] != $dates[1]) - {{ $dates[1] }} @endif {{ $dates[2] }}</td>
        </tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td style="border: 1px solid black; background-color: #CFE3F4; font-weight: 600;" valign="center" align="center">No</td>
            <td style="border: 1px solid black; background-color: #CFE3F4; font-weight: 600;" valign="center" align="center">Tanggal</td>
            <td style="border: 1px solid black; background-color: #CFE3F4; font-weight: 600;" valign="center" align="center">Total</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
        <tr>
            <td></td>
            <td></td>
            <td style="border: 1px solid black;">
                {{ $loop->iteration }}
            </td>
            <td style="border: 1px solid black;">
                {{ $sale->created_at }}
            </td>
            <td style="border: 1px solid black;">
                {{ $sale->total }}
            </td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td style="border: 1px solid black;" align="right" valign="center" colspan="2">
                Total
            </td>
            <td style="border: 1px solid black;">
                {{ $total }}
            </td>
        </tr>
    </tbody>
</table>
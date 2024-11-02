<div style="width: 100%; display: flex; flex-direction: column; gap: 1rem; justify-items: center;">
    <h1 style="text-align: center;">Laporan Bulanan</h1>
    <table border=2 style="width: 500px; text-align: center; border-collapse: collapse; margin: 0 auto 0 auto;">
        <thead>
            <tr>
                <td>No</td>
                <td>Total</td>
                <td>Tanggal</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>
                    @currency($sale->total)
                </td>
                <td>
                    {{ $sale->created_at }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
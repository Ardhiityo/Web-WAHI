<table>
    <thead>
        <tr>
            <th style="font-weight: bold; font-size: 15px;" colspan="16">WAHI MART</th>
        </tr>
        <tr>
            <th colspan="16">Toko Warung Ayam Hj. Imas</th>
        </tr>
        <tr>
            <th colspan="16" style="border-bottom: 2px solid black"></th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th colspan="16" style="text-align: center; font-weight: bold;">
                PERIODE PENJUALAN {{ \Carbon\Carbon::parse($start_date)->locale('id')->isoFormat('DD MMMM YYYY') }}
                s/d
                {{ \Carbon\Carbon::parse($end_date)->locale('id')->isoFormat('DD MMMM YYYY') }}
            </th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th
                style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;">
                No</th>
            <th
                style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;">
                Kode Transaksi
            </th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">
                Tanggal</th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">
                Pemesan</th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">
                Sub-total</th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">Diskon</th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">Grand-total
            </th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">
                Tipe</th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">
                Status
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $key => $transaction)
            <tr>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;">
                    {{ $loop->iteration }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;">
                    {{ $transaction->transaction_code }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    colspan="2">
                    {{ $transaction->created_at->format('d/m/Y') }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    colspan="2">
                    {{ ucfirst($transaction->user->name) }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    colspan="2">
                    Rp. {{ $transaction->subtotal_amount }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    colspan="2">
                    Rp. {{ $transaction->discount }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    colspan="2">
                    Rp. {{ $transaction->total_amount }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    colspan="2">
                    {{ ucfirst($transaction->transaction_type) }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    colspan="2">
                    {{ ucfirst($transaction->transaction_status) }}</td>
            </tr>
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="11"></th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="3">Total
                Transaksi</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">Pendapatan
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="11"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="3">
                {{ $totalTransaction }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">
                Rp. {{ $profit }}</td>
        </tr>
    </tbody>
</table>

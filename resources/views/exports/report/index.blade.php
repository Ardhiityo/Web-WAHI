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
                PERIODE TRANSAKSI {{ \Carbon\Carbon::parse($start_date)->locale('id')->isoFormat('DD MMMM YYYY') }}
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
                Waktu</th>
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
            <th
                style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;">
                Tipe</th>
            <th
                style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;">
                Status
            </th>
            <th style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold;"
                colspan="2">
                Pendapatan
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $key => $transaction)
            <tr>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3">
                    {{ $loop->iteration }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3">
                    {{ $transaction->transaction_code }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3" colspan="2">
                    {{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3" colspan="2">
                    {{ ucfirst($transaction->user->name) }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3" colspan="2">
                    Rp. {{ number_format($transaction->subtotal_selling_amount, thousands_separator: '.') }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3" colspan="2">
                    Rp. {{ number_format($transaction->total_discount, thousands_separator: '.') }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3" colspan="2">
                    Rp. {{ number_format($transaction->grandtotal_selling_amount, thousands_separator: '.') }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3">
                    {{ ucfirst($transaction->transaction_type) }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3">
                    {{ ucfirst($transaction->transaction_status) }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                    rowspan="3" colspan="2">Rp.
                    {{ number_format($transaction->profit_amount, thousands_separator: '.') }}</td>
            </tr>
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr></tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="4"></th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold; vertical-align: middle;"
                colspan="2">Transaksi Terbayar
            </th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold; vertical-align: middle;"
                colspan="2">Transaksi Pending
            </th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold; vertical-align: middle;"
                colspan="2">Transaksi Cancel
            </th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold; vertical-align: middle;"
                colspan="2">Pendapatan Terbayar
            </th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold; vertical-align: middle;"
                colspan="2">Pendapatan Pending
            </th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold; vertical-align: middle;"
                colspan="2">Pendapatan Cancel
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4"></td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">
                {{ $totalTransactionSuccess }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">
                {{ $totalTransactionPending }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">
                {{ $totalTransactionCancel }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">
                Rp. {{ number_format($profitRealization, thousands_separator: '.') }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">
                Rp. {{ number_format($profitUnrealization, thousands_separator: '.') }}</td>
            <td style="border: 1px solid black; text-align: center;" colspan="2">
                Rp. {{ number_format($profitUnrealizationCancel, thousands_separator: '.') }}</td>
        </tr>
    </tbody>
</table>

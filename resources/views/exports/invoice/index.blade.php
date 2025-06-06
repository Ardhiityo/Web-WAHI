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
                INVOICE PEMBELIAN {{ $transaction->transaction_code }}
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
        <tr>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;">
                1</td>
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
        <tr></tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="7"></th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold" colspan="9">
                Rincian Produk
            </th>
        </tr>
        <tr>
            <th colspan="7"></th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;">No</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">Nama Produk</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">Brand</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">Quantity</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaction->products as $index => $product)
            <tr>
                <td colspan="7"></td>
                <td style="border: 1px solid black; text-align: center;">
                    {{ $loop->iteration }}
                </td>
                <td style="border: 1px solid black; text-align: center;" colspan="2">
                    {{ $product->name }}
                </td>
                <td style="border: 1px solid black; text-align: center;" colspan="2">
                    {{ $product->brand->name }}
                </td>
                <td style="border: 1px solid black; text-align: center;" colspan="2">
                    {{ $product->pivot->quantity }}
                </td>
                <td style="border: 1px solid black; text-align: center" colspan="2">
                    Rp.{{ number_format($product->pivot->price, thousands_separator: '.') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

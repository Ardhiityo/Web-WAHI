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
                INVOICE TRANSAKSI
            </th>
        </tr>
        <tr>
            <th colspan="16" style="text-align: center; font-weight: bold;">
                {{ $transaction->transaction_code }}
            </th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th></th>
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
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                colspan="2">
                {{ $transaction->created_at->format('d/m/Y') }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                colspan="2">
                {{ ucfirst($transaction->user->name) }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                colspan="2">
                Rp. {{ $transaction->subtotal_selling_amount }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                colspan="2">
                Rp. {{ $transaction->total_discount }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                colspan="2">
                Rp. {{ $transaction->grandtotal_selling_amount }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                colspan="2">
                {{ ucfirst($transaction->transaction_type) }}</td>
            <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"
                colspan="2">
                {{ ucfirst($transaction->transaction_status) }}</td>
            <td></td>
        </tr>
        <tr></tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="2"></th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold" colspan="12">
                Rincian Produk
            </th>
            <th colspan="2"></th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">No</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="3">Nama Produk</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="3">Brand</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">Quantity</th>
            <th style="border: 1px solid black; text-align: center; font-weight: bold;" colspan="2">Harga</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaction->products as $index => $product)
            <tr>
                <td colspan="2"></td>
                <td style="border: 1px solid black; text-align: center;" colspan="2">
                    {{ $loop->iteration }}
                </td>
                <td style="border: 1px solid black; text-align: center;" colspan="3">
                    {{ $product->name }}
                </td>
                <td style="border: 1px solid black; text-align: center;" colspan="3">
                    {{ $product->brand->name }}
                </td>
                <td style="border: 1px solid black; text-align: center;" colspan="2">
                    {{ $product->pivot->quantity }}
                </td>
                <td style="border: 1px solid black; text-align: center" colspan="2">
                    Rp.{{ number_format($product->pivot->unit_selling_price, thousands_separator: '.') }}
                </td>
                <td colspan="2"></td>
            </tr>
        @endforeach
    </tbody>
</table>

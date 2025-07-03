<table>
    <tbody>
        <tr>
            <th colspan="6" style="font-family: monospace">WARUNG AYAM HJ. IMAS</th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <td style="text-align: center; font-family: monospace;" colspan="6">*** REPORT ***</td>
        </tr>
        <tr>
            <td style="text-align: center; font-family: monospace;" colspan="6">
                {{ $transaction->created_at->translatedFormat('d F Y, H:i') }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center">
                ------------------------------------------------------------------
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-family: monospace;" colspan="6">SALES</td>
        </tr>
        <tr>
            <td style="text-align: center; font-family: monospace;" colspan="6">{{ $transaction->transaction_code }}
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-family: monospace;" colspan="6">
                {{ $transaction->customer_name }}
            </td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-family: monospace;">CUSTOMER
            </td>
            <td colspan="3" style="text-align: center; font-family: monospace; text-transform: uppercase;">
                {{ Str::limit($transaction->user->name, 10, 'XXX') }}
            </td>
        </tr>
        @foreach ($transaction->products as $product)
            <tr>
                <td colspan="3" style="text-align: center; font-family: monospace;">
                    <span style="text-transform: uppercase;">
                        {{ Str::limit($product->name, 10, 'XXX') }}
                    </span>
                    <span>
                        x{{ $product->pivot->quantity }}
                    </span>
                </td>
                <td colspan="3" style="text-align: center; font-family: monospace; text-transform: uppercase;">
                    Rp.{{ number_format($product->pivot->subtotal_selling_amount, thousands_separator: '.') }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align: center; font-family: monospace;">SUB-TOTAL
            </td>
            <td colspan="3" style="text-align: center; font-family: monospace;">
                Rp.{{ number_format($transaction->subtotal_selling_amount, thousands_separator: '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-family: monospace;">DISCOUNT
            </td>
            <td colspan="3" style="text-align: center; font-family: monospace;">
                Rp.{{ number_format($transaction->total_discount, thousands_separator: '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-family: monospace;">GRAND-TOTAL
            </td>
            <td colspan="3" style="text-align: center; font-family: monospace;">
                Rp.{{ number_format($transaction->grandtotal_selling_amount, thousands_separator: '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center">
                ------------------------------------------------------------------
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-family: monospace;" colspan="6">PAYMENT</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-family: monospace;">METHOD
            </td>
            <td colspan="3" style="text-align: center; font-family: monospace; text-transform: uppercase;">
                {{ $transaction->transaction_type }}
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-family: monospace;">STATUS
            </td>
            <td colspan="3" style="text-align: center; font-family: monospace; text-transform: uppercase;">
                {{ $transaction->transaction_status }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center">
                ------------------------------------------------------------------
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-family: monospace;" colspan="6">NOTES</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-family: monospace;">
                BARANG YANG SUDAH DIBELI TIDAK DAPAT DIKEMBALIKAN ATAU DITUKAR
            </td>
        </tr>
    </tbody>
</table>

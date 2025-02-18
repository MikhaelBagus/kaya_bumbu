<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{$transaction->code}}</title>
</head>
<body>
    <table width="100%">
        <tr class="align-top">
            <td width="75%">
                <span style="font-size: 20px">PT. KAYA BUMBU INDONESIA</span><br>
                <table style="table-layout: fixed; width: 100%; border-spacing: -2px">
                    <tr>
                        <td>Jl. Palmerah Utara IV No.12 Kec. Palmerah, Jakarta Barat,</td>
                    </tr>
                    <tr>
                        <td>Provinsi DKI Jakarta - 11480</td>
                    </tr>
                    <tr>
                        <td>Phone: 081584318441</td>
                    </tr>
                    <tr>
                        <td>Email: kayabumbujakarta@gmail.com</td>
                    </tr>
                    <tr>
                        <td>Instagram: @kayabumbujakarta</td>
                    </tr>
                </table>
            </td>
            <td width="25%" style="text-align: right;">
                <img src="{{asset('logo_kayabumbu_web.png')}}" alt="image" width="50%"><br>
                <span style="font-size: 28px">INVOICE</span><br>
                Tanggal Pengiriman:
                {{date('d F Y', strtotime($transaction->date))}}
                <br>
                No Invoice:
                {{$transaction->code}}
            </td>
        </tr>
    </table>
    <table style="width: 827px;">
        <tr style="background-color: orange;">
            <td style="color: white;"><b>Kepada</b></td>
        </tr>
        <tr>
            <td><b>{{$transaction->customer_name}}</b></td>
        </tr>
    </table>
    <br>
    <table>
        <tr style="background-color: orange;">
            <th style="color: white;">NO</th>
            <th style="width: 400px; color: white;">DESCRIPTION</th>
            <th style="width: 70px; color: white;">QTY</th>
            <th style="width: 70px; color: white;">UOM</th>
            <th colspan="2" style="width: 120px; color: white;">HARGA/PAX</th>
            <th colspan="2" style="width: 120px; color: white;">TOTAL</th>
        </tr>
        <?php $count = 0; ?>
        <?php $subtotal = 0; ?>
        @forelse($transaction->transaction_product as $detail)
        <?php $count = $count + 1; ?>
        <?php $subtotal = $subtotal + ($detail->qty * $detail->price); ?>
        <tr>
            <td style="text-align: center;">{{$count}}</td>
            <td>{{$detail->name}}</td>
            <td style="text-align: center;">{{$detail->qty}}</td>
            <td style="text-align: center;">{{$detail->unit}}</td>
            <td>Rp</td>
            <td style="text-align: right;">{{number_format($detail->price,0,',','.')}}</td>
            <td>Rp</td>
            <td style="text-align: right;">{{number_format($detail->qty * $detail->price,0,',','.')}}</td>
        </tr>
        @empty
        <tr style="border: 1px solid;">
            <td colspan="6">No Data</td>
        </tr>
        @endforelse
        <tr>
            <td colspan="4"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>Rp</td>
            <td style="text-align: right;">{{number_format($subtotal,0,',','.')}}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="2">Diskon</td>
            <td>Rp</td>
            <td style="text-align: right;">{{number_format($transaction->discount_price,0,',','.')}}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="2">Ongkir</td>
            <td>Rp</td>
            <td style="text-align: right;">{{number_format($transaction->ongkir_price,0,',','.')}}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="2"><b>TOTAL</b></td>
            <td>Rp</td>
            <td style="text-align: right;"><b>{{number_format($transaction->grand_price,0,',','.')}}</b></td>
        </tr>
    </table>
    <br>Syarat & Ketentuan :                            
    <br>-   Pembayaran dilakukan pada saat pemesanan sudah dikonfirmasi dengan jelas oleh Pihak Kaya Bumbu.
    <br><b>-   Pembayaran dapat dilakukan dengan cara TRANSFER Ke BCA a/n DANIEL SIDARTA  012 043 1293</b>
    <br>-   Tidak ada pengembalian uang apabila ada pembatalan sepihak oleh Customer.
    <br>-   Harap memberi kabar kepada kami setelah melakukan Pembayaran.
    <table width="100%">
        <tr class="align-top">
            <td width="34%">
                <table style="table-layout: fixed; width: 100%; border-spacing: -2px">
                    
                </table>
            </td>
            <td width="33%" style="text-align: right;">
                Hormat Kami,
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                PT. KAYA BUMBU INDONESIA
            </td>
        </tr>
    </table>
</body>
</html>
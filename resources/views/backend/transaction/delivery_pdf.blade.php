<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delivery {{$transaction->code}}</title>
</head>
<body>
    <table width="100%">
        <tr style="text-align: right;">
            <img src="{{asset('logo_kayabumbu_web.png')}}" alt="image" width="20%">
        </tr>
        <tr class="align-top">
            <td width="40%">
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
            <td width="40%" style="text-align: right;">
                <span style="font-size: 32px">DELIVERY ORDER</span><br>
                Delivery Date:
                {{date('d F Y', strtotime($transaction->date))}}
                <br>
                Delivery Time:
                ___________
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>Nama: {{$transaction->recipient_name}}</td>
        </tr>
        <tr>
            <td>No Kontak: {{$transaction->recipient_phone}}</td>
        </tr>
        <tr>
            <td>Alamat Kirim: {{$transaction->address}}</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <th>NO</th>
            <th style="width: 400px;">NAMA BARANG</th>
            <th style="width: 70px;">QTY</th>
            <th style="width: 70px;">UNIT</th>
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
        </tr>
        @empty
        <tr style="border: 1px solid;">
            <td colspan="4">No Data</td>
        </tr>
        @endforelse
    </table>
    <table width="100%">
        <tr class="align-top">
            <td width="33%" style="text-align: center;">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                (................................)
                <br>
                Pengantar
            </td>
            <td width="33%" style="text-align: center;">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                (................................)
                <br>
                Penerima
            </td>
            <td width="33%" style="border: solid 1px; vertical-align: top;">
                CATATAN
            </td>
        </tr>
    </table>
    <br>                          
    <br>* Barang sudah diterima dalam keadaan baik & jumlah yang benar
    <br>* Apabila barang sudah diterima, kerusakan / kehilangan bukan tanggung jawab kami
    <br>
    <br>
</body>
</html>
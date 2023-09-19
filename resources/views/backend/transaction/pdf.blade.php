<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaction {{$transaction->code}}</title>
</head>
<body>
    <br>Admin: {{$transaction->user->name}}
    <br>Tanggal pengiriman: {{date('d M Y', strtotime($transaction->date))}}
    <br>Jam pengiriman: {{$transaction->time}}
    <br>
    <br>Nama pemesan: {{$transaction->customer->name}}
    <br>No.HP pemesan: {{$transaction->customer->phone}}
    <br>Nama penerima: {{$transaction->recipient_name}}
    <br>No.HP penerima: {{$transaction->recipient_phone}}
    <br>
    <br>Alamat Lengkap: {{$transaction->address}}
    <br>Jenis kendaraan: {{$transaction->delivery_transport}}
    <br>Harga Ongkir Driver: Rp {{number_format($transaction->actual_ongkir_price,0,',','.')}}
    <br>Jenis pengiriman: {{$transaction->delivery_type}}
    <br>
    <br>Pesanan: 
    <br>@forelse($transaction->transaction_product as $detail)
    - {{$detail->name}} | {{$detail->qty}} {{$detail->unit}} @if($detail->notes != null) ({{$detail->notes}}) @endif<br>
    @empty
    -
    @endforelse
    <br>Notes: @if($transaction->notes == null)
    -
    @else
    {{$transaction->notes}}
    @endif
    <br>
    <br>
    <hr>
</body>
</html>
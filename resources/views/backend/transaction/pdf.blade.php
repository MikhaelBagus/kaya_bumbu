<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaction {{$transaction->code}}</title>
</head>
<body>
    Admin: {{$transaction->user->name}}
    <br>Tanggal pengiriman: {{date('d/m/Y', strtotime($transaction->date))}}
    <br>Jam pengiriman: {{$transaction->time}}
    <br>
    <br>Nama penerima: {{$transaction->recipient_name}}
    <br>No.HP penerima: {{$transaction->recipient_phone}}
    <br>
    <br>Alamat Lengkap: {{$transaction->address}}
    <br>Pengiriman menggunakan: {{$transaction->delivery_option}}
    <br>Jenis kendaraan: {{$transaction->delivery_transport}}
    <br>Jenis pengiriman: {{$transaction->delivery_type}}
    <br>
    <br>Pesanan: 
    <br>@forelse($transaction->transaction_product as $detail)
    - {{$detail->name}} | {{$detail->qty}} {{$detail->unit}} ({{$detail->notes}})<br>
    @empty
    -
    @endforelse
    <br>Notes: @if($transaction->notes == null)
    -
    @else
    {{$transaction->notes}}
    @endif
</body>
</html>
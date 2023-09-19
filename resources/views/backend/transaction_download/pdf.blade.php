<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaction from {{$request->order_date_from}} to {{$request->order_date_to}}</title>
</head>
<body>
    <?php $no = 0; ?>
    @forelse($transaction as $transactionEach)
        <?php $no = $no + 1; ?>
        <br>No: {{$no}}
        <br>Transaction Code: {{$transactionEach->code}}
        <br>Admin: {{$transactionEach->user->name}}
        <br>Tanggal pengiriman: {{date('d/m/Y', strtotime($transactionEach->date))}}
        <br>Jam pengiriman: {{$transactionEach->time}}
        <br>
        <br>Nama pemesan: {{$transactionEach->customer->name}}
        <br>No.HP pemesan: {{$transactionEach->customer->phone}}
        <br>Nama penerima: {{$transactionEach->recipient_name}}
        <br>No.HP penerima: {{$transactionEach->recipient_phone}}
        <br>
        <br>Alamat Lengkap: {{$transactionEach->address}}
        <br>Pengiriman menggunakan: {{$transactionEach->delivery_option}}
        <br>Jenis kendaraan: {{$transactionEach->delivery_transport}}
        <br>Jenis pengiriman: {{$transactionEach->delivery_type}}
        <br>
        <br>Pesanan: 
        <br>@forelse($transactionEach->transaction_product as $detail)
        - {{$detail->name}} | {{$detail->qty}} {{$detail->unit}} @if($detail->notes != null) ({{$detail->notes}}) @endif<br>
        @empty
        -
        @endforelse
        <br>Notes: @if($transactionEach->notes == null)
        -
        @else
        {{$transactionEach->notes}}
        @endif
        <br>
        <br>
        <hr>
    @empty
        Tidak ada transaksi
    @endforelse
</body>
</html>
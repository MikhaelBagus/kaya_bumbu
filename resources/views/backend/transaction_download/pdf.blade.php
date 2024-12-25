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
        <br>Tanggal: {{date('d M Y', strtotime($transactionEach->date))}}
        <br>Jam: {{$transactionEach->time}} ({{$transactionEach->user->name}})
        <br>
        <br>Pemesan: {{$transactionEach->customer->name}} ({{$transactionEach->customer->phone}})
        <br>Penerima: {{$transactionEach->recipient_name}} ({{$transactionEach->recipient_phone}})
        <br>
        @if($transactionEach->actual_ongkir_price == 0)
        <br>({{$transactionEach->delivery_transport}}) {{$transactionEach->address}}
        @else
        <br>({{$transactionEach->delivery_transport}} + Rp {{number_format($transactionEach->actual_ongkir_price,0,',','.')}}) {{$transactionEach->address}}
        @endif
        <br>
        <br>Pesanan: 
        <br>@forelse($transactionEach->transaction_product as $detail)
        - {{$detail->qty}} {{$detail->unit}} {{$detail->name}} | @if($detail->notes != null) <p style="background-color:yellow;">({{$detail->notes}})</p> @endif<br>
        @empty
        -
        @endforelse
        <br>Notes: @if($transactionEach->notes == null)
        -
        @else
        <p style="background-color:yellow;">{{$transactionEach->notes}}</p>
        @endif
        <br>
        <br>
        <hr>
    @empty
        Tidak ada transaksi
    @endforelse
</body>
</html>
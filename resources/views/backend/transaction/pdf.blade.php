<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaction {{$transaction->code}}</title>
</head>
<body>
    <br>Tanggal: {{date('d M Y', strtotime($transaction->date))}}
    <br>Jam: {{$transaction->time}} ({{$transaction->user->name}})
    <br>
    <br>Pemesan: {{$transaction->customer->name}} ({{$transaction->customer->phone}})
    <br>Penerima: {{$transaction->recipient_name}} ({{$transaction->recipient_phone}})
    <br>
    @if($transaction->actual_ongkir_price == 0)
    <br>({{$transaction->delivery_transport}}) {{$transaction->address}}
    @else
    <br>({{$transaction->delivery_transport}} + Rp {{number_format($transaction->actual_ongkir_price,0,',','.')}}) {{$transaction->address}}
    @endif
    <br>
    <br>Pesanan: 
    <br>@forelse($transaction->transaction_product as $detail)
    - {{$detail->qty}} {{$detail->unit}} {{$detail->name}} | @if($detail->notes != null) <p style="background-color:yellow;">({{$detail->notes}})</p> @endif<br>
    @empty
    -
    @endforelse
    <br>Notes: @if($transaction->notes == null)
    -
    @else
    <p style="background-color:yellow;">{{$transaction->notes}}</p>
    @endif
    <br>
    <br>
    <hr>
</body>
</html>
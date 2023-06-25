@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Transaction Detail
                    <div class="pull-right">
                        <a href="{{route('transaction.pdf', [$transaction->id])}}" class="btn btn-warning btn-sm">PDF</a>
                        <a href="{{route('transaction.invoice', [$transaction->id])}}" class="btn btn-warning btn-sm">Invoice</a>
                        <a href="{{route('transaction.delivery_pdf', [$transaction->id])}}" class="btn btn-warning btn-sm">Delivery PDF</a>
                    </div>                    
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$transaction->id}}
                        </dd>
                        <dt class="text-left">
                            Code
                        </dt>
                        <dd>
                            : {{$transaction->code}}
                        </dd>
                        <dt class="text-left">
                            Tipe Transaksi
                        </dt>
                        <dd>
                            : {{$transaction->transaction_type}}
                        </dd>
                        <dt class="text-left">
                            Status
                        </dt>
                        <dd>
                            : @if($transaction->status == 0)
                            New Order
                            @elseif($transaction->status == 1)
                            Start Cooking
                            @elseif($transaction->status == 2)
                            Start Delivery
                            @elseif($transaction->status == 3)
                            Done
                            @endif
                        </dd>
                        <dt class="text-left">
                            Tanggal Pengiriman
                        </dt>
                        <dd>
                            : {{$transaction->date}} {{$transaction->time}}
                        </dd>
                        <dt class="text-left">
                            Status Pembayaran
                        </dt>
                        <dd>
                            : @if($transaction->payment_status == 0)
                            Pending
                            @elseif($transaction->payment_status == 1)
                            Done
                            @endif
                        </dd>
                        <dt class="text-left">
                            Bukti Transfer Url
                        </dt>
                        <dd>
                            : @if($transaction->payment_bukti_transfer_url != '')<a href="{{asset($transaction->payment_bukti_transfer_url)}}">{{asset($transaction->payment_bukti_transfer_url)}}</a>@endif
                        </dd>
                        <dt class="text-left">
                            Bank
                        </dt>
                        <dd>
                            : {{$transaction->bank->bank_name}} {{$transaction->bank->account_number}} a\n {{$transaction->bank->account_name}}
                        </dd>
                        <dt class="text-left">
                            Sumber
                        </dt>
                        <dd>
                            : {{$transaction->source->name}}
                        </dd>
                        <dt class="text-left">
                            Pengiriman Menggunakan
                        </dt>
                        <dd>
                            : {{$transaction->delivery_option}}
                        </dd>
                        <dt class="text-left">
                            Jenis Kendaraan
                        </dt>
                        <dd>
                            : {{$transaction->delivery_transport}}
                        </dd>
                        <dt class="text-left">
                            Jenis Pengiriman
                        </dt>
                        <dd>
                            : {{$transaction->delivery_type}}
                        </dd>
                        <dt class="text-left">
                            Notes
                        </dt>
                        <dd>
                            : {{$transaction->notes}}
                        </dd>
                        <dt class="text-left">
                            Phone Pemesan
                        </dt>
                        <dd>
                            : {{$transaction->customer_phone}}
                        </dd>
                        <dt class="text-left">
                            Nama Pemesan
                        </dt>
                        <dd>
                            : {{$transaction->customer_name}}
                        </dd>
                        <dt class="text-left">
                            Phone Penerima
                        </dt>
                        <dd>
                            : {{$transaction->recipient_phone}}
                        </dd>
                        <dt class="text-left">
                            Nama Penerima
                        </dt>
                        <dd>
                            : {{$transaction->recipient_name}}
                        </dd>
                        <dt class="text-left">
                            Provinsi
                        </dt>
                        <dd>
                            : {{$transaction->city->province->name}}
                        </dd>
                        <dt class="text-left">
                            Kota
                        </dt>
                        <dd>
                            : {{$transaction->city->name}}
                        </dd>
                        <dt class="text-left">
                            Alamat
                        </dt>
                        <dd>
                            : {{$transaction->address}}
                        </dd>
                        <dt class="text-left">
                            Harga Ongkir Customer
                        </dt>
                        <dd>
                            : Rp {{number_format($transaction->ongkir_price,0,',','.')}}
                        </dd>
                        <dt class="text-left">
                            Harga Ongkir Driver
                        </dt>
                        <dd>
                            : Rp {{number_format($transaction->actual_ongkir_price,0,',','.')}}
                        </dd>
                        <dt class="text-left">
                            Tanda Terima Url
                        </dt>
                        <dd>
                            : @if($transaction->tanda_terima_url != '')<a href="{{asset($transaction->tanda_terima_url)}}">{{asset($transaction->tanda_terima_url)}}</a>@endif
                        </dd>
                        <dt class="text-left">
                            Mulai Masak
                        </dt>
                        <dd>
                            : {{$transaction->start_cooking_at}}
                        </dd>
                        <dt class="text-left">
                            Mulai Masak Oleh
                        </dt>
                        <dd>
                            : {{$transaction->start_cooking_by}}
                        </dd>
                        <dt class="text-left">
                            Mulai Pengantaran
                        </dt>
                        <dd>
                            : {{$transaction->start_delivery_at}}
                        </dd>
                        <dt class="text-left">
                            Mulai Pengantaran Oleh
                        </dt>
                        <dd>
                            : {{$transaction->start_delivery_by}}
                        </dd>
                        <dt class="text-left">
                            Selesai Pengantaran
                        </dt>
                        <dd>
                            : {{$transaction->end_delivery_at}}
                        </dd>
                        <dt class="text-left">
                            Selesai Pengantaran Oleh
                        </dt>
                        <dd>
                            : {{$transaction->end_delivery_by}}
                        </dd>
                        <dt class="text-left">
                            Driver
                        </dt>
                        <dd>
                            : @if($transaction->driver)
                            {{$transaction->driver->name}}
                            @endif
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>

                <table class="table table-striped table-bordered table-hover table-condensed" id="transaction-product-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Notes</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @forelse($transaction->transaction_product as $transactionProduct)
                        <?php $no = $no + 1; ?>
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$transactionProduct->name}}</td>
                            <td>Rp {{number_format($transactionProduct->price,0,',','.')}}</td>
                            <td>{{number_format($transactionProduct->qty,0,',','.')}}</td>
                            <td>{{$transactionProduct->unit}}</td>
                            <td>{{$transactionProduct->notes}}</td>
                            <td>Rp {{number_format($transactionProduct->price * $transactionProduct->qty,0,',','.')}}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-right">
                                Harga Total :
                            </th>
                            <th colspan="1" class="text-left"><span id="totalPrice"><strong>Rp {{number_format($transaction->grand_price + $transaction->discount,0,',','.')}}</strong></span></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right">
                                Harga Discount :
                            </th>
                            <th colspan="1" class="text-left"><span id="discountPrice"><strong>Rp {{number_format($transaction->discount_price,0,',','.')}}</strong></span></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right">
                                Harga Ongkir :
                            </th>
                            <th colspan="1" class="text-left"><span id="ongkirPrice"><strong>Rp {{number_format($transaction->ongkir_price,0,',','.')}}</strong></span></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right">
                                Harga Grand Total :
                            </th>
                            <th colspan="1" class="text-left"><span id="grandPrice"><strong>Rp {{number_format($transaction->grand_price,0,',','.')}}</strong></span></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="panel-footer">
                <a href="{{route('transaction.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    @if($transaction->status == 0)
                    <a href="#" data-message="Mulai Masak {{$transaction->code}} ?" data-href="{{route('transaction.update_start_cooking', [$transaction->id])}}" id="tooltip" data-method="PUT" data-title="Mulai Masak {{$transaction->code}} ?" data-title-modal="Mulai Masak {{$transaction->code}} ?" data-toggle="modal" data-target="#delete" title="Mulai Masak {{$transaction->code}} ?" class="btn btn-success btn-sm">Mulai Masak</a>
                    @elseif($transaction->status == 1)
                    <a href="#" data-message="Mulai Pengiriman {{$transaction->code}} ?" data-href="{{route('transaction.update_start_delivery', [$transaction->id])}}" id="tooltip" data-method="PUT" data-title="Mulai Pengiriman {{$transaction->code}} ?" data-title-modal="Mulai Pengiriman {{$transaction->code}} ?" data-toggle="modal" data-target="#delete" title="Mulai Pengiriman {{$transaction->code}} ?" class="btn btn-success btn-sm">Mulai Pengiriman</a>
                    @elseif($transaction->status == 2)
                    <a href="{{route('transaction.edit_end_delivery', [$dataDb->id])}}" class="btn btn-success btn-sm">Selesai Pengiriman</a>
                    @endif
                    @if($transaction->payment_status == 0)
                    <a href="{{route('transaction.edit_actual_ongkir_price', [$transaction->id])}}" class="btn btn-warning btn-sm">Actual Ongkir Driver</a>
                    @endif
                    <a href="{{route('transaction.edit_payment_status', [$transaction->id])}}" class="btn btn-warning btn-sm">Status Pembayaran</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
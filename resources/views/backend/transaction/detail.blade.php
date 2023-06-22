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
                            Status
                        </dt>
                        <dd>
                            : @if($transaction->status == 0)
                            New Order
                            @elseif($transaction->status == 1)
                            Start Cooking
                            @elseif($transaction->status == 2)
                            End Cooking
                            @elseif($transaction->status == 3)
                            Start Delivery
                            @elseif($transaction->status == 4)
                            Done
                            @endif
                        </dd>
                        <dt class="text-left">
                            Date
                        </dt>
                        <dd>
                            : {{$transaction->date}} {{$transaction->time}}
                        </dd>
                        <dt class="text-left">
                            Payment Status
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
                            Source
                        </dt>
                        <dd>
                            : {{$transaction->source->name}}
                        </dd>
                        <dt class="text-left">
                            Delivery Option
                        </dt>
                        <dd>
                            : {{$transaction->delivery_option}}
                        </dd>
                        <dt class="text-left">
                            Delivery Transport
                        </dt>
                        <dd>
                            : {{$transaction->delivery_transport}}
                        </dd>
                        <dt class="text-left">
                            Delivery Type
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
                            Customer Phone
                        </dt>
                        <dd>
                            : {{$transaction->customer_phone}}
                        </dd>
                        <dt class="text-left">
                            Customer Name
                        </dt>
                        <dd>
                            : {{$transaction->customer_name}}
                        </dd>
                        <dt class="text-left">
                            Recipient Phone
                        </dt>
                        <dd>
                            : {{$transaction->recipient_phone}}
                        </dd>
                        <dt class="text-left">
                            Recipient Name
                        </dt>
                        <dd>
                            : {{$transaction->recipient_name}}
                        </dd>
                        <dt class="text-left">
                            Province
                        </dt>
                        <dd>
                            : {{$transaction->city->province->name}}
                        </dd>
                        <dt class="text-left">
                            City
                        </dt>
                        <dd>
                            : {{$transaction->city->name}}
                        </dd>
                        <dt class="text-left">
                            Address
                        </dt>
                        <dd>
                            : {{$transaction->address}}
                        </dd>
                        <dt class="text-left">
                            Ongkir Customer Price
                        </dt>
                        <dd>
                            : Rp {{number_format($transaction->ongkir_price,0,',','.')}}
                        </dd>
                        <dt class="text-left">
                            Ongkir Driver Price
                        </dt>
                        <dd>
                            : Rp {{number_format($transaction->ongkir_driver_price,0,',','.')}}
                        </dd>
                        <dt class="text-left">
                            Actual Ongkir Price
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
                            Start Cooking At
                        </dt>
                        <dd>
                            : {{$transaction->start_cooking_at}}
                        </dd>
                        <dt class="text-left">
                            Start Cooking By
                        </dt>
                        <dd>
                            : {{$transaction->start_cooking_by}}
                        </dd>
                        <dt class="text-left">
                            End Cooking At
                        </dt>
                        <dd>
                            : {{$transaction->end_cooking_at}}
                        </dd>
                        <dt class="text-left">
                            End Cooking By
                        </dt>
                        <dd>
                            : {{$transaction->end_cooking_by}}
                        </dd>
                        <dt class="text-left">
                            Start Delivery At
                        </dt>
                        <dd>
                            : {{$transaction->start_delivery_at}}
                        </dd>
                        <dt class="text-left">
                            Start Delivery By
                        </dt>
                        <dd>
                            : {{$transaction->start_delivery_by}}
                        </dd>
                        <dt class="text-left">
                            End Delivery At
                        </dt>
                        <dd>
                            : {{$transaction->end_delivery_at}}
                        </dd>
                        <dt class="text-left">
                            End Delivery By
                        </dt>
                        <dd>
                            : {{$transaction->end_delivery_by}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>

                <table class="table table-striped table-bordered table-hover table-condensed" id="transaction-product-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Notes</th>
                            <th>Total Price</th>
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
                                Total Price :
                            </th>
                            <th colspan="1" class="text-left"><span id="totalPrice"><strong>Rp {{number_format($transaction->grand_price + $transaction->discount,0,',','.')}}</strong></span></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right">
                                Discount Price :
                            </th>
                            <th colspan="1" class="text-left"><span id="discountPrice"><strong>Rp {{number_format($transaction->discount_price,0,',','.')}}</strong></span></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right">
                                Ongkir Price :
                            </th>
                            <th colspan="1" class="text-left"><span id="ongkirPrice"><strong>Rp {{number_format($transaction->ongkir_price,0,',','.')}}</strong></span></th>
                        </tr>
                        <tr>
                            <th colspan="6" class="text-right">
                                Grand Price :
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
                    <a href="#" data-message="Start Cooking {{$transaction->code}} ?" data-href="{{route('transaction.update_start_cooking', [$transaction->id])}}" id="tooltip" data-method="PUT" data-title="Start Cooking {{$transaction->code}} ?" data-title-modal="Start Cooking {{$transaction->code}} ?" data-toggle="modal" data-target="#delete" title="Start Cooking {{$transaction->code}} ?" class="btn btn-success btn-sm">Start Cooking</a>
                    @elseif($transaction->status == 1)
                    <a href="#" data-message="End Cooking {{$transaction->code}} ?" data-href="{{route('transaction.update_end_cooking', [$transaction->id])}}" id="tooltip" data-method="PUT" data-title="End Cooking {{$transaction->code}} ?" data-title-modal="End Cooking {{$transaction->code}} ?" data-toggle="modal" data-target="#delete" title="End Cooking {{$transaction->code}} ?" class="btn btn-success btn-sm">End Cooking</a>
                    @elseif($transaction->status == 2)
                    <a href="#" data-message="Start Delivery {{$transaction->code}} ?" data-href="{{route('transaction.update_start_delivery', [$transaction->id])}}" id="tooltip" data-method="PUT" data-title="Start Delivery {{$transaction->code}} ?" data-title-modal="Start Delivery {{$transaction->code}} ?" data-toggle="modal" data-target="#delete" title="Start Delivery {{$transaction->code}} ?" class="btn btn-success btn-sm">Start Delivery</a>
                    @elseif($transaction->status == 3)
                    <a href="{{route('transaction.edit_end_delivery', [$dataDb->id])}}" class="btn btn-success btn-sm">End Delivery</a>
                    @endif
                    @if($transaction->payment_status == 0)
                    <a href="{{route('transaction.edit_actual_ongkir_price', [$transaction->id])}}" class="btn btn-warning btn-sm">Actual Ongkir</a>
                    @endif
                    <a href="{{route('transaction.edit_payment_status', [$transaction->id])}}" class="btn btn-warning btn-sm">Payment Status</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Transaction Detail
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
                            Date
                        </dt>
                        <dd>
                            : {{$transaction->date}}
                        </dd>
                        <dt class="text-left">
                            Status
                        </dt>
                        <dd>
                            : {{$transaction->status}}
                        </dd>
                        <dt class="text-left">
                            Customer Name
                        </dt>
                        <dd>
                            : {{$transaction->customer->name}}
                        </dd>
                        <dt class="text-left">
                            Customer Phone
                        </dt>
                        <dd>
                            : {{$transaction->customer->phone}}
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
                            Actual Ongkir Price
                        </dt>
                        <dd>
                            : Rp {{number_format($transaction->actual_ongkir_price,0,',','.')}}
                        </dd>
                        <dt class="text-left">
                            Tanda Terima Url
                        </dt>
                        <dd>
                            : <a href="{{$transaction->tanda_terima_url}}">{{$transaction->tanda_terima_url}}</a>
                        </dd>
                        <dt class="text-left">
                            Start Cooking At
                        </dt>
                        <dd>
                            : {{$transaction->start_cooking_at}}
                        </dd>
                        <dt class="text-left">
                            End Cooking At
                        </dt>
                        <dd>
                            : {{$transaction->end_cooking_at}}
                        </dd>
                        <dt class="text-left">
                            Start Delivery At
                        </dt>
                        <dd>
                            : {{$transaction->start_delivery_at}}
                        </dd>
                        <dt class="text-left">
                            End Delivery At
                        </dt>
                        <dd>
                            : {{$transaction->end_delivery_at}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>

                <table class="table table-striped table-bordered table-hover table-condensed" id="transaction-product-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @forelse($transaction->transaction_product as $transactionProduct)
                        <?php $no = $no + 1; ?>
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$transactionProduct->product->code}}</td>
                            <td>{{$transactionProduct->product->name}}</td>
                            <td>Rp {{number_format($transactionProduct->price,0,',','.')}}</td>
                            <td>{{number_format($transactionProduct->qty,0,',','.')}}</td>
                            <td>{{$transactionProduct->product->unit}}</td>
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
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
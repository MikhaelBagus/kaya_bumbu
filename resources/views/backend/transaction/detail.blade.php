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
                            Discount
                        </dt>
                        <dd>
                            : Rp {{number_format($transaction->discount,0,',','.')}}
                        </dd>
                        <dt class="text-left">
                            Grand Price
                        </dt>
                        <dd>
                            : Rp {{number_format($transaction->grand_price,0,',','.')}}
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
                            <td>Rp {{number_format($transactionProduct->price * $transactionProduct->price,0,',','.'}}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
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
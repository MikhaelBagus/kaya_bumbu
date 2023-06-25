@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Driver Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$driver->id}}
                        </dd>
                        <dt class="text-left">
                            Name
                        </dt>
                        <dd>
                            : {{$driver->name}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
                <table class="table table-striped table-bordered table-hover table-condensed" id="transaction-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Recipient Name</th>
                            <th>Recipient Phone</th>
                            <th>Address</th>
                            <th>Delivery Option</th>
                            <th>Delivery Transport</th>
                            <th>Delivery Type</th>
                            <th>Ongkir Price</th>
                            <th>Actual Ongkir Price</th>
                            <th>Grand Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @forelse($driver->transaction->sortByDesc('date') as $transaction)
                        <?php $no = $no + 1; ?>
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$transaction->date}}</td>
                            <td>{{$transaction->time}}</td>
                            <td>{{$transaction->recipient_name}}</td>
                            <td>{{$transaction->recipient_phone}}</td>
                            <td>{{$transaction->address}}</td>
                            <td>{{$transaction->delivery_option}}</td>
                            <td>{{$transaction->delivery_transport}}</td>
                            <td>{{$transaction->delivery_type}}</td>
                            <td>Rp {{number_format($transaction->ongkir_price,0,',','.')}}</td>
                            <td>Rp {{number_format($transaction->actual_ongkir_price,0,',','.')}}</td>
                            <td>Rp {{number_format($transaction->grand_price,0,',','.')}}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                <a href="{{route('driver.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('driver.edit', [$driver->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
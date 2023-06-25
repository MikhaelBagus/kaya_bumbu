@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Customer Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$customer->id}}
                        </dd>
                        <dt class="text-left">
                            Name
                        </dt>
                        <dd>
                            : {{$customer->name}}
                        </dd>
                        <dt class="text-left">
                            Phone
                        </dt>
                        <dd>
                            : {{$customer->phone}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>

                <table class="table table-striped table-bordered table-hover table-condensed" id="transaction-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Admin</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Detail Pesanan</th>
                            <th>Transaction Type</th>
                            <th>Recipient Name</th>
                            <th>Recipient Phone</th>
                            <th>Address</th>
                            <th>Delivery Option</th>
                            <th>Delivery Transport</th>
                            <th>Delivery Type</th>
                            <th>Payment Status</th>
                            <th>Notes</th>
                            <th>Grand Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @forelse($customer->transaction->sortByDesc('date') as $transaction)
                        <?php $no = $no + 1; ?>
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$transaction->user->name}}</td>
                            <td>{{$transaction->date}}</td>
                            <td>{{$transaction->time}}</td>
                            <td>
                                <?php $transaction_detail = ''; ?>
                                @foreach($transaction->transaction_product as $detail)
                                    @if($transaction_detail == '')
                                        @if($detail->notes != null)
                                            <?php $transaction_detail = '- '.$detail->name.' | '.$detail->qty.' '.$detail->unit.' ('.$detail->notes.')'; ?>
                                        @else
                                            <?php $transaction_detail = '- '.$detail->name.' | '.$detail->qty.' '.$detail->unit; ?>
                                        @endif
                                    @else
                                        @if($detail->notes != null)
                                            <?php $transaction_detail = $transaction_detail.'<br>- '.$detail->name.' | '.$detail->qty.' '.$detail->unit.' ('.$detail->notes.')'; ?>
                                        @else
                                            <?php $transaction_detail = $transaction_detail.'<br>- '.$detail->name.' | '.$detail->qty.' '.$detail->unit; ?>
                                        @endif
                                    @endif
                                @endforeach
                                {{$transaction_detail}}
                            </td>
                            <td>{{$transaction->transaction_type}}</td>
                            <td>{{$transaction->recipient_name}}</td>
                            <td>{{$transaction->recipient_phone}}</td>
                            <td>{{$transaction->address}}</td>
                            <td>{{$transaction->delivery_option}}</td>
                            <td>{{$transaction->delivery_transport}}</td>
                            <td>{{$transaction->delivery_type}}</td>
                            <td>
                                @if($transaction->payment_status == 0)
                                Pending
                                @elseif($transaction->payment_status == 1)
                                Done
                                @endif
                            </td>
                            <td>{{$transaction->notes}}</td>
                            <td>Rp {{number_format($transaction->grand_price,0,',','.')}}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                <a href="{{route('customer.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('customer.edit', [$customer->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@stop

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.plugins.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/extensions/Buttons/css/buttons.bootstrap.min.css')}}">

<link rel="stylesheet" href="{{url('plugins/select2/css/select2.css')}}">
<link rel="stylesheet" href="{{url('plugins/select2/css/select2-bootstrap.css')}}">
@endpush

@push('scripts')
<!-- DataTables -->

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<script src="{{url('plugins/jquery-number/jquery.number.min.js')}}"></script>
<script src="{{url('plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Buttons/js/buttons.bootstrap.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Checkboxes/dataTables.checkboxes.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Pagination/full_numbers_no_ellipses.js')}}"></script>

<script src="{{url('plugins/select2/js/select2.full.js')}}"></script>
@endpush
@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Calendar Transaction Detail
                    <div class="pull-right">
                    </div>
                </div>
            </div>

            <div class="panel-body">
                @foreach($calendar as $transaction)
                <div class="col-md-12" style="padding: 0;">
                    <div class="transaction-wrapper">
                        <!-- Collapsible Header -->
                        <div class="transaction-header" style="cursor: pointer;" data-toggle="collapse" data-target="#transaction-{{$transaction->id}}" aria-expanded="false" aria-controls="transaction-{{$transaction->id}}">
                            <h4>
                                <a  href="#transaction-{{$transaction->id}}" aria-expanded="false" aria-controls="transaction-{{$transaction->id}}" class="collapsed">
                                    <i class="fa fa-chevron-right transaction-icon"></i> 
                                    <strong>Transaction #{{$transaction->code}}</strong> - {{$transaction->customer_name}} 
                                    <small>({{$transaction->date}} {{$transaction->time}})</small>
                                    <span class="pull-right">
                                        <span class="status-badge status-{{$transaction->status == 3 ? 'success' : ($transaction->status == 0 ? 'warning' : 'info')}}">
                                            <i class="fa fa-{{$transaction->status == 0 ? 'clock-o' : ($transaction->status == 1 ? 'cutlery' : ($transaction->status == 2 ? 'truck' : 'check-circle'))}}"></i>
                                            @if($transaction->status == 0)
                                                New Order
                                            @elseif($transaction->status == 1)
                                                Start Cooking
                                            @elseif($transaction->status == 2)
                                                Start Delivery
                                            @elseif($transaction->status == 3)
                                                Done
                                            @endif
                                        </span>
                                    </span>
                                </a>
                            </h4>
                        </div>

                        <!-- Collapsible Content (Additional Details) -->
                        <div class="collapse collapse-content" id="transaction-{{$transaction->id}}">
                            <div class="transaction-details">
                                <h5><i class="fa fa-info-circle"></i> Transaction Details</h5>
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
                            Provinsi Pemesan
                        </dt>
                        <dd>
                            : @if($transaction->customer_city)
                            {{$transaction->customer_city->province->name}}
                            @endif
                        </dd>
                        <dt class="text-left">
                            Kota Pemesan
                        </dt>
                        <dd>
                            : @if($transaction->customer_city)
                            {{$transaction->customer_city->name}}
                            @endif
                        </dd>
                        <dt class="text-left">
                            Alamat Pemesan
                        </dt>
                        <dd>
                            : {{$transaction->customer_address}}
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
                            Provinsi Penerima
                        </dt>
                        <dd>
                            : {{$transaction->city->province->name}}
                        </dd>
                        <dt class="text-left">
                            Kota Penerima
                        </dt>
                        <dd>
                            : {{$transaction->city->name}}
                        </dd>
                        <dt class="text-left">
                            Alamat Penerima
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
                            Mulai Packing
                        </dt>
                        <dd>
                            : {{$transaction->start_cooking_at}}
                        </dd>
                        <dt class="text-left">
                            Mulai Packing Oleh
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
                            Suspend
                        </dt>
                        <dd>
                            : {{$transaction->suspend_at}}
                        </dd>
                        <dt class="text-left">
                            Suspend Oleh
                        </dt>
                        <dd>
                            : {{$transaction->suspend_by}}
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


                        </div> <!-- End collapse content -->

                        <!-- Always Visible Product Table -->
                        <div class="transaction-products">
                            <h5><i class="fa fa-shopping-cart"></i> Products</h5>
                            <table class="table table-striped table-bordered table-hover table-condensed" width="100%">
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
                                        <th colspan="1" class="text-left"><span><strong>Rp {{number_format($transaction->grand_price + $transaction->discount - $transaction->ongkir_price,0,',','.')}}</strong></span></th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" class="text-right">
                                            Harga Discount :
                                        </th>
                                        <th colspan="1" class="text-left"><span><strong>Rp {{number_format($transaction->discount_price,0,',','.')}}</strong></span></th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" class="text-right">
                                            Harga Ongkir :
                                        </th>
                                        <th colspan="1" class="text-left"><span><strong>Rp {{number_format($transaction->ongkir_price,0,',','.')}}</strong></span></th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" class="text-right">
                                            Harga Grand Total :
                                        </th>
                                        <th colspan="1" class="text-left"><span><strong>Rp {{number_format($transaction->grand_price,0,',','.')}}</strong></span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> <!-- End transaction wrapper -->
                    
                </div>
                
                @if(!$loop->last)
                <div class="col-md-12" style="padding: 0; margin-top: 20px; margin-bottom: 20px;">
                    <div class="transaction-separator">
                        <hr style="border: 2px solid #e0e0e0ff; margin: 0; width: 100%;">
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <div class="panel-footer">
                <a href="{{route('calendar.show', [$month, $year])}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
.transaction-wrapper {
    margin: 40px 20px;
    border: 2px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    position: relative;
    background-color: #ffffff;
}

.transaction-separator {
    margin: 50px 20px !important;
    padding: 20px 0 !important;
    border-top: 4px solid #667eea !important;
    border-bottom: 2px solid #e0e0e0 !important;
    width: calc(100% - 40px) !important;
    background-color: #f8f9fa !important;
    display: block !important;
    height: auto !important;
    clear: both !important;
}

.transaction-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    margin: 0;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.transaction-header:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

.transaction-header a {
    text-decoration: none;
    color: white !important;
    display: block;
    width: 100%;
}

.transaction-header a:hover {
    text-decoration: none;
    color: white !important;
}

.transaction-header h4 {
    margin: 0;
    font-weight: 500;
}

.transaction-header .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
    padding: 6px 12px;
    margin-left: 10px;
    border-radius: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    background-color: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    color: white;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.transaction-header .status-badge.status-success {
    background-color: rgba(40, 167, 69, 0.9);
    border-color: rgba(40, 167, 69, 0.5);
}

.transaction-header .status-badge.status-warning {
    background-color: rgba(255, 193, 7, 0.9);
    border-color: rgba(255, 193, 7, 0.5);
    color: #333;
    text-shadow: none;
}

.transaction-header .status-badge.status-info {
    background-color: rgba(23, 162, 184, 0.9);
    border-color: rgba(23, 162, 184, 0.5);
}

.transaction-header .status-badge i {
    font-size: 11px;
}

.collapse-content {
    border: none;
    padding: 0;
    background-color: #ffffff;
}

.transaction-details {
    padding: 20px;
    background-color: #f9f9f9;
}

.transaction-products {
    padding: 0 20px 20px 20px;
    background-color: #ffffff;
}

.transaction-products .table {
    margin-bottom: 0;
    border: 1px solid #ddd;
}

.dl-horizontal dt {
    width: 180px;
    text-align: left;
    font-weight: 600;
    color: #333;
}

.dl-horizontal dd {
    margin-left: 200px;
    color: #666;
}

.transaction-icon {
    transition: transform 0.3s ease;
}

.collapsed .transaction-icon {
    transform: rotate(0deg);
}

.transaction-icon {
    transform: rotate(90deg);
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Handle collapse icon changes and animations
    $('.collapse').on('show.bs.collapse', function () {
        var $header = $(this).prev('.transaction-header');
        $header.find('.transaction-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        $header.find('a').removeClass('collapsed');
    });
    
    $('.collapse').on('hide.bs.collapse', function () {
        var $header = $(this).prev('.transaction-header');
        $header.find('.transaction-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        $header.find('a').addClass('collapsed');
    });
    
    // Optional: Expand first transaction by default
    var firstTransaction = $('.collapse').first();
    if (firstTransaction.length > 0) {
        firstTransaction.collapse('show');
    }
});
</script>
@endsection
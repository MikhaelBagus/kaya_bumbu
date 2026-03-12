@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-shopping-cart"></span>Purchase Detail - {{ $purchase->code }}
                </div>
            </div>

            <div class="panel-body">
                {{-- Purchase Info --}}
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-primary"><strong>Purchase Information</strong></h4>
                        <hr>
                    </div>
                </div>

                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt class="text-left">Purchase Code</dt>
                        <dd>: {{ $purchase->code }}</dd>

                        <dt class="text-left">Purchase Date</dt>
                        <dd>: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</dd>

                        <dt class="text-left">Status</dt>
                        <dd>:
                            @if ($purchase->status == 'draft')
                                <span class="label label-warning">DRAFT</span>
                            @elseif($purchase->status == 'waiting_for_payment')
                                <span class="label label-info">WAITING FOR PAYMENT</span>
                            @elseif($purchase->status == 'paid')
                                <span class="label label-success">PAID</span>
                            @else
                                <span class="label label-default">{{ strtoupper($purchase->status) }}</span>
                            @endif
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt class="text-left">Supplier</dt>
                        <dd>: {{ $purchase->supplier ? $purchase->supplier->supplier_name : '-' }}</dd>

                        <dt class="text-left">Supplier Account</dt>
                        <dd>: {{ $purchase->supplierAccount ? $purchase->supplierAccount->account_number .' - '. $purchase->supplierAccount->account_name .' - '. $purchase->supplierAccount->bank_name : '-' }}</dd>

                        <dt class="text-left">Payment Method</dt>
                        <dd>: {{ $purchase->paymentMethod ? $purchase->paymentMethod->name : '-' }}</dd>

                        @if($purchase->full_payment_date != null)
                        <dt class="text-left">Tanggal Full Payment</dt>
                        <dd>: {{ \Carbon\Carbon::parse($purchase->full_payment_date)->format('d M Y') }}</dd>
                        @endif

                        <dt class="text-left">Wallet</dt>
                        <dd>: {{ $purchase->wallet ? $purchase->wallet->account_number .' - '. $purchase->wallet->account_name .' - '. $purchase->wallet->bank_name : '-' }}</dd>
                    </dl>
                </div>

                <div class="clearfix"></div>

                {{-- Product Items --}}
                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-12">
                        <h4 class="text-primary"><strong>Product Items</strong></h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-striped">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>#</th>
                                        <th>Ingredient</th>
                                        <th>Warehouse</th>
                                        <th>Expenditure Type</th>
                                        <th>Unit</th>
                                        <th class="text-right">PO Qty</th>
                                        <th class="text-right">Last Price</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchase->purchaseItems as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->warehouse->warehouse_name }}</td>
                                            <td>{{ $item->expenditureType->name }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td class="text-right">{{ number_format($item->po_qty, 0, ',', '.') }}</td>
                                            <td class="text-right">Rp {{ number_format($item->last_price, 0, ',', '.') }}</td>
                                            <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-right"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No items found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Purchase Costs --}}
                @if ($purchase->purchaseCosts->count() > 0)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <h4 class="text-primary"><strong>Costs</strong></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>#</th>
                                            <th>Cost Name</th>
                                            <th class="text-right">Amount</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->purchaseCosts as $cost)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $cost->cost_name }}</td>
                                                <td class="text-right"><strong>Rp {{ number_format($cost->amount, 0, ',', '.') }}</strong></td>
                                                <td>{{ $cost->notes ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Purchase Discounts --}}
                @if ($purchase->purchaseDiscounts->count() > 0)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <h4 class="text-primary"><strong>Discounts</strong></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>#</th>
                                            <th>Discount Name</th>
                                            <th class="text-right">Amount</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->purchaseDiscounts as $discount)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $discount->discount_name }}</td>
                                                <td class="text-right"><strong>Rp {{ number_format($discount->amount, 0, ',', '.') }}</strong></td>
                                                <td>{{ $discount->notes ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Instalment Information --}}
                @if ($purchase->instalment_count > 0 && $purchase->purchaseInstalments->count() > 0)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12">
                            <h4 class="text-primary"><strong>Instalment Information</strong></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <dl class="dl-horizontal">
                                <dt class="text-left">Down Payment</dt>
                                <dd>: Rp {{ number_format($purchase->down_payment, 0, ',', '.') }}</dd>

                                <dt class="text-left">Tanggal Down Payment</dt>
                                <dd>: {{ \Carbon\Carbon::parse($purchase->down_payment_date)->format('d M Y') }}</dd>

                                <dt class="text-left">Instalment Count</dt>
                                <dd>: {{ $purchase->instalment_count }}x</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr class="bg-info">
                                            <th width="50">#</th>
                                            <th>Tanggal Jatuh Tempo</th>
                                            <th class="text-right">Jumlah Cicilan</th>
                                            <th>Tanggal Pelunasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->purchaseInstalments as $instalment)
                                            <tr>
                                                <td class="text-center">{{ $instalment->instalment_number }}</td>
                                                <td>{{ $instalment->due_date ? \Carbon\Carbon::parse($instalment->due_date)->format('d M Y') : '-' }}</td>
                                                <td class="text-right"><strong>Rp {{ number_format($instalment->amount, 0, ',', '.') }}</strong></td>
                                                <td>{{ $instalment->paid_date ? \Carbon\Carbon::parse($instalment->paid_date)->format('d M Y') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Cost Summary --}}
                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-6">
                        @if ($purchase->notes)
                            <h4 class="text-primary"><strong>Notes</strong></h4>
                            <hr>
                            <p>{{ $purchase->notes }}</p>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <h4 class="text-primary"><strong>Cost Summary</strong></h4>
                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-right"><strong>Rp {{ number_format($purchase->subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td>Cost</td>
                                <td class="text-right"><strong>Rp {{ number_format($purchase->cost, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td class="text-right"><strong>Rp {{ number_format($purchase->discount, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr class="bg-primary">
                                <td><strong>Total Purchase</strong></td>
                                <td class="text-right"><strong>Rp {{ number_format($purchase->total_purchase, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="clearfix"></div>

                {{-- Audit Info --}}

                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt class="text-left">Created By</dt>
                        <dd>: {{ $purchase->created_by }}</dd>

                        <dt class="text-left">Created At</dt>
                        <dd>: {{ \Carbon\Carbon::parse($purchase->created_at)->format('d M Y H:i:s') }}</dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt class="text-left">Updated By</dt>
                        <dd>: {{ $purchase->updated_by ?: '-' }}</dd>

                        <dt class="text-left">Updated At</dt>
                        <dd>: {{ \Carbon\Carbon::parse($purchase->updated_at)->format('d M Y H:i:s') }}</dd>
                    </dl>
                </div>

                @if($purchase->status == 'waiting_for_payment')
                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt class="text-left">Approved By</dt>
                        <dd>: {{ $purchase->approved_by ?: '-' }}</dd>

                        <dt class="text-left">Approved At</dt>
                        <dd>: {{ \Carbon\Carbon::parse($purchase->approved_at)->format('d M Y H:i:s') }}</dd>
                    </dl>
                </div>
                @endif

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{ route('purchase.index') }}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{ route('purchase.edit', [$purchase->id]) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i> @lang('global.update')
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <style>
        @media print {

            .panel-footer,
            .navbar,
            .sidebar {
                display: none !important;
            }
        }
    </style>
@endpush

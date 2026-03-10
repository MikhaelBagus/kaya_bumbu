@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-shopping-cart"></span>Purchase List
                </div>
            </div>

            <div class="panel panel-default" style="margin-bottom:0px">
                <div class="panel-heading">
                    Filter
                </div>
                <div class="panel-body">
                    <form action="" method="POST">
                        <div class="row">
                            {{-- Row 1: Tanggal --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Input From</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="created_at_from" name="created_at_from"
                                            value="{{ old('created_at_from') }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm tip" id="clearCreatedAtFrom"
                                            title="Clear Tanggal Input From">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Input To</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="created_at_to" name="created_at_to"
                                            value="{{ old('created_at_to') }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm tip" id="clearCreatedAtTo"
                                            title="Clear Tanggal Input To">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Pembelian From</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="purchase_date_from" name="purchase_date_from"
                                            value="{{ old('purchase_date_from') }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm tip" id="clearPurchaseDateFrom"
                                            title="Clear Purchase Date From">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Pembelian To</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="purchase_date_to" name="purchase_date_to"
                                            value="{{ old('purchase_date_to') }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm tip" id="clearPurchaseDateTo"
                                            title="Clear Purchase Date To">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Row 2: Relasi utama --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Vendor</label>
                                    <select id="supplier_id" class="input-sm form-control select_2" style="width:100%"
                                        name="supplier_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Data Rekening</label>
                                    <select id="supplier_account_id" class="input-sm form-control select_2"
                                        style="width:100%" name="supplier_account_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Pengeluaran Dari</label>
                                    <select id="wallet_id" class="input-sm form-control select_2" style="width:100%"
                                        name="wallet_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Payment Method</label>
                                    <select id="payment_method_id" class="input-sm form-control select_2"
                                        style="width:100%" name="payment_method_id"></select>
                                </div>
                            </div>

                            {{-- Row 3: Item --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nama Item</label>
                                    <select id="product_id" class="input-sm form-control select_2" style="width:100%"
                                        name="product_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Kategori Item</label>
                                    <select id="ingredient_group_id" class="input-sm form-control select_2"
                                        style="width:100%" name="ingredient_group_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Sub Kategori Item</label>
                                    <select id="ingredient_category_id" class="input-sm form-control select_2"
                                        style="width:100%" name="ingredient_category_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    <select id="status" class="input-sm form-control select_2" style="width:100%"
                                        name="status">
                                        <option value=""></option>
                                        <option value="draft">Draft</option>
                                        <option value="approved">Approved</option>
                                        <option value="waiting_for_payment">Waiting For Payment</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Row 4: Nominal purchase --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Total Purchase From</label>
                                    <input type="number" id="total_purchase_from" name="total_purchase_from"
                                        value="{{ old('total_purchase_from') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Total Purchase To</label>
                                    <input type="number" id="total_purchase_to" name="total_purchase_to"
                                        value="{{ old('total_purchase_to') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Total Cicilan From</label>
                                    <input type="number" id="instalment_count_from" name="instalment_count_from"
                                        value="{{ old('instalment_count_from') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Total Cicilan To</label>
                                    <input type="number" id="instalment_count_to" name="instalment_count_to"
                                        value="{{ old('instalment_count_to') }}" class="form-control input-sm">
                                </div>
                            </div>

                            {{-- Row 5: Cicilan + qty --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Sisa Cicilan From</label>
                                    <input type="number" id="instalment_left_from" name="instalment_left_from"
                                        value="{{ old('instalment_left_from') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Sisa Cicilan To</label>
                                    <input type="number" id="instalment_left_to" name="instalment_left_to"
                                        value="{{ old('instalment_left_to') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Jumlah From</label>
                                    <input type="number" id="po_qty_from" name="po_qty_from"
                                        value="{{ old('po_qty_from') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Jumlah To</label>
                                    <input type="number" id="po_qty_to" name="po_qty_to"
                                        value="{{ old('po_qty_to') }}" class="form-control input-sm">
                                </div>
                            </div>

                            {{-- Row 6: Harga item --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Harga Satuan From</label>
                                    <input type="number" id="price_from" name="price_from"
                                        value="{{ old('price_from') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Harga Satuan To</label>
                                    <input type="number" id="price_to" name="price_to"
                                        value="{{ old('price_to') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Total Harga Item From</label>
                                    <input type="number" id="item_subtotal_from" name="item_subtotal_from"
                                        value="{{ old('item_subtotal_from') }}" class="form-control input-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Total Harga Item To</label>
                                    <input type="number" id="item_subtotal_to" name="item_subtotal_to"
                                        value="{{ old('item_subtotal_to') }}" class="form-control input-sm">
                                </div>
                            </div>

                            {{-- Row 7: Action --}}
                            <div class="col-md-12">
                                <button type="button" id="choose" class="btn btn-success btn-sm">Apply Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel-menu">
                <a href="{{ route('purchase.create') }}"
                    class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
            </div>

            <table class="table table-striped table-bordered table-hover table-condensed" id="purchase-table"
                width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="text-align: center">&nbsp;</th>
                        <th>Purchase Code</th>
                        <th>Purchase Date</th>
                        <th>Supplier</th>
                        <th>Total Purchase</th>
                        <th>Payment Method</th>
                        <th>Total Cicilan</th>
                        <th>Sisa Cicilan</th>
                        <th>Status</th>
                        <th>@lang('auth.index_created_at')</th>
                        <th>@lang('auth.index_updated_at')</th>
                        <th width="100">@lang('global.action')</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>
@stop

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="{{ url('theme/app/vendor/plugins/datatables/media/css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('theme/app/vendor/plugins/datatables/media/css/dataTables.plugins.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables/extensions/Buttons/css/buttons.bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ url('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/select2/css/select2-bootstrap.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

    <script src="{{ url('plugins/jquery-number/jquery.number.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/Buttons/js/buttons.bootstrap.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/Checkboxes/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/Pagination/full_numbers_no_ellipses.js') }}"></script>

    <script src="{{ url('plugins/select2/js/select2.full.js') }}"></script>

    <script>
        $(function() {
            let table = $('#purchase-table').DataTable({
                aaSorting: [
                    [0, 'desc']
                ],
                aLengthMenu: [
                    [50, 100, 500, 1000, 5000, -1],
                    [50, 100, 500, 1000, 5000, "All"]
                ],
                iDisplayLength: 100,
                processing: true,
                serverSide: true,
                scrollX: true,
                dom: "<'dt-panelmenu clearfix'<'row'<'col-sm-2'B><'col-sm-4'l><'col-sm-6'f>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'dt-panelfooter clearfix'<'row'<'col-sm-5'i><'col-sm-7'p>>>",
                pagingType: "full_numbers",
                ajax: {
                    url: '{!! route('purchase.ajax.data') !!}',
                    dataType: 'json',
                    data: function(d) {
                        d.created_at_from = $('#created_at_from').val();
                        d.created_at_to = $('#created_at_to').val();
                        d.purchase_date_from = $('#purchase_date_from').val();
                        d.purchase_date_to = $('#purchase_date_to').val();
                        d.total_purchase_from = $('#total_purchase_from').val();
                        d.total_purchase_to = $('#total_purchase_to').val();
                        d.supplier_id = $('#supplier_id').val();
                        d.supplier_account_id = $('#supplier_account_id').val();
                        d.wallet_id = $('#wallet_id').val();
                        d.payment_method_id = $('#payment_method_id').val();
                        d.instalment_count_from = $('#instalment_count_from').val();
                        d.instalment_count_to = $('#instalment_count_to').val();
                        d.instalment_left_from = $('#instalment_left_from').val();
                        d.instalment_left_to = $('#instalment_left_to').val();
                        d.status = $('#status').val();
                        d.product_id = $('#product_id').val();
                        d.ingredient_group_id = $('#ingredient_group_id').val();
                        d.ingredient_category_id = $('#ingredient_category_id').val();
                        d.po_qty_from = $('#po_qty_from').val();
                        d.po_qty_to = $('#po_qty_to').val();
                        d.price_from = $('#price_from').val();
                        d.price_to = $('#price_to').val();
                        d.item_subtotal_from = $('#item_subtotal_from').val();
                        d.item_subtotal_to = $('#item_subtotal_to').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        checkboxes: true
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'purchase_date',
                        name: 'purchase_date'
                    },
                    {
                        data: 'supplier.supplier_name',
                        name: 'supplier.supplier_name'
                    },
                    {
                        data: 'total_purchase',
                        name: 'total_purchase',
                        render: function(data) {
                            return 'Rp ' + $.number(data, 0, ',', '.');
                        }
                    },
                    {
                        data: 'payment_method.name',
                        name: 'payment_method.name'
                    },
                    {
                        data: 'instalment_count',
                        name: 'instalment_count'
                    },
                    {
                        data: 'instalment_left',
                        name: 'instalment_left',
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            let badge = 'default';
                            if (data === 'draft') badge = 'warning';
                            else if (data === 'approved') badge = 'success';
                            else if (data === 'waiting_for_payment') badge = 'info';
                            else if (data === 'paid') badge = 'success';

                            return '<span class="label label-' + badge + '">' + data.toUpperCase() +
                                '</span>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        visible: false
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        visible: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        fnCreatedCell: function(nTd) {
                            $("a", nTd).tooltip({
                                container: 'body'
                            });
                        }
                    }
                ],
                buttons: [{
                        extend: 'csv',
                        text: '<i class="fa fa-download"></i> CSV',
                        exportOptions: {
                            columns: [2, 3, 4, 5, 6, 7, 8, 9],
                            modifier: {
                                page: 'all',
                                search: 'none'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            modifier: {
                                page: 'all',
                                search: 'none'
                            }
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i> @lang('auth.index_column')',
                        columns: '2,3,4,5,6,7,8,9'
                    },
                    {
                        text: '<i class="fa fa-download"></i> Download Purchase',
                        className: 'btn-success',
                        action: function() {
                            const params = new URLSearchParams({
                                created_at_from: $('#created_at_from').val() || '',
                                created_at_to: $('#created_at_to').val() || '',
                                purchase_date_from: $('#purchase_date_from').val() || '',
                                purchase_date_to: $('#purchase_date_to').val() || '',
                                total_purchase_from: $('#total_purchase_from').val() || '',
                                total_purchase_to: $('#total_purchase_to').val() || '',
                                supplier_id: $('#supplier_id').val() || '',
                                supplier_account_id: $('#supplier_account_id').val() || '',
                                wallet_id: $('#wallet_id').val() || '',
                                payment_method_id: $('#payment_method_id').val() || '',
                                instalment_count_from: $('#instalment_count_from').val() || '',
                                instalment_count_to: $('#instalment_count_to').val() || '',
                                instalment_left_from: $('#instalment_left_from').val() || '',
                                instalment_left_to: $('#instalment_left_to').val() || '',
                                status: $('#status').val() || '',
                                product_id: $('#product_id').val() || '',
                                ingredient_group_id: $('#ingredient_group_id').val() || '',
                                ingredient_category_id: $('#ingredient_category_id').val() || '',
                                po_qty_from: $('#po_qty_from').val() || '',
                                po_qty_to: $('#po_qty_to').val() || '',
                                price_from: $('#price_from').val() || '',
                                price_to: $('#price_to').val() || '',
                                item_subtotal_from: $('#item_subtotal_from').val() || '',
                                item_subtotal_to: $('#item_subtotal_to').val() || ''
                            });

                            window.location.href = '{{ route('purchase.download') }}?' + params.toString();
                        }
                    }
                ],
                select: {
                    style: 'multi'
                },
            });

            $('#choose').on('click', function(e) {
                e.preventDefault();
                table.draw();
            });

            $('#purchase_date_from, #purchase_date_to, #created_at_from, #created_at_to').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+2"
            });

            $('#supplier_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:',
                ajax: {
                    url: '{{ route('supplier.ajax.select2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: {
                                term: params.term
                            },
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#supplier_account_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:',
                ajax: {
                    url: '{{ route('supplier_account.ajax.select2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: {
                                term: params.term
                            },
                            page: params.page || 1,
                            supplier_id: $('#supplier_id').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#supplier_id').on('change', function() {
                $('#supplier_account_id').val(null).trigger('change');
            });

            $('#wallet_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:',
                ajax: {
                    url: '{{ route('wallet.ajax.select2.old') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (params.page * data.per_page) < data.total
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#payment_method_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:',
                ajax: {
                    url: '{{ route('payment_method.ajax.select2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: {
                                term: params.term
                            },
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#product_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:',
                ajax: {
                    url: '{{ route('ingredient.ajax.select2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            }),
                            pagination: {
                                more: data.next_page_url != null
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#ingredient_group_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:',
                ajax: {
                    url: '{{ route('ingredient_group.ajax.select2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data,
                            pagination: {
                                more: data.next_page_url != null
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#ingredient_category_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:',
                ajax: {
                    url: '{{ route('ingredient_category.ajax.select2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data,
                            pagination: {
                                more: data.next_page_url != null
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#status').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:'
            });

            $('#purchase_date_from').on('change', function() {
                if ($('#purchase_date_to').val() == '') {
                    $('#purchase_date_to').val($('#purchase_date_from').val());
                }
            });

            $('#purchase_date_to').on('change', function() {
                if ($('#purchase_date_from').val() == '') {
                    $('#purchase_date_from').val($('#purchase_date_to').val());
                }
            });

            $('#created_at_from').on('change', function() {
                if ($('#created_at_to').val() == '') {
                    $('#created_at_to').val($('#created_at_from').val());
                }
            });

            $('#created_at_to').on('change', function() {
                if ($('#created_at_from').val() == '') {
                    $('#created_at_from').val($('#created_at_to').val());
                }
            });

            $('#total_purchase_from').on('change', function() {
                if ($('#total_purchase_to').val() == '') {
                    $('#total_purchase_to').val($('#total_purchase_from').val());
                }
            });

            $('#total_purchase_to').on('change', function() {
                if ($('#total_purchase_from').val() == '') {
                    $('#total_purchase_from').val($('#total_purchase_to').val());
                }
            });

            $('#instalment_count_from').on('change', function() {
                if ($('#instalment_count_to').val() == '') {
                    $('#instalment_count_to').val($('#instalment_count_from').val());
                }
            });

            $('#instalment_count_to').on('change', function() {
                if ($('#instalment_count_from').val() == '') {
                    $('#instalment_count_from').val($('#instalment_count_to').val());
                }
            });

            $('#instalment_left_from').on('change', function() {
                if ($('#instalment_left_to').val() == '') {
                    $('#instalment_left_to').val($('#instalment_left_from').val());
                }
            });

            $('#instalment_left_to').on('change', function() {
                if ($('#instalment_left_from').val() == '') {
                    $('#instalment_left_from').val($('#instalment_left_to').val());
                }
            });

            $('#clearPurchaseDateFrom').on('click', function() {
                $('#purchase_date_from').val('');
            });

            $('#clearPurchaseDateTo').on('click', function() {
                $('#purchase_date_to').val('');
            });

            $('#clearCreatedAtFrom').on('click', function() {
                $('#created_at_from').val('');
            });

            $('#clearCreatedAtTo').on('click', function() {
                $('#created_at_to').val('');
            });

            $('#clearTotalPurchaseFrom').on('click', function() {
                $('#total_purchase_from').val('');
            });

            $('#clearTotalPurchaseTo').on('click', function() {
                $('#total_purchase_to').val('');
            });

            $('#clearInstalmentCountFrom').on('click', function() {
                $('#instalment_count_from').val('');
            });

            $('#clearInstalmentCountTo').on('click', function() {
                $('#instalment_count_to').val('');
            });

            $('#clearInstalmentLeftFrom').on('click', function() {
                $('#instalment_left_from').val('');
            });

            $('#clearInstalmentLeftTo').on('click', function() {
                $('#instalment_left_to').val('');
            });
        });
    </script>
@endpush
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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="purchase_date">Purchase Date Range</label>
                                    <div class="input-group input-group-sm date">
                                        <input type="text" name="purchase_date_from" id="purchase_date_from"
                                            value="{{ old('purchase_date_from') }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm" for="purchase_date_from">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                        <label class="input-group-addon input-sm tip" id="clearPurchaseDateFrom"
                                            title="Clear Purchase Date From" for="purchase_date_from">
                                            <i class="fa fa-eraser"></i>
                                        </label>

                                        <input type="text" name="purchase_date_to" id="purchase_date_to"
                                            value="{{ old('purchase_date_to') }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm" for="purchase_date_to">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                        <label class="input-group-addon input-sm tip" id="clearPurchaseDateTo"
                                            title="Clear Purchase Date To" for="purchase_date_to">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="total_purchase">Total Purchase Range</label>
                                    <div class="input-group input-group-sm date">
                                        <input type="number" name="total_purchase_from" id="total_purchase_from"
                                            value="{{ old('total_purchase_from') }}" class="form-control input-sm">
                                        <label class="input-group-addon input-sm tip" id="clearTotalPurchaseFrom"
                                            title="Clear Total Purchase From" for="total_purchase_from">
                                            <i class="fa fa-eraser"></i>
                                        </label>

                                        <input type="number" name="total_purchase_to" id="total_purchase_to"
                                            value="{{ old('total_purchase_to') }}" class="form-control input-sm">
                                        <label class="input-group-addon input-sm tip" id="clearTotalPurchaseTo"
                                            title="Clear Total Purchase To" for="total_purchase_to">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Supplier</label>
                                    <select id="supplier_id" class="input-sm form-control select_2" style="width:100%" name="supplier_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Supplier Account</label>
                                    <select id="supplier_account_id" class="input-sm form-control select_2" style="width:100%" name="supplier_account_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Wallet</label>
                                    <select id="wallet_id" class="input-sm form-control select_2" style="width:100%" name="wallet_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Payment Method</label>
                                    <select id="payment_method_id" class="input-sm form-control select_2" style="width:100%" name="payment_method_id"></select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    <select id="status" class="input-sm form-control select_2" style="width:100%" name="status">
                                        <option value=""></option>
                                        <option value="draft">Draft</option>
                                        <option value="approved">Approved</option>
                                        <option value="waiting_for_payment">Waiting For Payment</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="button" id="choose" class="btn btn-success btn-sm">Apply Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel-menu">
                <a href="{{ route('purchase.create') }}" class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
            </div>

            <table class="table table-striped table-bordered table-hover table-condensed" id="purchase-table" width="100%">
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
                        d.purchase_date_from = $('#purchase_date_from').val();
                        d.purchase_date_to = $('#purchase_date_to').val();
                        d.total_purchase_from = $('#total_purchase_from').val();
                        d.total_purchase_to = $('#total_purchase_to').val();
                        d.supplier_id = $('#supplier_id').val();
                        d.supplier_account_id = $('#supplier_account_id').val();
                        d.wallet_id = $('#wallet_id').val();
                        d.payment_method_id = $('#payment_method_id').val();
                        d.status = $('#status').val();
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
                        searchable: false,
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

                            return '<span class="label label-' + badge + '">' + data.toUpperCase() + '</span>';
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
                        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
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
                            columns: [2, 3, 4, 5, 6, 8, 9],
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
                        action: function(e, dt, node, config) {
                            window.location.href = '{{ route('purchase.download') }}';
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

            $('#purchase_date_from').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+2"
            });

            $('#purchase_date_to').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+2"
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

            $('#clearPurchaseDateFrom').on('click', function() {
                $('#purchase_date_from').val('');
            });

            $('#clearPurchaseDateTo').on('click', function() {
                $('#purchase_date_to').val('');
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

            $('#clearTotalPurchaseFrom').on('click', function() {
                $('#total_purchase_from').val('');
            });

            $('#clearTotalPurchaseTo').on('click', function() {
                $('#total_purchase_to').val('');
            });

            $('#status').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                allowClear: true,
                containerCssClass: ':all:'
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
        });
    </script>
@endpush
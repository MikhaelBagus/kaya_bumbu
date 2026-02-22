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
    <!-- DataTables -->
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
    <!-- DataTables -->

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
                    dataType: 'json'
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
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            let badge = 'default';
                            if (data === 'draft') badge = 'warning';
                            else if (data === 'submitted') badge = 'info';
                            else if (data === 'approved') badge = 'success';
                            else if (data === 'rejected') badge = 'danger';
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
                        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                            $("a", nTd).tooltip({
                                container: 'body'
                            });
                        }
                    }
                ],
                buttons: [{
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i> @lang('auth.index_column')',
                    columns: '2, 3, 4, 5, 6, 7'
                }],
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
        });
    </script>
@endpush

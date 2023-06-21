@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Transaction List
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
                                    <label class="control-label" for="order_date">Date Range</label>
                                    <div class="input-group input-group-sm date">
                                        <input type="text" name="order_date_from" id="order_date_from" value="{{ old('order_date_from', request()->orderDate) }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm" for="order_date_from">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                        <label class="input-group-addon input-sm tip" id="clearOrderDateFrom" title="Clear Date From" for="order_date_from">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                        <input type="text" name="order_date_to" id="order_date_to" value="{{ old('order_date_to', request()->orderDateTo) }}" class="form-control input-sm" readonly>
                                        <label class="input-group-addon input-sm" for="order_date_to">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                        <label class="input-group-addon input-sm tip" id="clearOrderDateTo" title="Clear Date To" for="order_date_to">
                                            <i class="fa fa-eraser"></i>
                                        </label>
                                    </div>
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
                <a href="{{route('transaction.create')}}" class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
            </div>
            <table class="table table-striped table-bordered table-hover table-condensed" id="transaction-table" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th>Code</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Discount Price</th>
                    <th>Ongkir Price</th>
                    <th>Grand Price</th>
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

<script>
    $(function () {

        let table = $('#transaction-table').DataTable({
            aaSorting: [[0, 'desc']],
            aLengthMenu: [
                    [50, 100, 500, 1000, 5000, -1],
                    [50, 100, 500, 1000, 5000, "All"]
                ],
            iDisplayLength: 100,
            //stateSave: true,
            // responsive: true,
            // fixedHeader: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            dom: "<'dt-panelmenu clearfix'<'row'<'col-sm-2'B><'col-sm-4'l><'col-sm-6'f>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'dt-panelfooter clearfix'<'row'<'col-sm-5'i><'col-sm-7'p>>>",
            pagingType: "full_numbers",
            ajax: {
                url: '{!! route('transaction.ajax.data') !!}',
                dataType: 'json',
                data: function (d) {
                    d.order_date_from = $('#order_date_from').val();
                    d.order_date_to   = $('#order_date_to').val();
                },
            },
            columns: [
                {data: 'id', name: 'id', visible: false},
                {
                    data: 'checkbox', name: 'checkbox', orderable: false, searchable: false,
                    checkboxes: true
                },
                {data: 'code', name: 'code'},
                {data: 'date', name: 'date'},
                {
                    data: 'status', name: 'status',
                    render: function (data, type, oObj) {
                        if(data == 0){
                            return 'New Order';
                        }
                        else if(data == 1){
                            return 'Start Cooking';
                        }
                        else if(data == 2){
                            return 'End Cooking';
                        }
                        else if(data == 3){
                            return 'Start Delivery';
                        }
                        else if(data == 4){
                            return 'Done';
                        }
                        else{
                            return '';
                        }
                    }
                },
                {data: 'customer.name', name: 'customer.name'},
                {data: 'customer.phone', name: 'customer.phone'},
                {
                    data: 'discount_price', name: 'discount_price',
                    render: function (data, type, oObj) {
                        return 'Rp. ' + $.number(data);
                    }
                },
                {
                    data: 'ongkir_price', name: 'ongkir_price',
                    render: function (data, type, oObj) {
                        return 'Rp. ' + $.number(data);
                    }
                },
                {
                    data: 'grand_price', name: 'grand_price',
                    render: function (data, type, oObj) {
                        return 'Rp. ' + $.number(data);
                    }
                },
                {data: 'created_at', name: 'created_at', visible: false},
                {data: 'updated_at', name: 'updated_at', visible: false},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false,
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                        $("a", nTd).tooltip({container: 'body'});
                    }
                }
            ],
            buttons: [
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i> @lang('auth.index_column')',
                    columns: '2, 3, 4'
                }
            ],
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
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
                }
            ],
            select: {
                style: 'multi'
            },
        });

        $('#choose').on('click', function (e) {
            e.preventDefault();
            table.draw();
        });

        $('#order_date_from').datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth: true,
            changeYear : true,
            yearRange  : "-100:+0"
        });

        $('#order_date_to').datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth: true,
            changeYear : true,
            yearRange  : "-100:+0"
        });

        $('#order_date_from').on('change',function(){
           if($('#order_date_to').val()=='')
              $('#order_date_to').val($('#order_date_from').val());
        });

        $('#order_date_to').on('change',function(){
           if($('#order_date_from').val()=='')
              $('#order_date_from').val($('#order_date_to').val());
        });

        $('#clearOrderDateFrom').on('click', function () {
            $('#order_date_from').val('');
        });

        $('#clearOrderDateTo').on('click', function () {
            $('#order_date_to').val('');
        });
    });
</script>
@endpush

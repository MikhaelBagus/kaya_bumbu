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

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    <select id="status" class="input-sm form-control select_2" style="width:100%" name="status">
                                        <option value=""></option>
                                        <option value="0">New Order</option>
                                        <option value="1">Start Cooking</option>
                                        <option value="2">Start Delivery</option>
                                        <option value="3">Done</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Payment Status</label>
                                    <select id="payment_status" class="input-sm form-control select_2" style="width:100%" name="payment_status">
                                        <option value=""></option>
                                        <option value="0">Pending</option>
                                        <option value="1">Done</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Delivery Option</label>
                                    <select id="delivery_option" class="input-sm form-control select_2" style="width:100%" name="delivery_option">
                                        <option value=""></option>
                                        <option value="Via Kaya Bumbu">Via Kaya Bumbu</option>
                                        <option value="Self Order">Self Order</option>
                                        <option value="Pick Up">Pick Up</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Delivery Transport</label>
                                    <select id="delivery_transport" class="input-sm form-control select_2" style="width:100%" name="delivery_transport">
                                        <option value=""></option>
                                        <option value="-">-</option>
                                        <option value="Mobil">Mobil</option>
                                        <option value="Motor">Motor</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Delivery Type</label>
                                    <select id="delivery_type" class="input-sm form-control select_2" style="width:100%" name="delivery_type">
                                        <option value=""></option>
                                        <option value="-">-</option>
                                        <option value="Instant">Instant</option>
                                        <option value="Same Day">Same Day</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Source</label>
                                    <select id="source_id" class="input-sm form-control select_2" style="width:100%" name="source_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Admin</label>
                                    <select id="user_id" class="input-sm form-control select_2" style="width:100%" name="user_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Customer Phone</label>
                                    <select id="customer_id" class="input-sm form-control select_2" style="width:100%" name="customer_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Province</label>
                                    <select id="province_id" class="input-sm form-control select_2" style="width:100%" name="province_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <select id="city_id" class="input-sm form-control select_2" style="width:100%" name="city_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Bank</label>
                                    <select id="bank_id" class="input-sm form-control select_2" style="width:100%" name="bank_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Transaction Type</label>
                                    <select id="transaction_type" class="input-sm form-control select_2" style="width:100%" name="transaction_type">
                                        <option value=""></option>
                                        <option value="PO">PO</option>
                                        <option value="Dadakan">Dadakan</option>
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
                <a href="{{route('transaction.create')}}" class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
            </div>
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
                    d.order_date_from    = $('#order_date_from').val();
                    d.order_date_to      = $('#order_date_to').val();
                    d.status             = $('#status').val();
                    d.payment_status     = $('#payment_status').val();
                    d.delivery_option    = $('#delivery_option').val();
                    d.delivery_transport = $('#delivery_transport').val();
                    d.delivery_type      = $('#delivery_type').val();
                    d.province_id        = $('#province_id').val();
                    d.city_id            = $('#city_id').val();
                    d.user_id            = $('#user_id').val();
                    d.customer_id        = $('#customer_id').val();
                    d.source_id          = $('#source_id').val();
                    d.bank_id            = $('#bank_id').val();
                    d.transaction_type   = $('#transaction_type').val();
                },
            },
            columns: [
                {data: 'id', name: 'id', visible: false},
                {data: 'user.name', name: 'user.name'},
                {data: 'date', name: 'date'},
                {data: 'time', name: 'time'},
                {data: 'transaction_detail', name: 'transaction_detail'},
                {data: 'transaction_type', name: 'transaction_type'},
                {data: 'recipient_name', name: 'recipient_name'},
                {data: 'recipient_phone', name: 'recipient_phone'},
                {data: 'address', name: 'address'},
                {data: 'delivery_option', name: 'delivery_option'},
                {data: 'delivery_transport', name: 'delivery_transport'},
                {data: 'delivery_type', name: 'delivery_type'},
                {
                    data: 'payment_status', name: 'payment_status',
                    render: function (data, type, oObj) {
                        if(data == 0){
                            return 'Pending';
                        }
                        else if(data == 1){
                            return 'Done';
                        }
                        else{
                            return '';
                        }
                    }
                },
                {data: 'notes', name: 'notes'},
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
                    columns: '2, 3, 4, 5, 6'
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

        $('#payment_status').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });

        $('#transaction_type').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });

        $('#delivery_transport').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });

        $('#delivery_option').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });

        $('#delivery_type').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });

        $('#status').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });

        $('#user_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('users.ajax.select2')}}',
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
                cache: true,
            }
        });

        $('#source_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('source.ajax.select2')}}',
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
                cache: true,
            }
        });

        $('#bank_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('bank.ajax.select2')}}',
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
                cache: true,
            }
        });

        $('#customer_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('customer.ajax.select2')}}',
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
                cache: true,
            }
        });

        $('#province_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('province.ajax.select2')}}',
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
                cache: true,
            }
        });

        $('#province_id').on("select2:select", function() {
            $('#city_id').empty();
        });

        $('#city_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('city.ajax.select2')}}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term,
                        page: params.page,
                        province_id: $('#province_id').val()
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
                cache: true,
            }
        });
    });
</script>
@endpush

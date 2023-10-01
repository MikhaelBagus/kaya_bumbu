@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
        
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Transaction Create Form
                </div>
            </div>
            
            <form action="{{route('transaction_download.download')}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="order_date">Date Range <span style="color: red">*</span></label>
                            <div class="input-group input-group-sm date">
                                <input type="text" name="order_date_from" id="order_date_from" value="{{ old('order_date_from', request()->orderDateFrom) }}" class="form-control input-sm" readonly required>
                                <label class="input-group-addon input-sm" for="order_date_from">
                                    <i class="fa fa-calendar"></i>
                                </label>
                                <label class="input-group-addon input-sm tip" id="clearOrderDateFrom" title="Clear Date From" for="order_date_from">
                                    <i class="fa fa-eraser"></i>
                                </label>
                                <input type="text" name="order_date_to" id="order_date_to" value="{{ old('order_date_to', request()->orderDateTo) }}" class="form-control input-sm" readonly required>
                                <label class="input-group-addon input-sm" for="order_date_to">
                                    <i class="fa fa-calendar"></i>
                                </label>
                                <label class="input-group-addon input-sm tip" id="clearOrderDateTo" title="Clear Date To" for="order_date_to">
                                    <i class="fa fa-eraser"></i>
                                </label>
                            </div>
                            {!! $errors->first('order_date_from', '<em for="order_date_from" class="text-danger">:message</em>') !!}
                            {!! $errors->first('order_date_to', '<em for="order_date_to" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="order_time">Time Range</label>
                            <div class="input-group input-group-sm date">
                                <select name="order_time_from" id="order_time_from" class="input-sm form-control select_2" style="width:50%">
                                    <option value=""></option>
                                    @for($h = 0; $h < 24; $h++)
                                        @for($m = 0; $m < 60; $m++)
                                            @if($h < 10 && $m < 10)
                                            <option value="0{{$h}}:0{{$m}}">0{{$h}}:0{{$m}}</option>
                                            @elseif($h < 10)
                                            <option value="0{{$h}}:{{$m}}">0{{$h}}:{{$m}}</option>
                                            @elseif($m < 10)
                                            <option value="{{$h}}:0{{$m}}">{{$h}}:0{{$m}}</option>
                                            @endif
                                        @endfor
                                    @endfor
                                </select>
                                <select name="order_time_to" id="order_time_to" class="input-sm form-control select_2" style="width:50%">
                                    <option value=""></option>
                                    @for($h = 0; $h < 24; $h++)
                                        @for($m = 0; $m < 60; $m++)
                                            @if($h < 10 && $m < 10)
                                            <option value="0{{$h}}:0{{$m}}">0{{$h}}:0{{$m}}</option>
                                            @elseif($h < 10)
                                            <option value="0{{$h}}:{{$m}}">0{{$h}}:{{$m}}</option>
                                            @elseif($m < 10)
                                            <option value="{{$h}}:0{{$m}}">{{$h}}:0{{$m}}</option>
                                            @endif
                                        @endfor
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="order_date">Grand Price Range</label>
                            <div class="input-group input-group-sm date">
                                <input type="number" name="grand_price_from" id="grand_price_from" value="{{ old('grand_price_from', request()->grandPriceFrom) }}" class="form-control input-sm">
                                <label class="input-group-addon input-sm tip" id="clearGrandPriceFrom" title="Clear Grand Price From" for="grand_price_from">
                                    <i class="fa fa-eraser"></i>
                                </label>
                                <input type="number" name="grand_price_to" id="grand_price_to" value="{{ old('grand_price_to', request()->grandPriceTo) }}" class="form-control input-sm">
                                <label class="input-group-addon input-sm tip" id="clearGrandPriceTo" title="Clear Grand Price To" for="grand_price_to">
                                    <i class="fa fa-eraser"></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Tipe Transaksi</label>
                            <select id="transaction_type" class="input-sm form-control select_2" style="width:100%" name="transaction_type">
                                <option value=""></option>
                                <option value="PO">PO</option>
                                <option value="Pesanan Baru">Pesanan Baru</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select id="status" class="input-sm form-control select_2" style="width:100%" name="status">
                                <option value=""></option>
                                <option value="0">Pesanan Baru</option>
                                <option value="1">Mulai Masak</option>
                                <option value="2">Mulai Pengiriman</option>
                                <option value="3">Done</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Status Pembayaran</label>
                            <select id="payment_status" class="input-sm form-control select_2" style="width:100%" name="payment_status">
                                <option value=""></option>
                                <option value="0">Pending</option>
                                <option value="1">Done</option>
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
                            <label class="control-label">Pengiriman Menggunakan</label>
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
                            <label class="control-label">Jenis Kendaraan</label>
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
                            <label class="control-label">Jenis Pengiriman</label>
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
                            <label class="control-label">Sumber</label>
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
                            <label class="control-label">Phone Pemesan</label>
                            <select id="customer_id" class="input-sm form-control select_2" style="width:100%" name="customer_id">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Provinsi</label>
                            <select id="province_id" class="input-sm form-control select_2" style="width:100%" name="province_id">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Kota</label>
                            <select id="city_id" class="input-sm form-control select_2" style="width:100%" name="city_id">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Driver</label>
                            <select id="driver_id" class="input-sm form-control select_2" style="width:100%" name="driver_id">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
                    
                    <div class="pull-right">
                        <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-save"></i> Download</span>
                            <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span></button>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
            </form>
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
           if($('#order_date_to').val() == ''){
              $('#order_date_to').val($('#order_date_from').val());
           }
        });

        $('#order_date_to').on('change',function(){
           if($('#order_date_from').val() == ''){
              $('#order_date_from').val($('#order_date_to').val());
           }
        });

        $('#clearOrderDateFrom').on('click', function () {
            $('#order_date_from').val('');
        });

        $('#clearOrderDateTo').on('click', function () {
            $('#order_date_to').val('');
        });

        $('#grand_price_from').on('change',function(){
            console.log($('#grand_price_to').val());
           if($('#grand_price_to').val() == ''){
              $('#grand_price_to').val($('#order_date_from').val());
           }
        });

        $('#grand_price_to').on('change',function(){
           if($('#grand_price_from').val() == ''){
              $('#grand_price_from').val($('#order_date_to').val());
           }
        });

        $('#clearGrandPriceFrom').on('click', function () {
            $('#grand_price_from').val('');
        });

        $('#clearGrandPriceTo').on('click', function () {
            $('#grand_price_to').val('');
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

        $('#driver_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('driver.ajax.select2')}}',
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

        $('#order_time_from').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });

        $('#order_time_to').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
        });
    });
</script>
@endpush

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
                            <label class="control-label" for="order_date">Date Range</label>
                            <div class="input-group input-group-sm date">
                                <input type="text" name="order_date_from" id="order_date_from" value="{{ old('order_date_from', request()->orderDateFrom) }}" class="form-control input-sm" readonly>
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
                    <a href="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> @lang('auth.form_user_cancel_btn')</a>
                    
                    <div class="pull-right">
                        <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-save"></i> @lang('auth.form_user_submit_btn')</span>
                            <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span></button>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('css')
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2-bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('theme/app/vendor/plugins/summernote/summernote.css')}}">
@endpush

@push('scripts')
    <script src="{{url('plugins/select2/js/select2.full.js')}}"></script>
    <script src="{{url('theme/app/vendor/plugins/summernote/summernote.min.js')}}"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                placeholder: 'Content ...*',
                tabsize: 2,
                height: 150,
                fontSizes: ['8', '9', '10', '11', '12', '13','14', '18', '24', '36', '48' , '64', '82', '150'],
                toolbar: [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "clear"]],
                    ["fontname", ["fontname"]],
                    ['fontsize', ['fontsize']],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["table", ["table"]],
                    ["insert", ["link", "hr", "video","picture"]],
                    ["view", ["fullscreen", "codeview", "help"]]
                ]
            });
        })

        $('#date').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
        });

        $('#payment_status').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
        });

        $('#delivery_option').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
        });

        $('#delivery_transport').select2({
            theme: "bootstrap",
            placeholder: "Select",
            tags: true,
            width: '100%',
            containerCssClass: ':all:',
        });

        $('#delivery_type').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
        });

        $('#transaction_type').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
        });

        $('#user_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
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

        $('#bank_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
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

        $('#source_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
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

        $('#customer_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            tags: true,
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

        $('#customer_id').on("select2:select", function() {
            const select2Data = $(this).select2("data");
            if (select2Data[0].text == select2Data[0].id) {
                $('#customer_phone').val('');
            } else {
                $('#customer_name').val(select2Data[0].name);
                $('#customer_phone').val(select2Data[0].text);
                $('#customer_province_id').append($('<option>', {
                    value: select2Data[0].province_id,
                    text: select2Data[0].province_name
                }));
                $('#customer_city_id').append($('<option>', {
                    value: select2Data[0].city_id,
                    text: select2Data[0].city_name
                }));
                $('#customer_address').val(select2Data[0].address);
            }
        });

        $('#province_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
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

        $('#customer_province_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
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

        $('#customer_province_id').on("select2:select", function() {
            $('#customer_city_id').empty();
        });

        $('#customer_city_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('city.ajax.select2')}}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term,
                        page: params.page,
                        province_id: $('#customer_province_id').val()
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

        $('#product').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('product.ajax.select2')}}',
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

        $('#hour').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
        });

        $('#minute').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
        });

        //For Place To Check Item Same Or Not
        let productData = [];

        //Ready For Append Html Form
        function htmlProduct(data) {
            let productHtml = '<tr class="product-row-' + data.id + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][product_id]" value="' + data.id + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][name]" value="' + data.text + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][price]" value="' + data.price + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][unit]" value="' + data.unit + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][total_price]" id="total_price_hidden' + data.id + '" value="' + addCommas(data.price) + '" class="total_price">';
            productHtml += '<td>' + data.text + '</td>';
            productHtml += '<td><input type="number" onchange="qty(' + data.id + ')" name="item[' + data.id + '][price]" value="' + data.price + '" min="0" class="form-control input-sm" id="price' + data.id + '" readonly></td>';
            productHtml += '<td><input type="number" onchange="qty(' + data.id + ')" name="item[' + data.id + '][qty]" value="1" min="0" class="form-control input-sm" id="qty' + data.id + '"></td>';
            productHtml += '<td>' + data.unit + '</td>';
            productHtml += '<td><textarea name="item[' + data.id + '][notes]" class="form-control input-sm" id="notes' + data.id + '"></textarea></td>';
            productHtml += '<td id="total_price' + data.id + '">' + addCommas(data.price) + '</td>';
            productHtml += '<td class="text-center"><i class="fa fa-times" onclick="removeProductList(' + data.id + ')"></i></td>';
            productHtml += '</tr>';

            $('#product-container tbody').append(productHtml);
        }

        //To Remove Product Row
        function removeProductList(productId) {
            $('.product-row-' + productId).remove();

            qty(productId);

            //Remove item in jquery array data
            productData.splice(productData.indexOf(productId.toString()), 1);
        }

        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        //Add The Product Data And Clear Product Search Data
        $('#product').on("select2:select", function() {
            //Set Product Data
            const select2Data = $(this).select2("data");

            if ($.inArray(select2Data[0].id, productData) == -1) {
                //Add Item Id To Array
                productData.push(select2Data[0].id);

                //Remove Hidden Tr SO
                $('#hidden-tr-po').remove();

                //Appent Item Html
                htmlProduct(select2Data[0]);

                qty(select2Data[0].id);
            }

            //Remove Hidden Tr SO
            $('#hidden-tr-po').remove();

            $('#product').val(null).trigger("change");
        });

        function qty(rowIndex) {
            let price = $('#price' + rowIndex).val();
            let qty = $('#qty' + rowIndex).val();

            let total_price = parseFloat(price) * parseFloat(qty);

            $('#total_price' + rowIndex).text(addCommas(total_price));
            $('#total_price_hidden' + rowIndex).val(total_price);

            grandPriceCalculate();
        }

        function grandPriceCalculate() {
            let total_price = 0;
            $('.total_price').each(function() {
                total_price += parseInt($(this).val());
            });
            
            let discount = parseInt($('#discount_price').val());
            let ongkir = parseInt($('#ongkir_price').val());

            $('#totalPrice').text(addCommas(total_price));
            $('#grandPrice').text(addCommas(total_price - discount + ongkir));
        }
    </script>
    <script>
        //Disable Enter
        $(document).keypress(function (event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });
    </script>
@endpush
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
            
            <form action="{{route('transaction.store')}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('date')) has-error @endif">
                                <label for="date" class="control-label">Date <span style="color: red">*</span></label>
                                <input type="text" name="date" id="date" value="{{old('date')}}" class="form-control input-sm" placeholder="Date ...*" readonly required>
                                {!! $errors->first('date', '<em for="date" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('hour')) has-error @endif">
                                <label for="hour" class="control-label">Hour <span style="color: red">*</span></label>
                                <input type="number" min="0" max="23" name="hour" id="hour" value="{{old('hour')}}" class="form-control input-sm" placeholder="Hour ...*" required>
                                {!! $errors->first('hour', '<em for="hour" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group @if($errors->has('minute')) has-error @endif">
                                <label for="minute" class="control-label">Minute <span style="color: red">*</span></label>
                                <input type="number" min="0" max="59" name="minute" id="minute" value="{{old('minute')}}" class="form-control input-sm" placeholder="Minute ...*" required>
                                {!! $errors->first('minute', '<em for="minute" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('payment_status')) has-error @endif">
                                <label for="payment_status" class="control-label">Payment Status <span style="color: red">*</span></label>
                                <select id="payment_status" name="payment_status" class="form-control" data-placeholder="Select Payment Status" required>
                                    <option value=""></option>
                                    <option value="0">Pending</option>
                                    <option value="1">Done</option>
                                </select>
                                {!! $errors->first('payment_status', '<em for="payment_status" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('bank_id')) has-error @endif">
                                <label for="bank_id" class="control-label">Bank <span style="color: red">*</span></label>
                                <select id="bank_id" name="bank_id" class="form-control" data-placeholder="Select Bank" required>
                                </select>
                                {!! $errors->first('bank_id', '<em for="bank_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('customer_id')) has-error @endif">
                                <label for="customer_id" class="control-label">Customer Phone <span style="color: red">*</span></label>
                                <select id="customer_id" name="customer_id" class="form-control" data-placeholder="Select Customer Phone">
                                </select>
                                <input type="hidden" name="customer_phone" id="customer_phone" value="" /> 
                                {!! $errors->first('customer_id', '<em for="customer_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('customer_name')) has-error @endif">
                                <label for="customer_name" class="control-label">Customer Name <span style="color: red">*</span></label>
                                <input type="text" name="customer_name" id="customer_name" value="{{old('customer_name')}}" class="form-control input-sm" placeholder="Customer Name ...*" required>
                                {!! $errors->first('customer_name', '<em for="customer_name" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('recipient_phone')) has-error @endif">
                                <label for="recipient_phone" class="control-label">Recipient Phone <span style="color: red">*</span></label>
                                <input type="number" name="recipient_phone" id="recipient_phone" value="{{old('recipient_phone')}}" class="form-control input-sm" placeholder="Recipient Phone ...*" required>
                                {!! $errors->first('recipient_phone', '<em for="recipient_phone" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('recipient_name')) has-error @endif">
                                <label for="recipient_name" class="control-label">Recipient Name <span style="color: red">*</span></label>
                                <input type="text" name="recipient_name" id="recipient_name" value="{{old('recipient_name')}}" class="form-control input-sm" placeholder="Recipient Name ...*" required>
                                {!! $errors->first('recipient_name', '<em for="recipient_name" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('province_id')) has-error @endif">
                                <label for="province_id" class="control-label">Province <span style="color: red">*</span></label>
                                <select id="province_id" name="province_id" class="form-control" data-placeholder="Select Province" required>
                                </select>
                                {!! $errors->first('province_id', '<em for="province_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('city_id')) has-error @endif">
                                <label for="city_id" class="control-label">City <span style="color: red">*</span></label>
                                <select id="city_id" name="city_id" class="form-control" data-placeholder="Select City" required>
                                </select>
                                {!! $errors->first('city_id', '<em for="city_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group @if($errors->has('address')) has-error @endif">
                                <label for="address" class="control-label">Address <span style="color: red">*</span></label>
                                <textarea name="address" id="address" class="form-control input-sm" placeholder="Address ...*" required>{{old('address')}}</textarea>
                                {!! $errors->first('address', '<em for="address" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('source_id')) has-error @endif">
                                <label for="source_id" class="control-label">Source <span style="color: red">*</span></label>
                                <select id="source_id" name="source_id" class="form-control" data-placeholder="Select Source" required>
                                </select>
                                {!! $errors->first('source_id', '<em for="source_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('delivery_option')) has-error @endif">
                                <label for="delivery_option" class="control-label">Delivery Option <span style="color: red">*</span></label>
                                <select id="delivery_option" name="delivery_option" class="form-control" data-placeholder="Select Delivery Option" required>
                                    <option value=""></option>
                                    <option value="Via Kaya Bumbu">Via Kaya Bumbu</option>
                                    <option value="Self Order">Self Order</option>
                                    <option value="Pick Up">Pick Up</option>
                                </select>
                                {!! $errors->first('delivery_option', '<em for="delivery_option" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('delivery_transport')) has-error @endif">
                                <label for="delivery_transport" class="control-label">Delivery Transport <span style="color: red">*</span></label>
                                <select id="delivery_transport" name="delivery_transport" class="form-control" data-placeholder="Select Delivery Transport" required>
                                    <option value=""></option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                </select>
                                {!! $errors->first('delivery_transport', '<em for="delivery_transport" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('delivery_type')) has-error @endif">
                                <label for="delivery_type" class="control-label">Delivery Type <span style="color: red">*</span></label>
                                <select id="delivery_type" name="delivery_type" class="form-control" data-placeholder="Select Delivery Type" required>
                                    <option value=""></option>
                                    <option value="Instant">Instant</option>
                                    <option value="Same Day">Same Day</option>
                                </select>
                                {!! $errors->first('delivery_type', '<em for="delivery_type" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group @if($errors->has('notes')) has-error @endif">
                                <label for="notes" class="control-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control input-sm" placeholder="Notes ...*">{{old('notes')}}</textarea>
                                {!! $errors->first('notes', '<em for="notes" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr class="short alt">
                        <label for="selectProduct" class="control-label">Select Product
                            <span style="color: red">*</span></label>
                        <div class="input-group" style="margin-top: 2%; margin-bottom: 1%">
                            <label class="input-group-addon" for="item">
                                <i class="fa fa-shopping-basket"></i>
                            </label>

                            <select id="product" class="form-control" data-placeholder="Select Product">
                                <option value=""></option>
                            </select>
                        </div>
                        {!! $errors->first('item', '<p class="text-danger">:message</p>') !!}

                        <hr class="short alt">

                        <table class="table table-hover table-condensed" id="product-container">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th width="200">Price</th>
                                    <th width="100">Qty</th>
                                    <th width="100">Unit</th>
                                    <th>Notes</th>
                                    <th>Total Price</th>
                                    <th width="50" class="text-center">
                                        <i class="fa fa-trash"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="info" id="hidden-tr-po">
                                    <td colspan="6">
                                        Please select the product
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">
                                        Total Price :
                                    </th>
                                    <th colspan="1" class="text-left"><span id="totalPrice"><strong>0</strong></span></th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-right">
                                        Discount Price :
                                    </th>
                                    <th colspan="1" class="text-left">
                                        <input type="number" name="discount_price" id="discount_price" value="0" class="form-control input-sm" placeholder="Discount Price ...*" min="0" onchange="grandPriceCalculate()" required>
                                        {!! $errors->first('discount_price', '<em for="discount_price" class="text-danger">:message</em>') !!}
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-right">
                                        Ongkir Customer Price :
                                    </th>
                                    <th colspan="1" class="text-left">
                                        <input type="number" name="ongkir_price" id="ongkir_price" value="0" class="form-control input-sm" placeholder="Ongkir Price ...*" min="0" onchange="grandPriceCalculate()" required>
                                        {!! $errors->first('ongkir_price', '<em for="ongkir_price" class="text-danger">:message</em>') !!}
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-right">
                                        Grand Total Price :
                                    </th>
                                    <th colspan="1" class="text-left"><span id="grandPrice"><strong>0</strong></span></th>
                                    <th>&nbsp;</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-right">
                                        Ongkir Driver Price :
                                    </th>
                                    <th colspan="1" class="text-left">
                                        <input type="number" name="ongkir_driver_price" id="ongkir_driver_price" value="0" class="form-control input-sm" placeholder="Ongkir Driver Price ...*" min="0" required>
                                        {!! $errors->first('ongkir_driver_price', '<em for="ongkir_driver_price" class="text-danger">:message</em>') !!}
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>
                            </tfoot>
                        </table>

                        <hr class="short alt">

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
                $('#province_id').append($('<option>', {
                    value: select2Data[0].province_id,
                    text: select2Data[0].province_name
                }));
                $('#province_id').val(select2Data[0].province_id).change();
                $('#city_id').append($('<option>', {
                    value: select2Data[0].city_id,
                    text: select2Data[0].city_name
                }));
                $('#city_id').val(select2Data[0].city_id).change();
                $('#address').val(select2Data[0].address);
                $('#customer_name').val(select2Data[0].name);
                $('#customer_phone').val(select2Data[0].text);
                $('#recipient_name').val(select2Data[0].name);
                $('#recipient_phone').val(select2Data[0].text);
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
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
                        <div class="form-group @if($errors->has('date')) has-error @endif">
                            <label for="date" class="control-label">Date <span style="color: red">*</span></label>
                            <input type="text" name="date" id="date" value="{{old('date')}}" class="form-control input-sm" placeholder="Date ...*" readonly required>
                            {!! $errors->first('date', '<em for="date" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('discount')) has-error @endif">
                            <label for="discount" class="control-label">Discount <span style="color: red">*</span></label>
                            <input type="number" name="discount" id="discount" value="{{old('discount')}}" class="form-control input-sm" placeholder="Discount ...*" min="0" required>
                            {!! $errors->first('discount', '<em for="discount" class="text-danger">:message</em>') !!}
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
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th width="100">Qty</th>
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
            productHtml += '<td>';
            productHtml += data.code;
            productHtml += '<input type="hidden" name="item[' + data.id + '][product_id]" value="' + data.id + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][code]" value="' + data.code + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][name]" value="' + data.text + '">';
            productHtml += '<input type="hidden" name="item[' + data.id + '][price]" value="' + data.price + '">';
            productHtml += '<td>';
            productHtml += data.text;
            productHtml += '</td>';
            productHtml += '<td><input type="number" name="item[' + data.id + '][price]" value="' + data.price + '" min="0" class="form-control input-sm" id="price' + data.id + '"></td>';
            productHtml += '<td><input type="number" name="item[' + data.id + '][qty]" value="1" min="0" class="form-control input-sm" id="qty' + data.id + '"></td>';
            productHtml += '<td>';
            productHtml += addCommas(data.price);
            productHtml += '</td>';
            productHtml += '<td class="text-center">';
            productHtml += '<i class="fa fa-times" onclick="removeProductList(' + data.id + ')"></i>';
            productHtml += '</td>';
            productHtml += '</tr>';

            $('#product-container tbody').append(productHtml);
        }

        //To Remove Product Row
        function removeProductList(productId) {
            $('.product-row-' + productId).remove();

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
            }

            //Remove Hidden Tr SO
            $('#hidden-tr-po').remove();

            $('#product').val(null).trigger("change");
        });
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
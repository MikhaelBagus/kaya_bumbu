@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
        
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Product Create Form
                </div>
            </div>
            
            <form action="{{route('product.store')}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            <label for="name" class="control-label">Name <span style="color: red">*</span></label>
                            <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control input-sm" placeholder="Name ...*" required>
                            {!! $errors->first('name', '<em for="name" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('price')) has-error @endif">
                            <label for="price" class="control-label">Price <span style="color: red">*</span></label>
                            <input type="number" name="price" id="price" value="{{old('price')}}" class="form-control input-sm" placeholder="Price ...*" min="0" required>
                            {!! $errors->first('price', '<em for="price" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('quota_per_day')) has-error @endif">
                            <label for="quota_per_day" class="control-label">Quota Per Day <span style="color: red">*</span></label>
                            <input type="number" name="quota_per_day" id="quota_per_day" value="{{old('quota_per_day')}}" class="form-control input-sm" placeholder="Quota Per Day ...*" required>
                            {!! $errors->first('quota_per_day', '<em for="quota_per_day" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr class="short alt">
                        <label for="selectProduct" class="control-label">Select Ingredient
                            <span style="color: red">*</span></label>
                        <div class="input-group" style="margin-top: 2%; margin-bottom: 1%">
                            <label class="input-group-addon" for="item">
                                <i class="fa fa-shopping-basket"></i>
                            </label>

                            <select id="ingredient" class="form-control" data-placeholder="Select Ingredient">
                                <option value=""></option>
                            </select>
                        </div>
                        {!! $errors->first('item', '<p class="text-danger">:message</p>') !!}

                        <hr class="short alt">

                        <table class="table table-hover table-condensed" id="ingredient-container">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th width="100">Qty</th>
                                    <th>Unit</th>
                                    <th width="50" class="text-center">
                                        <i class="fa fa-trash"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="info" id="hidden-tr-po">
                                    <td colspan="6">
                                        Please select the ingredient
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

        $('#ingredient').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('ingredient.ajax.select2')}}',
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
        let ingredientData = [];

        //Ready For Append Html Form
        function htmlIngredient(data) {
            let ingredientHtml = '<tr class="ingredient-row-' + data.id + '">';
            ingredientHtml += '<td>';
            ingredientHtml += data.code;
            ingredientHtml += '<input type="hidden" name="item[' + data.id + '][ingredient_id]" value="' + data.id + '">';
            ingredientHtml += '<input type="hidden" name="item[' + data.id + '][code]" value="' + data.code + '">';
            ingredientHtml += '<input type="hidden" name="item[' + data.id + '][name]" value="' + data.text + '">';
            ingredientHtml += '<input type="hidden" name="item[' + data.id + '][unit]" value="' + data.unit + '">';
            ingredientHtml += '<td>';
            ingredientHtml += data.text;
            ingredientHtml += '</td>';
            ingredientHtml += '<td><input type="number" name="item[' + data.id + '][qty]" value="1" min="0" class="form-control input-sm" id="qty' + data.id + '"></td>';
            ingredientHtml += '<td>';
            ingredientHtml += data.unit;
            ingredientHtml += '</td>';
            ingredientHtml += '<td class="text-center">';
            ingredientHtml += '<i class="fa fa-times" onclick="removeIngredientList(' + data.id + ')"></i>';
            ingredientHtml += '</td>';
            ingredientHtml += '</tr>';

            $('#ingredient-container tbody').append(ingredientHtml);
        }

        //To Remove Ingredient Row
        function removeIngredientList(ingredientId) {
            $('.ingredient-row-' + ingredientId).remove();

            //Remove item in jquery array data
            ingredientData.splice(ingredientData.indexOf(ingredientId.toString()), 1);
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

        //Add The Ingredient Data And Clear Ingredient Search Data
        $('#ingredient').on("select2:select", function() {
            //Set Ingredient Data
            const select2Data = $(this).select2("data");

            if ($.inArray(select2Data[0].id, ingredientData) == -1) {
                //Add Item Id To Array
                ingredientData.push(select2Data[0].id);

                //Remove Hidden Tr SO
                $('#hidden-tr-po').remove();

                //Appent Item Html
                htmlIngredient(select2Data[0]);
            }

            //Remove Hidden Tr SO
            $('#hidden-tr-po').remove();

            $('#ingredient').val(null).trigger("change");
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
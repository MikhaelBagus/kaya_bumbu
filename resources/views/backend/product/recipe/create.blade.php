@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
        
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-plus"></span>Add Product Recipe
                </div>
            </div>
            
            <form action="{{route('product.recipe.store')}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('product_id')) has-error @endif">
                            <label for="product_id" class="control-label">Product <span style="color: red">*</span></label>
                            <select id="product_id" name="product_id" class="form-control" data-placeholder="Select Product" required>
                            </select>
                            {!! $errors->first('product_id', '<em for="product_id" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('ingredient_master_id')) has-error @endif">
                            <label for="ingredient_master_id" class="control-label">Ingredient <span style="color: red">*</span></label>
                            <select id="ingredient_master_id" name="ingredient_master_id" class="form-control" data-placeholder="Select Ingredient" required>
                            </select>
                            {!! $errors->first('ingredient_master_id', '<em for="ingredient_master_id" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('qty')) has-error @endif">
                            <label for="qty" class="control-label">Quantity <span style="color: red">*</span></label>
                            <input type="number" step="0.01" min="0" name="qty" id="qty" value="{{old('qty')}}" class="form-control input-sm" placeholder="Quantity ...*" required>
                            {!! $errors->first('qty', '<em for="qty" class="text-danger">:message</em>') !!}
                            <small class="text-muted">Enter the quantity needed for this recipe</small>
                        </div>
                    </div>

                </div>

                <div class="panel-footer">
                    <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
                    <a href="{{route('product.recipe.index')}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> Back to Recipe List</a>
                    
                    <div class="pull-right">
                        <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-save"></i> Save Recipe</span>
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

            $('#product_id').select2({
                theme: "bootstrap",
                placeholder: "Select Product",
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

            $('#ingredient_master_id').select2({
                theme: "bootstrap",
                placeholder: "Select Ingredient",
                width: '100%',
                containerCssClass: ':all:',
                ajax: {
                    url: '/api/ingredient-masters',
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
                        // Transform the API response to Select2 format
                        let results = data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name + ' (' + item.unit + ')'
                            };
                        });
                        return {
                            results: results,
                            pagination: {
                                more: false // Simple pagination for now
                            }
                        };
                    },
                    cache: true,
                }
            });

            // Pre-select product if passed via URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('product_id');
            if (productId) {
                // You can add logic here to pre-select the product
                $('#product_id').val(productId).trigger('change');
            }
        })
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
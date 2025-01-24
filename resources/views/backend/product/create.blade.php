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
                        <div class="form-group @if($errors->has('product_category_id')) has-error @endif">
                            <label for="product_category_id" class="control-label">Product Category <span style="color: red">*</span></label>
                            <select id="product_category_id" name="product_category_id" class="form-control" data-placeholder="Select Product Category" required>
                            </select>
                            {!! $errors->first('product_category_id', '<em for="product_category_id" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

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
                        <div class="form-group @if($errors->has('unit')) has-error @endif">
                            <label for="unit" class="control-label">Unit <span style="color: red">*</span></label>
                            <input type="text" name="unit" id="unit" value="{{old('unit')}}" class="form-control input-sm" placeholder="Unit ...*" required>
                            {!! $errors->first('unit', '<em for="unit" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('value')) has-error @endif">
                            <label for="value" class="control-label">Value <span style="color: red">*</span></label>
                            <input type="number" name="value" id="value" value="{{old('value')}}" class="form-control input-sm" placeholder="Value ...*" min="0" required>
                            {!! $errors->first('value', '<em for="value" class="text-danger">:message</em>') !!}
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

            $('#product_category_id').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                containerCssClass: ':all:',
                ajax: {
                    url: '{{route('product_category.ajax.select2')}}',
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
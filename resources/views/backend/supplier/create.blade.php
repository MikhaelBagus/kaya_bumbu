@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Supplier Create Form
                </div>
            </div>

            <form action="{{route('supplier.store')}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('supplier_name')) has-error @endif">
                            <label for="supplier_name" class="control-label">Supplier Name <span style="color: red">*</span></label>
                            <input type="text" name="supplier_name" id="supplier_name" value="{{old('supplier_name')}}" class="form-control input-sm" placeholder="Supplier Name ...*" required>
                            {!! $errors->first('supplier_name', '<em for="supplier_name" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('supplier_phone')) has-error @endif">
                            <label for="supplier_phone" class="control-label">Supplier Phone </label>
                            <input type="number" name="supplier_phone" id="supplier_phone" value="{{old('supplier_phone')}}" class="form-control input-sm" placeholder="Supplier Phone ...">
                            {!! $errors->first('supplier_phone', '<em for="supplier_phone" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('supplier_description')) has-error @endif">
                            <label for="supplier_description" class="control-label">Supplier Description</label>
                            <textarea name="supplier_description" id="supplier_description" class="form-control input-sm" placeholder="Supplier Description ..." rows="3">{{old('supplier_description')}}</textarea>
                            {!! $errors->first('supplier_description', '<em for="supplier_description" class="text-danger">:message</em>') !!}
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('supplier_account_number')) has-error @endif">
                            <label for="supplier_account_number" class="control-label">Supplier Account Number <span style="color: red">*</span></label>
                            <input type="text" name="supplier_account_number" id="supplier_account_number" value="{{old('supplier_account_number')}}" class="form-control input-sm" placeholder="Supplier Account Number ...*" required>
                            {!! $errors->first('supplier_account_number', '<em for="supplier_account_number" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('supplier_account_name')) has-error @endif">
                            <label for="supplier_account_name" class="control-label">Supplier Account Name <span style="color: red">*</span></label>
                            <input type="text" name="supplier_account_name" id="supplier_account_name" value="{{old('supplier_account_name')}}" class="form-control input-sm" placeholder="Supplier Account Name ...*" required>
                            {!! $errors->first('supplier_account_name', '<em for="supplier_account_name" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('supplier_account_bank_name')) has-error @endif">
                            <label for="supplier_account_bank_name" class="control-label">Supplier Account Bank Name <span style="color: red">*</span></label>
                            <input type="text" name="supplier_account_bank_name" id="supplier_account_bank_name" value="{{old('supplier_account_bank_name')}}" class="form-control input-sm" placeholder="Supplier Account Bank Name ...*" required>
                            {!! $errors->first('supplier_account_bank_name', '<em for="supplier_account_bank_name" class="text-danger">:message</em>') !!}
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
@endpush

@push('scripts')
    <script src="{{url('plugins/select2/js/select2.full.js')}}"></script>

    <script>
        //Disable Enter
        $(document).keypress(function (event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });
    </script>
@endpush

@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Supplier Account Update Form
                </div>
            </div>

            <form action="{{route('supplier_account.update', $supplier_account->id)}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('supplier_id')) has-error @endif">
                            <label for="supplier_id" class="control-label">Supplier <span style="color: red">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="form-control input-sm select2" required>
                                @if($supplier_account->supplier)
                                    <option value="{{$supplier_account->supplier->id}}" selected>{{$supplier_account->supplier->supplier_name}}</option>
                                @endif
                            </select>
                            {!! $errors->first('supplier_id', '<em for="supplier_id" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('account_number')) has-error @endif">
                            <label for="account_number" class="control-label">Account Number <span style="color: red">*</span></label>
                            <input type="text" name="account_number" id="account_number" value="{{old('account_number', $supplier_account->account_number)}}" class="form-control input-sm" placeholder="Account Number ...*" required>
                            {!! $errors->first('account_number', '<em for="account_number" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('account_name')) has-error @endif">
                            <label for="account_name" class="control-label">Account Name <span style="color: red">*</span></label>
                            <input type="text" name="account_name" id="account_name" value="{{old('account_name', $supplier_account->account_name)}}" class="form-control input-sm" placeholder="Account Name ...*" required>
                            {!! $errors->first('account_name', '<em for="account_name" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('bank_name')) has-error @endif">
                            <label for="bank_name" class="control-label">Bank Name <span style="color: red">*</span></label>
                            <input type="text" name="bank_name" id="bank_name" value="{{old('bank_name', $supplier_account->bank_name)}}" class="form-control input-sm" placeholder="Bank Name ...*" required>
                            {!! $errors->first('bank_name', '<em for="bank_name" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('description')) has-error @endif">
                            <label for="description" class="control-label">Description</label>
                            <textarea name="description" id="description" class="form-control input-sm" placeholder="Description ..." rows="3">{{old('description', $supplier_account->description)}}</textarea>
                            {!! $errors->first('description', '<em for="description" class="text-danger">:message</em>') !!}
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

        // Select2 for Supplier
        $('#supplier_id').select2({
            placeholder: "-- Select Supplier --",
            allowClear: true,
            ajax: {
                url: "{{ route('supplier.ajax.select2') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            }
        });
    </script>
@endpush

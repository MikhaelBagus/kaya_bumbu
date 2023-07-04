@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>@lang('auth.form_user_heading')
                </div>
            </div>

            <form action="{{route('users.update', $data->id)}}" method="post">
                <input name="_method" type="hidden" value="PUT">
                <div class="panel-body">
                    {!! csrf_field() !!}

                     <div class="col-md-6">
                        <input type="hidden" value="{{$data->id}}" name="id">
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            <label for="name" class="control-label">@lang('auth.index_name_th') <span style="color: red">*</span></label>
                            <input type="text" name="name" class="form-control input-sm" placeholder="@lang('auth.index_name_th')" value="{{ old('name') ?? $data->name }}" tabindex="1" required>
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>

                         <div class="form-group @if($errors->has('email')) has-error @endif">
                             <label for="email" class="control-label">Username <span style="color: red">*</span></label>
                             <input type="text" name="email" class="form-control input-sm" placeholder="Username ...*" value="{{ old('email') ?? $data->email }}" tabindex="3" required>
                             {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                         </div>

                         <div class="form-group @if($errors->has('password')) has-error @endif">
                             <label for="password" class="control-label">@lang('auth.form_user_password_label') </label>
                             <input type="password" name="password" class="form-control input-sm" placeholder="@lang('auth.form_user_password_label')" value="{{old('password')}}" tabindex="5">
                             <span class="help-block margin-top-sm">{{trans('auth.form_user_password_long')}}</span>
                             {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                         </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('phone')) has-error @endif">
                            <label for="phone" class="control-label">@lang('auth.form_user_phone_label') <span style="color: red">*</span></label>
                            <input type="number" name="phone" class="form-control input-sm" placeholder="@lang('auth.form_user_phone_label')" value="{{ old('phone') ?? $data->phone }}" tabindex="1" required>
                            {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group @if($errors->has('role')) has-error @endif">
                            <label for="role" class="control-label">@lang('auth.form_user_role_label') <span style="color: red">*</span></label>

                            <select name="role" class="form-control input-sm" data-placeholder="@lang('auth.form_user_role_select')" tabindex="4" id="roleSelect" required>
                                <option value="{{$data->user_role->role->id}}" selected="selected">{{$data->user_role->role->name}}</option>
                            </select>
                            {!! $errors->first('role', '<p class="text-danger">:message</p>') !!}

                        </div>

                        <div class="form-group @if($errors->has('password')) has-error @endif">
                            <label for="password_confirmation" class="control-label">@lang('auth.form_user_password_confirm_label') </label>
                            <input type="password" name="password_confirmation" class="form-control input-sm" placeholder="@lang('auth.form_user_password_confirm_label')" value="{{old('password_confirmation')}}" tabindex="6">
                            <span class="help-block margin-top-sm">@lang('auth.form_user_password_type_again')</span>
                            {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
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

    <script type="text/javascript">
        $('#roleSelect').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('roles.ajax.select2')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {

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

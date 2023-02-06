@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
    
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>@lang('auth.index_roles')
                </div>
            </div>
    
            <form action="{{route('roles.update', $dataDb->id)}}" method="post">
                <input name="_method" type="hidden" value="PUT">
                <div class="panel-body">
                    {!! csrf_field() !!}
    
                    <div class="form-group">
                        <label for="name">@lang('global.name') <span style="color: red">*</span></label>
                        <input type="text" name="name" class="form-control input-sm" placeholder="@lang('global.name')" value="{{ old('name') ?? $dataDb->name }}">
                        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                    </div>
    
                    <div class="tab-block mb25">
                        <ul class="nav tabs-left tabs-border">
                            <li role="presentation" class="active"><a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">Access Control List</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- For Auth Form -->
                            <div role="tabpanel" class="tab-pane active" id="auth">
                                @include('auth.role.roles')
                            </div>
        
                        </div>
                    </div>
                </div>
    
                <div class="panel-footer">
                    <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
                    <a href="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> @lang('global.cancel')</a>
        
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
@stop

@push('scripts')
    <script>
        //Disable Enter
        $(document).keypress(function (event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });
    </script>
@endpush


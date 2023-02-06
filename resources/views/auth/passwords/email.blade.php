@extends('auth.layout')

@section('content')

<section id="content" class="animated fadeIn">
    <div class="admin-form theme-info mw500" style="margin-top: 10%;" id="login">
        <div class="row mb15 table-layout">
            <div class="col-xs-6 pln">
                &nbsp;
            </div>
            <div class="col-xs-6 va-b">
                <div class="login-links text-right">
                    @include('auth.login-links')
                </div>
            </div>
        </div>
        <div class="panel panel-info heading-border br-n">
            <form class="form-horizontal" method="POST" action="{{ route('auth.forgot.password.send.reset.link') }}">
                {{ csrf_field() }}
                <div class="panel-body p15 pt25">
                    <label class="field-label text-muted fs18 mb10">Forgot Password Admin</label>
                    @include('flash')

                    <div class="alert alert-micro alert-border-left alert-info pastel alert-dismissable mn">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fa fa-info pr10"></i> Please enter your email so we can send you an email to reset your password.
                    </div>
                </div>

                <div class="panel-footer p25 pv15">
                    <div class="section mn">
                        <div class="smart-widget sm-right smr-80">
                            <label for="email" class="field prepend-icon">
                                <input type="text" name="email" id="email" class="gui-input" placeholder="@lang('auth.forgot_password_validation_email_label')">
                                <label for="email" class="field-icon">
                                    <i class="fa fa-envelope-o"></i>
                                </label>
                            </label>
                            <button name="" type="submit" class="button">@lang('auth.forgot_password_submit_btn')</button>

                            {!! $errors->first('email', '<em for="email" class="text-danger">:message</em>') !!}
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</section>
@endsection

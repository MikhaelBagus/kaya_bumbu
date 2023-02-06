@extends('auth.layout')
@section('content')
    <section id="content" class="animated fadeIn">
        <div class="admin-form theme-info mw500" style="margin-top: 10%;" id="login">
            <div class="row mb15 table-layout">
                <div class="col-xs-6 pln">
                    &nbsp;
                </div>
                <div class="col-xs-6 va-b">
                </div>
            </div>
            <div class="panel panel-info heading-border br-n">
                <form class="form-horizontal">
                    <div class="panel-body p25 bg-light">
                        @include('flash')
                    </div>

                    <div class="panel-footer clearfix p10 ph15">
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop
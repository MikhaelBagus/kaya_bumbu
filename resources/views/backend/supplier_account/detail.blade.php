@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Supplier Account Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$supplier_account->id}}
                        </dd>
                        <dt class="text-left">
                            Supplier Name
                        </dt>
                        <dd>
                            : {{$supplier_account->supplier ? $supplier_account->supplier->supplier_name : '-'}}
                        </dd>
                        <dt class="text-left">
                            Account Number
                        </dt>
                        <dd>
                            : {{$supplier_account->account_number}}
                        </dd>
                        <dt class="text-left">
                            Account Name
                        </dt>
                        <dd>
                            : {{$supplier_account->account_name}}
                        </dd>
                        <dt class="text-left">
                            Bank Name
                        </dt>
                        <dd>
                            : {{$supplier_account->bank_name}}
                        </dd>
                        <dt class="text-left">
                            Description
                        </dt>
                        <dd>
                            : {{$supplier_account->description ? $supplier_account->description : '-'}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('supplier_account.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('supplier_account.edit', [$supplier_account->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection

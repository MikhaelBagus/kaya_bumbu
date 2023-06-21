@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Customer Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$customer->id}}
                        </dd>
                        <dt class="text-left">
                            Name
                        </dt>
                        <dd>
                            : {{$customer->name}}
                        </dd>
                        <dt class="text-left">
                            Phone
                        </dt>
                        <dd>
                            : {{$customer->phone}}
                        </dd>
                        <dt class="text-left">
                            Province
                        </dt>
                        <dd>
                            : {{$customer->city->province->name}}
                        </dd>
                        <dt class="text-left">
                            City
                        </dt>
                        <dd>
                            : {{$customer->city->name}}
                        </dd>
                        <dt class="text-left">
                            Address
                        </dt>
                        <dd>
                            : {{$customer->address}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('customer.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('customer.edit', [$customer->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
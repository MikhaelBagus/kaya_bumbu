@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Term Condition Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$term_condition->id}}
                        </dd>
                        <dt class="text-left">
                            Content
                        </dt>
                        <dd>
                            : {!!$term_condition->content!!}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('term_condition.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('term_condition.edit', [$term_condition->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
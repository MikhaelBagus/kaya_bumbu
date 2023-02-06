@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Faq Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$faq->id}}
                        </dd>
                        <dt class="text-left">
                            Question
                        </dt>
                        <dd>
                            : {{$faq->question}}
                        </dd>
                        <dt class="text-left">
                            Answer
                        </dt>
                        <dd>
                            : {{$faq->answer}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('faq.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('faq.edit', [$faq->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
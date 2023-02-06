@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>News Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$news->id}}
                        </dd>
                        <dt class="text-left">
                            Title
                        </dt>
                        <dd>
                            : {{$news->title}}
                        </dd>
                        <dt class="text-left">
                            Content
                        </dt>
                        <dd>
                            : {!!$news->content!!}
                        </dd>
                        <dt class="text-left">
                            Image
                        </dt>
                        <dd>
                            : @if($news->image == '')@else<img src="{{$news->image}}" height="100px">@endif
                        </dd><dt class="text-left">
                            Publish
                        </dt>
                        <dd>
                            : @if($news->publish == 1) Yes
                            @elseif($news->publish == 0) No
                            @endif
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('news.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('news.edit', [$news->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
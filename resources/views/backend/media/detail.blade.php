@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Media Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$media->id}}
                        </dd>
                        <dt class="text-left">
                            Type
                        </dt>
                        <dd>
                            : {{$media->type}}
                        </dd>
                        <dt class="text-left">
                            Url
                        </dt>
                        <dd>
                            : @if($media->url == '')
                            @else
                            <a href="{{$media->url}}" target="_blank">{{$media->url}}</a>
                            @endif
                        </dd>
                        <dt class="text-left">
                            View
                        </dt>
                        <dd>
                            : @if($media->type == 'image')
                                @if($media->url == '')
                                @else
                                <img src="{{$media->url}}" height="100px">
                                @endif
                            @endif
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('media.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
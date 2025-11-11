@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Ingredient Master Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$ingredient->id}}
                        </dd>
                        <dt class="text-left">
                            Name
                        </dt>
                        <dd>
                            : {{$ingredient->name}}
                        </dd>
                        <dt class="text-left">
                            Unit
                        </dt>
                        <dd>
                            : {{$ingredient->unit}}
                        </dd>
                        <dt class="text-left">
                            Created At
                        </dt>
                        <dd>
                            : {{$ingredient->created_at->format('d/m/Y H:i:s')}}
                        </dd>
                        <dt class="text-left">
                            Updated At
                        </dt>
                        <dd>
                            : {{$ingredient->updated_at->format('d/m/Y H:i:s')}}
                        </dd>
                    </dl>
                </div>

                @if($ingredient->productRecipes->count() > 0)
                <div class="col-md-12">
                    <h4>Used in Products:</h4>
                    <ul>
                        @foreach($ingredient->productRecipes as $recipe)
                            <li>{{$recipe->product->name}} (Qty: {{$recipe->qty}})</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('product.ingredient.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('product.ingredient.edit', [$ingredient->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
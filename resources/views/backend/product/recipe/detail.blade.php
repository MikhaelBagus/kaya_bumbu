@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Product Detail
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            ID
                        </dt>
                        <dd>
                            : {{$product->id}}
                        </dd>
                        <dt class="text-left">
                            Product Category Name
                        </dt>
                        <dd>
                            : {{$product->product_category->name}}
                        </dd>
                        <dt class="text-left">
                            Name
                        </dt>
                        <dd>
                            : {{$product->name}}
                        </dd>
                        <dt class="text-left">
                            Price
                        </dt>
                        <dd>
                            : Rp {{number_format($product->price,0,',','.')}}
                        </dd>
                        <dt class="text-left">
                            Unit
                        </dt>
                        <dd>
                            : {{$product->unit}}
                        </dd>
                        <dt class="text-left">
                            Value
                        </dt>
                        <dd>
                            : {{number_format($product->value,0,',','.')}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('product.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="pull-right">
                    <a href="{{route('product.edit', [$product->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('global.update')</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
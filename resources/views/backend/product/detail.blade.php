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
                            Code
                        </dt>
                        <dd>
                            : {{$product->code}}
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
                            : Rp {{number_format($product->price,0,'.',',')}}
                        </dd>
                        <dt class="text-left">
                            Quota Per Day
                        </dt>
                        <dd>
                            : {{number_format($product->quota_per_day,0,'.',',')}}
                        </dd>
                    </dl>
                </div>

                <div class="clearfix"></div>
            </div>

            <table class="table table-striped table-bordered table-hover table-condensed" id="product-ingredient-table" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0; ?>
                    @foreach($product->product_ingredient as $productIngredient)
                    <?php $no = $no + 1; ?>
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$productIngredient->ingredient->code}}</td>
                        <td>{{$productIngredient->ingredient->name}}</td>
                        <td>{{number_format($productIngredient->qty,0,'.',',')}}</td>
                        <td>{{$productIngredient->ingredient->unit}}</td>
                    </tr>
                    @empty
                    @endforeach
                </tbody>
            </table>

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
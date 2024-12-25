@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Product Ranking Detail
                    <div class="pull-right">
                        <a href="{{route('product_ranking.show', [$prevMonthText, $prevYearText])}}" class="btn btn-warning btn-sm"></i> Prev Month</a>
                        <a href="{{route('product_ranking.show', [$nextMonthText, $nextYearText])}}" class="btn btn-warning btn-sm"></i> Next Month</a>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            Periode
                        </dt>
                        <dd>
                            : {{$monthText}} {{$year}}
                        </dd>
                    </dl>
                </div>

                <table class="table table-striped table-bordered table-hover table-condensed" id="transaction-product-table" width="100%">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Item</th>
                            <th>Total Item</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 0; ?>
                        @foreach($product_ranking as $productRankingEach)
                        <?php $count = $count + 1; ?>
                        <tr>
                            <td>
                                {{$count}}
                            </td>
                            <td>
                                {{$productRankingEach->product_name}}
                            </td>
                            <td>
                                {{$productRankingEach->total_qty}}
                            </td>
                            <td>
                                Rp {{number_format($productRankingEach->total_price,0,',','.')}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('product_ranking.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
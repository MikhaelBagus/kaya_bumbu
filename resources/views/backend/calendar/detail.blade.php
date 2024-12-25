@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Calendar Detail
                    <div class="pull-right">
                        <a href="{{route('calendar.show', [$prevMonthText, $prevYearText])}}" class="btn btn-warning btn-sm"></i> Prev Month</a>
                        <a href="{{route('calendar.show', [$nextMonthText, $nextYearText])}}" class="btn btn-warning btn-sm"></i> Next Month</a>
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
                            <th></th>
                            <th>00:00</th>
                            <th>01:00</th>
                            <th>02:00</th>
                            <th>03:00</th>
                            <th>04:00</th>
                            <th>05:00</th>
                            <th>06:00</th>
                            <th>07:00</th>
                            <th>08:00</th>
                            <th>09:00</th>
                            <th>10:00</th>
                            <th>11:00</th>
                            <th>12:00</th>
                            <th>13:00</th>
                            <th>14:00</th>
                            <th>15:00</th>
                            <th>16:00</th>
                            <th>17:00</th>
                            <th>18:00</th>
                            <th>19:00</th>
                            <th>20:00</th>
                            <th>21:00</th>
                            <th>22:00</th>
                            <th>23:00</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calendar as $calendarEach)
                        <tr>
                            <td>
                                {{date("d M Y", strtotime($calendarEach['date']))}}
                            </td>
                            @foreach($calendarEach['hour'] as $hourEach)
                            <?php $day = date("d", strtotime($calendarEach['date'])); ?>
                            @if($hourEach['count'] == 0)
                            <td style="text-align: center;">
                            </td>
                            @elseif($hourEach['count'] <= 80)
                            <td style="text-align: center; background-color: lightgreen;">
                                <a href="{{route('calendar.show_detail', [$month, $year, $day, $hourEach['hour']])}}">{{$hourEach['count']}}</a>
                            </td>
                            @elseif($hourEach['count'] <= 150)
                            <td style="text-align: center; background-color: yellow;">
                                <a href="{{route('calendar.show_detail', [$month, $year, $day, $hourEach['hour']])}}">{{$hourEach['count']}}</a>
                            </td>
                            @else
                            <td style="text-align: center; background-color: pink;">
                                <a href="{{route('calendar.show_detail', [$month, $year, $day, $hourEach['hour']])}}">{{$hourEach['count']}}</a>
                            </td>
                            @endif
                            @endforeach
                            <td style="text-align: center;">
                                {{$calendarEach['total']}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{route('calendar.index')}}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection
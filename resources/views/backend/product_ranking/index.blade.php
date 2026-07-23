@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Product Ranking Periode List
                </div>
            </div>

            <div class="panel panel-default" style="margin-bottom:15px">
                <div class="panel-heading">
                    Filter Berdasarkan Rentang Tanggal
                </div>
                <div class="panel-body">
                    <form action="{{ route('product_ranking.show_date') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="date_from">Tanggal Mulai</label>
                                    <div class="input-group input-group-sm date">
                                        <input type="text" name="date_from" id="date_from"
                                            value="{{ old('date_from') }}" class="form-control input-sm"
                                            readonly required>
                                        <label class="input-group-addon input-sm" for="date_from">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                    </div>
                                    {!! $errors->first('date_from', '<em class="text-danger">:message</em>') !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="date_to">Tanggal Akhir</label>
                                    <div class="input-group input-group-sm date">
                                        <input type="text" name="date_to" id="date_to"
                                            value="{{ old('date_to') }}" class="form-control input-sm"
                                            readonly required>
                                        <label class="input-group-addon input-sm" for="date_to">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                    </div>
                                    {!! $errors->first('date_to', '<em class="text-danger">:message</em>') !!}
                                </div>
                            </div>

                            <div class="col-md-3" style="padding-top:22px">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-search"></i> Tampilkan Ranking
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-striped table-bordered table-hover table-condensed" id="product-ranking-table" width="100%">
                <thead>
                <tr>
                    <th style="text-align: center;">#</th>
                    <th>Periode</th>
                    <th style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    @foreach($periode as $periodeEach)
                    <?php $count = $count + 1; ?>
                    <tr>
                        <td style="text-align: center;">{{$count}}</td>
                        <td>{{$periodeEach['monthText']}} {{$periodeEach['year']}}</td>
                        <td style="text-align: center;"><a href="{{route('product_ranking.show', [$periodeEach['month'], $periodeEach['year']])}}" id="tooltip" title="Show"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@stop

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.plugins.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/extensions/Buttons/css/buttons.bootstrap.min.css')}}">

<link rel="stylesheet" href="{{url('plugins/select2/css/select2.css')}}">
<link rel="stylesheet" href="{{url('plugins/select2/css/select2-bootstrap.css')}}">
@endpush

@push('scripts')
<!-- DataTables -->

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<script src="{{url('plugins/jquery-number/jquery.number.min.js')}}"></script>
<script src="{{url('plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Buttons/js/buttons.bootstrap.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Checkboxes/dataTables.checkboxes.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Pagination/full_numbers_no_ellipses.js')}}"></script>

<script src="{{url('plugins/select2/js/select2.full.js')}}"></script>

<script>
    $(function () {
        $('#date_from').datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth: true,
            changeYear : true,
            yearRange  : "-100:+2",
            onSelect: function(selectedDate) {
                $('#date_to').datepicker('option', 'minDate', selectedDate);

                if ($('#date_to').val() === '') {
                    $('#date_to').val(selectedDate);
                }
            }
        });

        $('#date_to').datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth: true,
            changeYear : true,
            yearRange  : "-100:+2",
            minDate    : $('#date_from').val() || null
        });
    });
</script>
@endpush

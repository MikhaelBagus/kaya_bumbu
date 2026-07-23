@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Product Ranking Detail - Rentang Tanggal
                </div>
            </div>

            <input type="hidden" name="filter_type" id="filter_type" value="date">
            <input type="hidden" name="date_from" id="date_from" value="{{ $dateFrom }}">
            <input type="hidden" name="date_to" id="date_to" value="{{ $dateTo }}">

            <div class="panel panel-default" style="margin-bottom:0px">
                <div class="panel-heading">
                    Filter
                </div>
                <div class="panel-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Product Category</label>
                                    <select id="product_category_id" class="input-sm form-control select_2"
                                        style="width:100%" name="product_category_id">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="button" id="choose" class="btn btn-success btn-sm">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <dl class="dl-horizontal">
                        <dt class="text-left">
                            Periode
                        </dt>
                        <dd>
                            : {{ \Carbon\Carbon::parse($dateFrom)->format('d-m-Y') }}
                            s/d {{ \Carbon\Carbon::parse($dateTo)->format('d-m-Y') }}
                        </dd>
                        <dt class="text-left">
                            Total Item
                        </dt>
                        <dd id="total_item">
                            : {{ number_format($total_item, 0, ',', '.') }}
                        </dd>
                        <dt class="text-left">
                            Total Cost
                        </dt>
                        <dd id="total_price">
                            : Rp {{ number_format($total_price, 0, ',', '.') }}
                        </dd>
                    </dl>
                </div>

                <table class="table table-striped table-bordered table-hover table-condensed"
                    id="product-ranking-table" width="100%">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Category</th>
                            <th>Item</th>
                            <th>Total Item</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="clearfix"></div>
            </div>

            <div class="panel-footer">
                <a href="{{ route('product_ranking.index') }}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> @lang('global.go_back')
                </a>

                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@stop

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ url('theme/app/vendor/plugins/datatables/media/css/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ url('theme/app/vendor/plugins/datatables/media/css/dataTables.plugins.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables/extensions/Buttons/css/buttons.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/select2/css/select2.css') }}">
<link rel="stylesheet" href="{{ url('plugins/select2/css/select2-bootstrap.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="{{ url('plugins/jquery-number/jquery.number.min.js') }}"></script>
<script src="{{ url('plugins/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/Buttons/js/buttons.bootstrap.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/Checkboxes/dataTables.checkboxes.min.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/Pagination/full_numbers_no_ellipses.js') }}"></script>
<script src="{{ url('plugins/select2/js/select2.full.js') }}"></script>

<script>
    $(function () {
        let table = $('#product-ranking-table').DataTable({
            aaSorting: [[0, 'desc']],
            searching: false,
            ordering: false,
            aLengthMenu: [
                [50, 100, 500, 1000, 5000, -1],
                [50, 100, 500, 1000, 5000, "All"]
            ],
            iDisplayLength: 100,
            processing: true,
            serverSide: true,
            scrollX: true,
            dom: "<'dt-panelmenu clearfix'<'row'<'col-sm-2'B><'col-sm-4'l><'col-sm-6'f>>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'dt-panelfooter clearfix'<'row'<'col-sm-5'i><'col-sm-7'p>>>",
            pagingType: "full_numbers",
            ajax: {
                url: '{!! route('product_ranking.ajax.data') !!}',
                dataType: 'json',
                data: function (d) {
                    d.filter_type = $('#filter_type').val();
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.product_category_id = $('#product_category_id').val();
                },
            },
            columns: [
                {
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'product.product_category.name', name: 'product.product_category.name'},
                {data: 'name', name: 'name'},
                {
                    data: 'total_qty',
                    render: function (data) {
                        return $.number(data);
                    }
                },
                {
                    data: 'total_price',
                    render: function (data) {
                        return 'Rp. ' + $.number(data);
                    }
                },
            ],
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        modifier: {
                            page: 'all',
                            search: 'none'
                        }
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        modifier: {
                            page: 'all',
                            search: 'none'
                        }
                    }
                }
            ],
            select: {
                style: 'multi'
            },
        });

        function addCommas(nStr) {
            nStr += '';
            let parts = nStr.split(',');
            let integerPart = parts[0];
            let decimalPart = parts.length > 1 ? ',' + parts[1] : '';
            let separatorPattern = /(\d+)(\d{3})/;

            while (separatorPattern.test(integerPart)) {
                integerPart = integerPart.replace(separatorPattern, '$1' + '.' + '$2');
            }

            return integerPart + decimalPart;
        }

        $('#choose').on('click', function (e) {
            e.preventDefault();
            table.draw();

            $.ajax({
                type: "GET",
                url: '{!! route('product_ranking.total_data') !!}',
                data: {
                    "filter_type": $('#filter_type').val(),
                    "date_from": $('#date_from').val(),
                    "date_to": $('#date_to').val(),
                    "product_category_id": $('#product_category_id').val()
                },
                success: function(data) {
                    $("#total_item").text(": " + addCommas(data.total_item));
                    $("#total_price").text(": Rp " + addCommas(data.total_price));
                }
            });
        });

        $('#product_category_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            containerCssClass: ':all:',
            ajax: {
                url: '{{ route('product_category.ajax.select2') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * data.per_page) < data.total
                        }
                    };
                },
                cache: true,
            }
        });
    });
</script>
@endpush

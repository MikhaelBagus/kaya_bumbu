@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Media List
                </div>
            </div>

            <div class="panel-menu">
                <a href="{{route('media.create')}}" class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
            </div>
            <table class="table table-striped table-bordered table-hover table-condensed" id="media-table" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th>Type</th>
                    <th>Url</th>
                    <th>View</th>
                    <th>@lang('auth.index_created_at')</th>
                    <th>@lang('auth.index_updated_at')</th>
                    <th width="100">@lang('global.action')</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>
@stop

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.plugins.css')}}">
    <link rel="stylesheet" href="{{url('plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('plugins/datatables/extensions/Buttons/css/buttons.bootstrap.min.css')}}">
@endpush

@push('scripts')

    <!-- DataTables -->
    <script src="{{url('plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/Buttons/js/buttons.bootstrap.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/Checkboxes/dataTables.checkboxes.min.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/Pagination/full_numbers_no_ellipses.js')}}"></script>
    <script src="{{url('plugins/jquery-number/jquery.number.min.js')}}"></script>

<script>
    $(function () {

        let table = $('#media-table').DataTable({
            aaSorting: [[0, 'desc']],
            iDisplayLength: 25,
            //stateSave: true,
            // responsive: true,
            // fixedHeader: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            dom: "<'dt-panelmenu clearfix'<'row'<'col-sm-2'B><'col-sm-4'l><'col-sm-6'f>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'dt-panelfooter clearfix'<'row'<'col-sm-5'i><'col-sm-7'p>>>",
            pagingType: "full_numbers",
            ajax: {
                url: '{!! route('media.ajax.data') !!}',
                dataType: 'json'
            },
            columns: [
                {data: 'id', name: 'id', visible: false},
                {
                    data: 'checkbox', name: 'checkbox', orderable: false, searchable: false,
                    checkboxes: true
                },
                {data: 'type', name: 'type'},
                {data: 'url', name: 'url'},
                {data: 'view', name: 'view'},
                {data: 'created_at', name: 'created_at', visible: false},
                {data: 'updated_at', name: 'updated_at', visible: false},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false,
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                        $("a", nTd).tooltip({container: 'body'});
                    }
                }
            ],
            buttons: [
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i> @lang('auth.index_column')',
                    columns: '2, 3, 4'
                }
            ],
            select: {
                style: 'multi'
            },
        });
    });

    function copyToClipboard(url){
        const el = document.createElement('textarea');
        el.value = url;
        el.setAttribute('readonly', '');
        el.style.position = 'absolute';
        el.style.left = '-9999px';
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        alert('successfully copied');
    }
</script>
@endpush

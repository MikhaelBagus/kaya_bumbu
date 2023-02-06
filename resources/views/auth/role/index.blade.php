@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
        
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>@lang('auth.index_roles')
                </div>
            </div>
            
            <div class="panel-menu">
                <a href="{{route('roles.create')}}" class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
            </div>
            
            <table class="table table-striped table-bordered table-hover table-condensed" id="users-table" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('auth.index_name_th')</th>
                    <th>@lang('auth.index_created_by')</th>
                    <th>@lang('auth.index_updated_by')</th>
                    <th>@lang('auth.index_action_th')</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    </section>

@stop

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('theme/app/vendor/plugins/datatables/media/css/dataTables.plugins.css')}}">
@endpush

@push('scripts')
    
    <!-- DataTables -->
    <script src="{{url('plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
    <script src="{{url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
    
    <script>
        $(function () {
            $('#users-table').DataTable({
                aaSorting     : [[0, 'desc']],
                iDisplayLength: 25,
                stateSave     : true,
                responsive    : true,
                processing    : true,
                serverSide    : true,
                pagingType    : "full_numbers",
                dom           : '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
                ajax          : {
                    url     : '{!! route('roles.ajax.data') !!}',
                    dataType: 'json'
                },
                columns       : [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'name', name: 'name'},
                    {data: 'created_by', name: 'created_by'},
                    {data: 'updated_by', name: 'updated_by'},
                    {
                        data           : 'action', name: 'action', orderable: false, searchable: false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            //  console.log( nTd );
                            $("a", nTd).tooltip({container: 'body'});
                        }
                    }
                ]
            });
        });
    </script>
@endpush

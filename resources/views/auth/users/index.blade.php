@extends('backend.layouts.app')

@section('content')
<section id="content" class="animated fadeIn">
    @include('flash')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title hidden-xs">
                <span class="glyphicon glyphicon-tasks"></span>@lang('auth.index_users')
            </div>
        </div>
        <div class="panel panel-default" style="margin-bottom:0px">
            <div class="panel-heading">
                Filter
            </div>
            <div class="panel-body">
                <form action="" method="POST">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group" style="width:100%">
                                <label class="control-label">Role</label>
                                <select id="role" class="input-sm form-control select_2" style="width:100%" name="role">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" style="width:100%">
                                <label class="control-label">Status</label>
                                <select id="status" class="input-sm form-control select_2" style="width:100%" name="status">
                                    <option></option>
                                    <option value="0">Not Active</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="button" id="choose" class="btn btn-success btn-sm">Apply Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel-menu">
            <a href="{{route('users.create')}}" class="btn btn-flat btn-success btn-sm">@lang('auth.index_create_link')</a>
        </div>
        <table class="table table-striped table-bordered table-hover table-condensed" id="users-table" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Roles</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>@lang('auth.index_last_login')</th>
                <th>@lang('auth.index_status_th')</th>
                <th>@lang('auth.index_action_th')</th>
            </tr>
        </thead>
        <tbody></tbody>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
        var table = $('#users-table').DataTable({
            aaSorting     : [[0, 'desc']],
            aLengthMenu: [
                [100, 500, 1000, 5000, -1],
                [100, 500, 1000, 5000, "All"]
            ],
            iDisplayLength: 100,
            // stateSave     : true,
            // responsive: true,
            // fixedHeader: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            dom: "<'dt-panelmenu clearfix'<'row'<'col-sm-2'B><'col-sm-4'l><'col-sm-6'f>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'dt-panelfooter clearfix'<'row'<'col-sm-5'i><'col-sm-7'p>>>",
            pagingType: "full_numbers",
            ajax          : {
                url     : '{!! route('users.ajax.data') !!}',
                dataType: 'json',
                data: function (d) {
                    d.role = $('#role').val();
                    d.status = $('#status').val();
                }
            },
            columns       : [
                {data: 'id', name: 'users.id'},
                {data: 'role', name: 'roles.name', defaultContent: ''},
                {
                    data: 'name', name: 'users.name'
                },
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'last_login', name: 'last_login'},
                {
                    data: 'status', name: 'status', fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    }
                },
                {
                    data         : 'action', name: 'action', orderable: false, searchable: false,
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    }
                }
            ],
            buttons: [
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i> @lang('auth.index_column')',
                    columns: '2, 3, 4, 5, 6, 7, 8'
                }
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
        });

        $('#choose').on('click', function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
    });

    $('#role').select2({
        theme: "bootstrap",
        placeholder: "Select",
        width: '100%',
        allowClear: true,
        containerCssClass: ':all:',
        ajax: {
            url: '{{route('roles.ajax.select2')}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term,
                    page: params.page,
                };
            },
            processResults: function (data, params) {

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

    $('#status').select2({
        theme: "bootstrap",
        placeholder: "Select",
        width: '100%',
        allowClear: true,
        containerCssClass: ':all:'
    });
</script>
@endpush
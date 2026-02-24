@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Recipes
                </div>
            </div>

            <table class="table table-striped table-bordered table-hover table-condensed" id="recipe-table" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="text-align: center">&nbsp;</th>
                    <th>Product Name</th>
                    <th>Ingredients Count</th>
                    <th>@lang('auth.index_created_at')</th>
                    <th>@lang('auth.index_updated_at')</th>
                    <th width="100">@lang('global.action')</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>

    <!-- Recipe Delete Modal -->
    <div class="modal fade" id="deleteRecipeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this recipe?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteRecipe">Delete</button>
                </div>
            </div>
        </div>
    </div>
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

<style>
    .expand-icon {
        color: #337ab7;
        transition: all 0.3s ease;
    }
    .expand-icon:hover {
        color: #23527c;
    }
    .child-row-content {
        background-color: #f9f9f9 !important;
        border-left: 4px solid #337ab7;
    }
    .child-row-content .table {
        background-color: white;
        margin-bottom: 0;
    }
    .child-row-content .table th {
        background-color: #f5f5f5;
        font-weight: 600;
    }
    tr.shown td {
        border-bottom: none;
    }
</style>
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

        let table = $('#recipe-table').DataTable({
            aaSorting: [[0, 'desc']],
            aLengthMenu: [
                    [50, 100, 500, 1000, 5000, -1],
                    [50, 100, 500, 1000, 5000, "All"]
                ],
            iDisplayLength: 100,
            processing: true,
            serverSide: false,
            scrollX: true,
            dom: "<'dt-panelmenu clearfix'<'row'<'col-sm-2'B><'col-sm-4'l><'col-sm-6'f>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'dt-panelfooter clearfix'<'row'<'col-sm-5'i><'col-sm-7'p>>>",
            pagingType: "full_numbers",
            ajax: {
                url: '{!! route('recipe.ajax.data') !!}',
                dataType: 'json'
            },
            columns: [
                {data: 'id', name: 'id', visible: false},
                {
                    data: 'checkbox', name: 'checkbox', orderable: false, searchable: false,
                    checkboxes: true
                },
                {
                    data: 'name', 
                    name: 'name',
                    render: function(data, type, row) {
                        let expandIcon = '<i class="fa fa-plus-square-o expand-icon" style="cursor: pointer; margin-right: 5px;"></i>';
                        return expandIcon + data;
                    }
                },
                {
                    data: 'ingredients_count', 
                    name: 'ingredients_count',
                    render: function(data, type, row) {
                        return data + ' ingredients';
                    }
                },
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
                    text: '<i class="fa fa-columns"></i> Columns',
                    columns: '2, 3'
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
            select: {
                style: 'multi'
            },
        });

        // Add collapsible functionality
        $('#recipe-table tbody').on('click', '.expand-icon', function() {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let icon = $(this);
            
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                icon.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
            } else {
                // Open this row
                let rowData = row.data();
                let childContent = formatChildRow(rowData.ingredients);
                row.child(childContent).show();
                tr.addClass('shown');
                icon.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
            }
        });

        // Format child row content
        function formatChildRow(ingredients) {
            if (!ingredients || ingredients.length === 0) {
                return '<div class="alert alert-info">No ingredients found for this product.</div>';
            }

            let html = '<div class="child-row-content" style="background-color: #f9f9f9; padding: 15px;">';
            html += '<h5><i class="fa fa-list"></i> Ingredients:</h5>';
            html += '<div class="table-responsive">';
            html += '<table class="table table-sm table-bordered">';
            html += '<thead><tr><th>Ingredient Name</th><th>Unit</th><th>Quantity</th></tr></thead>';
            html += '<tbody>';
            
            ingredients.forEach(function(ingredient) {
                html += '<tr>';
                html += '<td>' + ingredient.ingredient_name + '</td>';
                html += '<td>' + ingredient.ingredient_unit + '</td>';
                html += '<td>' + $.number(ingredient.qty) + '</td>';
                html += '</tr>';
            });
            
            html += '</tbody></table></div></div>';
            return html;
        }

    });
</script>
@endpush

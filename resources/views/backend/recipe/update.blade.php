@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <!-- Product Info Panel (Read-only) -->
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-cutlery"></span>Product Recipe Management
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="fa fa-cube"></i> Product Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Product Name:</strong></td>
                                <td>{{ $product->name }}</td>
                            </tr>
                            @if($product->product_category)
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>{{ $product->product_category->name }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4><i class="fa fa-info-circle"></i> Recipe Summary</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Total Ingredients:</strong></td>
                                <td><span class="badge badge-primary">{{ $product->product_recipes->count() }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Ingredient Panel -->
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-plus"></span>Add New Ingredient
                </div>
            </div>
            <div class="panel-body">
                <form id="addIngredientForm" class="form-horizontal" style="padding: 10px;">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Select Ingredient <span style="color: red">*</span></label>
                                <select id="ingredient_master_id" name="ingredient_master_id" class="form-control select2" required>
                                    <option value="">Select Ingredient...</option>
                                    @foreach($ingredientMasters as $ingredient)
                                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quantity <span style="color: red">*</span></label>
                                <input type="number" step="0.01" min="0" id="qty" name="qty" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label><br>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fa fa-plus"></i> Add Ingredient
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Current Ingredients List -->
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-list"></span>Current Recipe Ingredients
                </div>
            </div>
            <div class="panel-body">
                @if($product->product_recipes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Ingredient Name</th>
                                    <th width="15%">Unit</th>
                                    <th width="20%">Quantity</th>
                                    <th width="25%">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ingredientsList">
                                @foreach($product->product_recipes as $index => $recipe)
                                <tr id="ingredient-row-{{ $recipe->id }}" 
                                    data-ingredient-id="{{ $recipe->ingredient_master_id }}"
                                    data-product-id="{{ $recipe->product_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $recipe->ingredientMaster->name }}</td>
                                    <td>{{ $recipe->ingredientMaster->unit }}</td>
                                    <td>
                                        <div class="qty-display" id="qty-display-{{ $recipe->id }}">
                                            {{ number_format($recipe->qty, 2) }}
                                        </div>
                                        <div class="qty-edit" id="qty-edit-{{ $recipe->id }}" style="display: none;">
                                            <input type="number" step="0.01" min="0" class="form-control input-sm" 
                                                   value="{{ $recipe->qty }}" id="qty-input-{{ $recipe->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-warning edit-qty" 
                                                    data-id="{{ $recipe->id }}" title="Edit Quantity">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-xs btn-success save-qty" 
                                                    data-id="{{ $recipe->id }}" title="Save" style="display: none;">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-xs btn-default cancel-edit" 
                                                    data-id="{{ $recipe->id }}" title="Cancel" style="display: none;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <button type="button" class="btn btn-xs btn-danger delete-ingredient" 
                                                    data-id="{{ $recipe->id }}" title="Delete Ingredient">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> No ingredients added to this product yet. Use the form above to add ingredients.
                    </div>
                @endif
            </div>
            <div class="panel-footer">
                <a href="{{ route('recipe.index') }}" class="btn btn-flat btn-default btn-sm">
                    <i class="fa fa-reply"></i> Back to Recipe List
                </a>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this ingredient from the recipe?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css" rel="stylesheet" />
    
    <style>
        .panel-visible {
            margin-bottom: 20px;
        }
        .qty-display, .qty-edit {
            transition: all 0.3s ease;
        }
        .table-responsive {
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-group .btn {
            margin-right: 2px;
        }
        .alert-info {
            border-left: 4px solid #5bc0de;
        }
        .badge-primary {
            background-color: #337ab7;
        }
        
        /* Select2 custom styling */
        .select2-container {
            width: 100% !important;
        }
        .select2-container--bootstrap .select2-selection--single {
            height: 34px;
            line-height: 1.42857143;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .select2-container--bootstrap .select2-selection--single .select2-selection__rendered {
            color: #555;
            padding: 0;
        }
        .select2-container--bootstrap .select2-selection--single .select2-selection__arrow {
            height: 32px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }
        
        /* Form spacing */
        #addIngredientForm .col-md-4 {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        #addIngredientForm .form-group {
            margin-bottom: 0;
        }
    </style>
@endpush

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            let deleteIngredientId = null;

            $('#ingredient_master_id').select2({
                theme: 'bootstrap',
                placeholder: 'Search and select ingredient...',
                allowClear: true,
                width: '100%'
            });

            $('#addIngredientForm').on('submit', function(e) {
                e.preventDefault();
                
                let formData = {
                    product_id: {{ $product->id }},
                    ingredient_master_id: $('#ingredient_master_id').val(),
                    qty: $('#qty').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                if (!formData.ingredient_master_id || !formData.qty) {
                    alert('Please fill in all fields');
                    return;
                }

                $.ajax({
                    url: '{{ route("recipe.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#ingredient_master_id').val(null).trigger('change');
                        $('#qty').val('');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON);
                        let message = 'Error adding ingredient';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            message = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        alert(message);
                    }
                });
            });

            // Edit quantity button
            $('.edit-qty').on('click', function() {
                let id = $(this).data('id');
                $('#qty-display-' + id).hide();
                $('#qty-edit-' + id).show();
                $(this).hide();
                $('.save-qty[data-id="' + id + '"]').show();
                $('.cancel-edit[data-id="' + id + '"]').show();
            });


            $('.save-qty').on('click', function() {
                let id = $(this).data('id');
                let newQty = $('#qty-input-' + id).val();
                let row = $('#ingredient-row-' + id);
                let productId = row.data('product-id');
                let ingredientId = row.data('ingredient-id');

                if (!newQty || newQty < 0) {
                    alert('Please enter a valid quantity');
                    return;
                }

                $.ajax({
                    url: '/product/recipe/' + id,
                    type: 'PUT',
                    data: {
                        qty: newQty,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#qty-display-' + id).text(parseFloat(newQty).toFixed(2));
                        $('#qty-display-' + id).show();
                        $('#qty-edit-' + id).hide();
                        $('.edit-qty[data-id="' + id + '"]').show();
                        $('.save-qty[data-id="' + id + '"]').hide();
                        $('.cancel-edit[data-id="' + id + '"]').hide();
                    },
                    error: function(xhr) {
                        alert('Error updating quantity');
                    }
                });
            });

            $('.cancel-edit').on('click', function() {
                let id = $(this).data('id');
                $('#qty-display-' + id).show();
                $('#qty-edit-' + id).hide();
                $('.edit-qty[data-id="' + id + '"]').show();
                $('.save-qty[data-id="' + id + '"]').hide();
                $(this).hide();
            });

            $('.delete-ingredient').on('click', function() {
                deleteIngredientId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                if (deleteIngredientId) {
                    $.ajax({
                        url: '{{ route("recipe.destroy", ":id") }}'.replace(':id', deleteIngredientId),
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#ingredient-row-' + deleteIngredientId).fadeOut(function() {
                                $(this).remove();
                                // Reindex rows
                                $('#ingredientsList tr').each(function(index) {
                                    $(this).find('td:first').text(index + 1);
                                });
                            });
                            $('#deleteModal').modal('hide');
                            deleteIngredientId = null;
                        },
                        error: function(xhr) {
                            alert('Error deleting ingredient');
                            $('#deleteModal').modal('hide');
                        }
                    });
                }
            });

            $('#deleteModal').on('hidden.bs.modal', function() {
                deleteIngredientId = null;
            });
        });
    </script>
@endpush
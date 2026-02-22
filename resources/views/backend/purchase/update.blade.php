@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-shopping-cart"></span>Purchase Update Form - {{ $purchase->code }}
                </div>
            </div>

            <form action="{{route('purchase.update', $purchase->id)}}" method="post" id="purchase-form">
                <div class="panel-body">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="status" id="form-status" value="{{$purchase->status}}">

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Validation Error!</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('wallet_id')) has-error @endif">
                                <label for="wallet_id" class="control-label">Wallet <span style="color: red">*</span></label>
                                <select name="wallet_id" id="wallet_id" class="form-control select2" required>
                                    @if($purchase->wallet)
                                        <option value="{{ $purchase->wallet_id }}" selected>{{ $purchase->wallet->account_number .' - '. $purchase->wallet->account_name .' - '. $purchase->wallet->bank_name }}</option>
                                    @else
                                        <option value="">Search or select wallet</option>
                                    @endif
                                    <option value="">Select wallet</option>
                                </select>
                                {!! $errors->first('wallet_id', '<em for="wallet_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('purchase_date')) has-error @endif">
                                <label for="purchase_date" class="control-label">Purchase Date <span style="color: red">*</span></label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{old('purchase_date', $purchase->purchase_date)}}" class="form-control input-sm" required>
                                {!! $errors->first('purchase_date', '<em for="purchase_date" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('supplier_id')) has-error @endif">
                                <label for="supplier_id" class="control-label">Supplier <span style="color: red">*</span></label>
                                <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                                    @if($purchase->supplier)
                                        <option value="{{ $purchase->supplier_id }}" selected>{{ $purchase->supplier->supplier_name }}</option>
                                    @else
                                        <option value="">Search or select supplier</option>
                                    @endif
                                </select>
                                {!! $errors->first('supplier_id', '<em for="supplier_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('supplier_account_id')) has-error @endif">
                                <label for="supplier_account_id" class="control-label">Supplier Account <span style="color: red">*</span></label>
                                <select name="supplier_account_id" id="supplier_account_id" class="form-control select2" required>
                                    @if($purchase->supplierAccount)
                                        <option value="{{ $purchase->supplier_account_id }}" selected>{{ $purchase->supplierAccount->account_number .' - '. $purchase->supplierAccount->account_name .' - '. $purchase->supplierAccount->bank_name }}</option>
                                    @else
                                        <option value="">Search or select supplier account</option>
                                    @endif
                                </select>
                                {!! $errors->first('supplier_account_id', '<em for="supplier_account_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    {{-- Ingredients --}}
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h4 class="text-primary text-center"><strong>Ingredients</strong></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Total Ingredients: <span id="total-products">0</span></label>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary btn-sm" id="add-product-row">
                                        <i class="fa fa-plus"></i> Add Ingredient
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" id="product-table">
                                    <thead>
                                        <tr>
                                            <th width="200">Ingredient</th>
                                            <th width="80">Warehouse</th>
                                            <th width="80">Expenditure Type</th>
                                            <th width="80">Unit</th>
                                            <th width="80">PO Qty</th>
                                            <th width="100">Last Price</th>
                                            <th width="100">Price</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-rows">
                                        <!-- Dynamic rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Purchase Cost --}}
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h4 class="text-primary text-center"><strong>Purchase Cost</strong></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info btn-sm" id="add-cost-row">
                                <i class="fa fa-plus"></i> Add Cost
                            </button>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" id="cost-table">
                                    <thead>
                                        <tr>
                                            <th>Cost</th>
                                            <th width="150">Amount</th>
                                            <th width="200">Notes</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cost-rows">
                                        <!-- Dynamic rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Purchase Discount --}}
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h4 class="text-primary text-center"><strong>Purchase Discount</strong></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info btn-sm" id="add-discount-row">
                                <i class="fa fa-plus"></i> Add Discount
                            </button>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" id="discount-table">
                                    <thead>
                                        <tr>
                                            <th>Discount</th>
                                            <th width="150">Amount</th>
                                            <th width="200">Notes</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="discount-rows">
                                        <!-- Dynamic rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h4 class="text-primary text-center"><strong>Payment</strong></h4>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('payment_method_id')) has-error @endif">
                                <label for="payment_method_id" class="control-label">Payment Method <span style="color: red">*</span></label>
                                <select name="payment_method_id" id="payment_method_id" class="form-control select2" required>
                                    @if($purchase->paymentMethod)
                                        <option value="{{ $purchase->payment_method_id }}" selected>{{ $purchase->paymentMethod->name }}</option>
                                    @else
                                        <option value="">Search or select payment method</option>
                                    @endif
                                </select>
                                {!! $errors->first('payment_method_id', '<em for="payment_method_id" class="text-danger">:message</em>') !!}
                            </div>
                        </div>
                    </div>

                    {{-- Instalment Fields (hidden by default) --}}
                    <div id="instalment-section" style="display: {{ $purchase->instalment_count > 0 ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group @if($errors->has('down_payment')) has-error @endif">
                                    <label for="down_payment" class="control-label">Down Payment (Uang Muka)</label>
                                    <input type="number" name="down_payment" id="down_payment" value="{{old('down_payment', $purchase->down_payment)}}" class="form-control input-sm" step="1" min="0" placeholder="0">
                                    {!! $errors->first('down_payment', '<em for="down_payment" class="text-danger">:message</em>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @if($errors->has('down_payment_date')) has-error @endif">
                                    <label for="down_payment_date" class="control-label">Tanggal Down Payment (Uang Muka)</label>
                                    <input type="date" name="down_payment_date" id="down_payment_date" value="{{old('down_payment_date', $purchase->down_payment_date)}}" class="form-control input-sm">
                                    {!! $errors->first('down_payment_date', '<em for="down_payment_date" class="text-danger">:message</em>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @if($errors->has('instalment_count')) has-error @endif">
                                    <label for="instalment_count" class="control-label">Jumlah Cicilan</label>
                                    <input type="number" name="instalment_count" id="instalment_count" value="{{old('instalment_count', $purchase->instalment_count)}}" class="form-control input-sm" min="1" placeholder="1">
                                    {!! $errors->first('instalment_count', '<em for="instalment_count" class="text-danger">:message</em>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-primary"><strong>Tabel Cicilan</strong></h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="instalment-table">
                                        <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Tanggal Jatuh Tempo</th>
                                                <th>Jumlah Cicilan</th>
                                                <th>Tanggal Pelunasan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="instalment-rows">
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Info & Cost Summary --}}
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-6">
                            <hr>
                            <h4 class="text-primary text-center"><strong>Additional Info</strong></h4>
                            <hr>
                            <div class="form-group @if($errors->has('notes')) has-error @endif">
                                <label for="notes" class="control-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control input-sm" placeholder="Add transaction notes" rows="5">{{old('notes', $purchase->notes)}}</textarea>
                                {!! $errors->first('notes', '<em for="notes" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <hr>
                            <h4 class="text-primary text-center"><strong>Purchase Summary</strong></h4>
                            <hr>
                            <table class="table">
                                <tr>
                                    <td>Subtotal (<span id="subtotal-count">0</span>)</td>
                                    <td class="text-right"><strong id="subtotal-display">0</strong></td>
                                </tr>
                                <tr>
                                    <td>Cost</td>
                                    <td class="text-right"><strong id="cost-display">0</strong></td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="text-right"><strong id="discount-display">0</strong></td>
                                </tr>
                                <tr class="bg-primary">
                                    <td><strong>Total Purchase</strong></td>
                                    <td class="text-right"><strong id="total-purchase-display">0</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <input type="hidden" name="status" value="draft">
                </div>

                <div class="panel-footer">
                    <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
                    <a href="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" class="btn btn-flat btn-default btn-sm">
                        <i class="fa fa-reply"></i> Cancel
                    </a>

                    <div class="pull-right">
                        <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in" id="save-button">
                            <span class="ladda-label"><i class="fa fa-save"></i> Save</span>
                            <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span>
                        </button>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('css')
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2-bootstrap.css')}}">
    <style>
        .table th {
            background-color: #f5f5f5;
        }
        #product-table input, #cost-table input, #discount-table input, #product-table textarea, #cost-table textarea, #discount-table textarea {
            width: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{url('plugins/select2/js/select2.full.js')}}"></script>
    <script src="{{url('plugins/jquery-number/jquery.number.min.js')}}"></script>

    <script>
        let productRowIndex = 0;
        let costRowIndex = 0;
        let discountRowIndex = 0;

        $(document).ready(function() {
            // Disable Enter
            $(document).keypress(function (event) {
                if (event.which == '13' && event.target.tagName !== 'TEXTAREA') {
                    event.preventDefault();
                }
            });

            // Initialize Select2
            $('#wallet_id').select2({
                placeholder: 'Search or select wallet',
                ajax: {
                    url: '{{ route("wallet.ajax.select2") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: {
                                term: params.term
                            },
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#supplier_id').select2({
                placeholder: 'Search or select supplier',
                ajax: {
                    url: '{{ route("supplier.ajax.select2") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: {
                                term: params.term
                            },
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#payment_method_id').select2({
                placeholder: 'Search or select payment method',
                ajax: {
                    url: '{{ route("payment_method.ajax.select2") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: {
                                term: params.term
                            },
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });

            // Handle payment method change to show/hide instalment section
            $('#payment_method_id').on('change', function() {
                var selectedText = $('#payment_method_id option:selected').text();
                if (selectedText === 'Instalment') {
                    $('#instalment-section').show();
                    generateInstalmentTable();
                } else {
                    $('#instalment-section').hide();
                }
            });

            // Handle down payment and instalment count change
            $('#down_payment, #instalment_count').on('input change', function() {
                generateInstalmentTable();
            });

            $('#supplier_account_id').select2({
                placeholder: 'Select supplier account'
            });

            $('#supplier_id').on('change', function() {
                var supplier_id = $(this).val();
                $('#supplier_account_id').prop('disabled', true).html('<option value="">Select supplier account</option>');

                if (supplier_id) {
                    $.ajax({
                        url: '{{ route("supplier_account.ajax.select2") }}',
                        dataType: 'json',
                        data: {
                            page: 1,
                            term: '',
                            supplier_id: supplier_id
                        },
                        success: function(data) {
                            var options = '<option value="">Select supplier account</option>';
                            if (data.results) {
                                data.results.forEach(function(item) {
                                    options += '<option value="' + item.id + '">' + item.text + '</option>';
                                });
                            }
                            $('#supplier_account_id').html(options).prop('disabled', false);
                        },
                        error: function() {
                            $('#supplier_account_id').html('<option value="">Select supplier account</option>').prop('disabled', false);
                        }
                    });
                }
            });

            // Load existing product rows
            var existingItems = @json($purchase->purchaseItems ?? []);
            if (existingItems.length > 0) {
                existingItems.forEach(function(item) {
                    addProductRow(item);
                });
            } else {
                // Add first product row if no existing items
                addProductRow();
            }

            // Add product row button
            $('#add-product-row').click(function() {
                addProductRow();
            });

            // Load existing cost rows
            var existingCosts = @json($purchase->purchaseCosts ?? []);
            if (existingCosts.length > 0) {
                existingCosts.forEach(function(cost) {
                    addCostRow(cost);
                });
            }

            // Add cost row button
            $('#add-cost-row').click(function() {
                addCostRow();
            });

            // Load existing discount rows
            var existingDiscounts = @json($purchase->purchaseDiscounts ?? []);
            if (existingDiscounts.length > 0) {
                existingDiscounts.forEach(function(discount) {
                    addDiscountRow(discount);
                });
            }

            $('#add-discount-row').click(function() {
                addDiscountRow();
            });

            var formSubmitting = false;

            // Save button (submitted status)
            $('#save-button').click(function(e) {
                $('#form-status').val('submitted');
            });

            // Save as draft button
            $('#save-as-draft').click(function(e) {
                e.preventDefault();
                $('#form-status').val('draft');
                $('#purchase-form').submit();
            });

            // Calculate totals on form submit
            $('#purchase-form').submit(function(e) {
                if (formSubmitting) {
                    console.log('Form is submitting...');
                    return true; // Allow submission
                }

                e.preventDefault();
                console.log('Validating form...');

                // Validate at least one ingredient
                if ($('#product-rows tr').length === 0) {
                    alert('Please add at least one ingredient item');
                    return false;
                }

                // Validate required fields
                var warehouse = $('#warehouse_id').val();
                var supplier = $('#supplier_id').val();
                var purchaseDate = $('#purchase_date').val();

                if (!warehouse) {
                    alert('Warehouse is required');
                    $('#warehouse_id').focus();
                    return false;
                }

                if (!purchaseDate) {
                    alert('Purchase date is required');
                    $('#purchase_date').focus();
                    return false;
                }

                if (!supplier) {
                    alert('Supplier is required');
                    $('#supplier_id').focus();
                    return false;
                }

                // Validate each ingredient row
                var isValid = true;
                $('#product-rows tr').each(function(index) {
                    var productName = $(this).find('.product-select').val();
                    var poQty = parseFloat($(this).find('.product-qty').val()) || 0;
                    var price = parseFloat($(this).find('.product-price').val()) || 0;

                    if (!productName) {
                        alert('Ingredient is required in row ' + (index + 1));
                        isValid = false;
                        return false;
                    }

                    if (poQty < 1) {
                        alert('PO Quantity must be at least 1 in row ' + (index + 1));
                        isValid = false;
                        return false;
                    }

                    if (price < 0) {
                        alert('Price must be at least 0 in row ' + (index + 1));
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid) {
                    return false;
                }

                // Validate instalment dates if payment method is Instalment
                var paymentMethodText = $('#payment_method_id option:selected').text();
                if (paymentMethodText === 'Instalment' && $('#instalment-section').is(':visible')) {
                    var instalmentDates = [];
                    var dateValid = true;
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);

                    $('#instalment-rows tr').each(function(index) {
                        var dateInput = $(this).find('input[type="date"]');
                        var dateValue = dateInput.val();

                        if (!dateValue) {
                            alert('Instalment due date is required for instalment ' + (index + 1));
                            dateInput.focus();
                            dateValid = false;
                            return false;
                        }

                        var currentDate = new Date(dateValue);

                        // Check sequential order
                        if (instalmentDates.length > 0) {
                            var previousDate = instalmentDates[instalmentDates.length - 1];
                            if (currentDate <= previousDate) {
                                alert('Instalment date for instalment ' + (index + 1) + ' must be after the previous instalment date');
                                dateInput.focus();
                                dateValid = false;
                                return false;
                            }
                        }

                        instalmentDates.push(currentDate);
                    });

                    if (!dateValid) {
                        return false;
                    }
                }

                // Log form data for debugging
                console.log('Form validation passed!');
                console.log('Warehouse:', warehouse);
                console.log('Supplier:', supplier);
                console.log('Status:', $('#form-status').val());
                console.log('Total rows:', $('#product-rows tr').length);

                // If all validations pass, submit the form
                formSubmitting = true;
                this.submit();
            });
        });

        function addProductRow(existingItem = null) {
            productRowIndex++;

            let productId = existingItem ? existingItem.product_id : '';
            let productName = existingItem ? existingItem.product_name : '';
            let unit = existingItem ? existingItem.unit : '';
            let poQty = existingItem ? existingItem.po_qty : 1;
            let lastPrice = existingItem ? existingItem.last_price : 0;
            let price = existingItem ? existingItem.price : 0;
            let warehouseId = existingItem ? existingItem.warehouse_id : 0;
            let warehouseName = existingItem ? existingItem.warehouse.warehouse_name : '';
            let expenditureId = existingItem ? existingItem.expenditure_type_id : 0;
            let expenditureName = existingItem ? existingItem.expenditureType.name : '';

            let row = `
                <tr data-index="${productRowIndex}">
                    <td>
                        <input type="hidden" name="items[${productRowIndex}][product_id]" class="product-id-${productRowIndex}" value="${productId}">
                        <select name="items[${productRowIndex}][product_name]" class="form-control input-sm product-select product-select-${productRowIndex}" required style="width: 100%;">
                            ${existingItem ? `<option value="${productName}" selected>${productName}</option>` : '<option value="">Search ingredient</option>'}
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="items[${productRowIndex}][warehouse_id]" class="warehouse-id-${productRowIndex}" value="${warehouseId}">
                        <select name="items[${productRowIndex}][warehouse_name]" class="form-control input-sm warehouse-select warehouse-select-${productRowIndex}" required style="width: 100%;">
                            ${existingItem ? `<option value="${warehouseName}" selected>${warehouseName}</option>` : '<option value="">Search ingredient</option>'}
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="items[${productRowIndex}][expenditure_type_id]" class="expenditure-id-${productRowIndex}" value="${expenditureId}">
                        <select name="items[${productRowIndex}][expenditure_type_name]" class="form-control input-sm expenditure-select expenditure-select-${productRowIndex}" required style="width: 100%;">
                            ${existingItem ? `<option value="${expenditureName}" selected>${expenditureName}</option>` : '<option value="">Search ingredient</option>'}
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="items[${productRowIndex}][unit]" class="product-unit-value-${productRowIndex}" value="${unit}">
                        <input type="text" class="form-control input-sm product-unit product-unit-${productRowIndex}" placeholder="Unit" value="${unit}" readonly disabled style="background-color: #f4f4f4;">
                    </td>
                    <td>
                        <input type="number" name="items[${productRowIndex}][po_qty]" class="form-control input-sm product-qty product-qty-${productRowIndex}" placeholder="0" step="0.01" value="${poQty}" min="1" required onchange="calculateTotals()">
                    </td>
                    <td>
                        <input type="hidden" name="items[${productRowIndex}][last_price]" class="product-last-price-value-${productRowIndex}" value="${lastPrice}">
                        <input type="number" class="form-control input-sm product-last-price product-last-price-${productRowIndex}" placeholder="0" step="1" value="${lastPrice}" readonly disabled style="background-color: #f4f4f4;">
                    </td>
                    <td>
                        <input type="number" name="items[${productRowIndex}][price]" class="form-control input-sm product-price product-price-${productRowIndex}" placeholder="0" step="1" value="${price}" required onchange="calculateTotals()">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs remove-product-row" onclick="removeProductRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#product-rows').append(row);

            // Initialize Select2 for the new product row
            initializeProductSelect(productRowIndex);

            updateProductCount();
        }

        function initializeProductSelect(index) {
            $('.product-select-' + index).select2({
                placeholder: 'Search ingredient',
                ajax: {
                    url: '{{ route("ingredient.ajax.select2") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.text,
                                    text: item.text,
                                    ingredient_id: item.id,
                                    unit: item.unit,
                                    price: item.price || 0
                                };
                            }),
                            pagination: {
                                more: data.next_page_url != null
                            }
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;

                // Set hidden fields (for form submission)
                $('.product-id-' + index).val(data.ingredient_id);
                $('.product-unit-value-' + index).val(data.unit);
                $('.product-last-price-value-' + index).val(data.price);

                // Set display fields (disabled, for visual only)
                $('.product-unit-' + index).val(data.unit);
                $('.product-last-price-' + index).val(data.price);

                // Set editable price field
                $('.product-price-' + index).val(data.price);

                calculateTotals();
            });

            $('.warehouse-select-' + index).select2({
                placeholder: 'Search warehouse',
                ajax: {
                    url: '{{ route("warehouse.ajax.select2") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.text,
                                    text: item.text,
                                    warehouse_id: item.id
                                };
                            }),
                            pagination: {
                                more: data.next_page_url != null
                            }
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;

                // Set hidden fields (for form submission)
                $('.warehouse-id-' + index).val(data.warehouse_id);
            });

            $('.expenditure-select-' + index).select2({
                placeholder: 'Search expenditure type',
                ajax: {
                    url: '{{ route("expenditure_type.ajax.select2") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.text,
                                    text: item.text,
                                    expenditure_type_id: item.id
                                };
                            }),
                            pagination: {
                                more: data.next_page_url != null
                            }
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;

                // Set hidden fields (for form submission)
                $('.expenditure-id-' + index).val(data.expenditure_type_id);
            });
        }

        function removeProductRow(btn) {
            $(btn).closest('tr').remove();
            updateProductCount();
            calculateTotals();
        }

        function addCostRow(existingCost = null) {
            costRowIndex++;
            let costName = existingCost ? existingCost.cost_name : '';
            let amount = existingCost ? existingCost.amount : 0;
            let notes = existingCost ? existingCost.notes : '';

            let row = `
                <tr data-index="${costRowIndex}">
                    <td>
                        <input type="text" name="costs[${costRowIndex}][cost_name]" class="form-control input-sm cost-name" placeholder="Cost name" value="${costName}" required>
                    </td>
                    <td>
                        <input type="number" name="costs[${costRowIndex}][amount]" class="form-control input-sm cost-amount" placeholder="0" step="1" value="${amount}" required onchange="calculateTotals()">
                    </td>
                    <td>
                        <input type="text" name="costs[${costRowIndex}][notes]" class="form-control input-sm cost-notes" placeholder="Notes" value="${notes}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs remove-cost-row" onclick="removeCostRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#cost-rows').append(row);
            calculateTotals();
        }

        function removeCostRow(btn) {
            $(btn).closest('tr').remove();
            calculateTotals();
        }

        function addDiscountRow(existingDiscount = null) {
            discountRowIndex++;
            let discountName = existingDiscount ? existingDiscount.discount_name : '';
            let amount = existingDiscount ? existingDiscount.amount : 0;
            let notes = existingDiscount ? existingDiscount.notes : '';

            let row = `
                <tr data-index="${discountRowIndex}">
                    <td>
                        <input type="text" name="discounts[${discountRowIndex}][discount_name]" class="form-control input-sm discount-name" placeholder="Discount name" value="${discountName}" required>
                    </td>
                    <td>
                        <input type="number" name="discounts[${discountRowIndex}][amount]" class="form-control input-sm discount-amount" placeholder="0" step="1" value="${amount}" required onchange="calculateTotals()">
                    </td>
                    <td>
                        <input type="text" name="discounts[${discountRowIndex}][notes]" class="form-control input-sm discount-notes" placeholder="Notes" value="${notes}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs remove-discount-row" onclick="removeDiscountRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#discount-rows').append(row);
            calculateTotals();
        }

        function removeDiscountRow(btn) {
            $(btn).closest('tr').remove();
            calculateTotals();
        }

        function updateProductCount() {
            let count = $('#product-rows tr').length;
            $('#total-products').text(count);
            $('#subtotal-count').text(count);
        }

        function calculateTotals() {
            let subtotal = 0;

            // Calculate products
            $('#product-rows tr').each(function() {
                let qty = parseFloat($(this).find('.product-qty').val()) || 0;
                let price = parseFloat($(this).find('.product-price').val()) || 0;

                let itemSubtotal = qty * price;
                subtotal += itemSubtotal;
            });

            // Calculate costs
            let cost = 0;
            $('#cost-rows tr').each(function() {
                let amount = parseFloat($(this).find('.cost-amount').val()) || 0;
                cost += amount;
            });

            let discount = 0;
            $('#discount-rows tr').each(function() {
                let amount = parseFloat($(this).find('.discount-amount').val()) || 0;
                discount += amount;
            });

            // Calculate Total
            let totalPurchase = subtotal + cost - discount;

            // Update display
            $('#subtotal-display').text('Rp ' + $.number(subtotal, 0, ',', '.'));
            $('#discount-display').text('Rp ' + $.number(discount, 0, ',', '.'));
            $('#cost-display').text('Rp ' + $.number(cost, 0, ',', '.'));
            $('#total-purchase-display').text('Rp ' + $.number(totalPurchase, 0, ',', '.'));

            // Trigger instalment table update if Instalment is selected
            if ($('#payment_method_id option:selected').text() === 'Instalment') {
                generateInstalmentTable();
            }
        }

        function generateInstalmentTable() {
            let totalPurchase = 0;
            let subtotal = 0;

            // Calculate products
            $('#product-rows tr').each(function() {
                let qty = parseFloat($(this).find('.product-qty').val()) || 0;
                let price = parseFloat($(this).find('.product-price').val()) || 0;
                let itemSubtotal = qty * price;
                subtotal += itemSubtotal;
            });

            // Calculate costs
            let cost = 0;
            $('#cost-rows tr').each(function() {
                let amount = parseFloat($(this).find('.cost-amount').val()) || 0;
                cost += amount;
            });

            let discount = 0;
            $('#discount-rows tr').each(function() {
                let amount = parseFloat($(this).find('.discount-amount').val()) || 0;
                discount += amount;
            });

            // Calculate total
            totalPurchase = subtotal + cost - discount;

            let downPayment = parseFloat($('#down_payment').val()) || 0;
            let instalmentCount = parseInt($('#instalment_count').val()) || 1;

            // Ensure instalment count is at least 1
            if (instalmentCount < 1) {
                instalmentCount = 1;
                $('#instalment_count').val(1);
            }

            let remainingAmount = Math.max(0, totalPurchase - downPayment);
            let instalmentAmount = remainingAmount / instalmentCount;

            // Save existing values before regenerating
            let currentFormValues = {};
            $('#instalment-rows tr').each(function(index) {
                let i = index + 1;
                currentFormValues[i] = {
                    due_date: $(this).find(`input[name="instalments[${i}][due_date]"]`).val() || '',
                    amount: $(this).find(`input[name="instalments[${i}][amount]"]`).val() || '',
                    paid_date: $(this).find(`input[name="instalments[${i}][paid_date]"]`).val() || ''
                };
            });

            $('#instalment-rows').empty();

            // Check if we have existing instalments from database (only used on first load)
            let existingInstalments = @json($purchase->purchaseInstalments ?? []);

            for (let i = 1; i <= instalmentCount; i++) {
                let existingInstalment = existingInstalments.find(inst => inst.instalment_number == i);

                // Priority: current form values > database values > calculated defaults
                let dueDate = currentFormValues[i] && currentFormValues[i].due_date ? currentFormValues[i].due_date :
                              (existingInstalment ? existingInstalment.due_date : '');
                let paymentDate = currentFormValues[i] && currentFormValues[i].paid_date ? currentFormValues[i].paid_date :
                                  (existingInstalment && existingInstalment.paid_date ? existingInstalment.paid_date : '');
                let amount = currentFormValues[i] && currentFormValues[i].amount ? instalmentAmount.toFixed(0) :
                             (existingInstalment && existingInstalment.amount ? existingInstalment.amount : instalmentAmount.toFixed(0));

                let row = `
                    <tr>
                        <td class="text-center">${i}</td>
                        <td>
                            <input type="date" name="instalments[${i}][due_date]" class="form-control input-sm instalment-due-date" value="${dueDate}" required>
                        </td>
                        <td>
                            <input type="number" name="instalments[${i}][amount]" class="form-control input-sm instalment-amount" step="1" value="${amount}" min="0">
                        </td>
                        <td>
                            <input type="date" name="instalments[${i}][paid_date]" class="form-control input-sm" value="${paymentDate}">
                        </td>
                    </tr>
                `;
                $('#instalment-rows').append(row);
            }
        }
    </script>
@endpush

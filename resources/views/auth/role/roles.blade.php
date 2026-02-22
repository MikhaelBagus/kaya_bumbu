<div class="checkbox checkbox-success">
    <input type="checkbox" value="ok" name="acl_all" class="styled acl" id="acl-all" style="margin-left: 0;" {{ old('acl_all') || array_key_exists('acl.all', $permissions) ? 'checked' : ''}}>
    <label for="acl-all">Checked All</label>
</div>

<table class="table table-bordered table-hover table-striped table-condensed" id="acl-table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="text-center" style="vertical-align: middle">@lang('global.module_name')</th>
            <th class="text-center" width="80">@lang('global.create')</th>
            <th class="text-center" width="80">@lang('global.update')</th>
            <th class="text-center" width="80">@lang('global.view')</th>
            <th class="text-center" width="80" style="color: red">@lang('global.delete')</th>
            <th class="text-center">@lang('global.miscellaneous')</th>
        </tr>
    </thead>

    <tbody>
        <!-- Dashboard -->
        <tr>
            <td>Dashboard</td>
            <td class="text-center">&nbsp;</td>
            <td class="text-center">&nbsp;</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="dashboard" {{ old('dashboard') || array_key_exists('dashboard', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Users -->
        <tr>
            <td>User</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_create" {{ old('user_create') || array_key_exists('user.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_edit" {{ old('user_edit') || array_key_exists('user.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_show" {{ old('user_show') || array_key_exists('user.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_destroy" {{ old('user_destroy') || array_key_exists('user.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" id="user_status" class="styled acl" name="user_status" {{ old('user_status') || array_key_exists('user.status', $permissions) ? 'checked' : ''}}>
                    <label for="users_manage">@lang('auth.index_status_th')</label>
                </div>
            </td>
        </tr>

        <!-- Roles -->
        <tr>
            <td>Role</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_create" {{ old('role_create') || array_key_exists('role.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_edit" {{ old('role_edit') || array_key_exists('role.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_show" {{ old('role_show') || array_key_exists('role.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_destroy" {{ old('role_destroy') || array_key_exists('role.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Log -->
        <tr>
            <td>Log</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="log_show" {{ old('log_show') || array_key_exists('log.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Calendar -->
        <tr>
            <td>Calendar</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="calendar_show" {{ old('calendar_show') || array_key_exists('calendar.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Product Ranking -->
        <tr>
            <td>Product Ranking</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="productranking_show" {{ old('productranking_show') || array_key_exists('productranking.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Wallet -->
        <tr>
            <td>Wallet</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_create" {{ old('wallet_create') || array_key_exists('wallet.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_edit" {{ old('wallet_edit') || array_key_exists('wallet.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_show" {{ old('wallet_show') || array_key_exists('wallet.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_destroy" {{ old('wallet_destroy') || array_key_exists('wallet.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Source -->
        <tr>
            <td>Source</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="source_create" {{ old('source_create') || array_key_exists('source.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="source_edit" {{ old('source_edit') || array_key_exists('source.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="source_show" {{ old('source_show') || array_key_exists('source.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="source_destroy" {{ old('source_destroy') || array_key_exists('source.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Customer -->
        <tr>
            <td>Customer</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="customer_create" {{ old('customer_create') || array_key_exists('customer.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="customer_edit" {{ old('customer_edit') || array_key_exists('customer.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="customer_show" {{ old('customer_show') || array_key_exists('customer.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="customer_destroy" {{ old('customer_destroy') || array_key_exists('customer.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Driver -->
        <tr>
            <td>Driver</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="driver_create" {{ old('driver_create') || array_key_exists('driver.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="driver_edit" {{ old('driver_edit') || array_key_exists('driver.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="driver_show" {{ old('driver_show') || array_key_exists('driver.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="driver_destroy" {{ old('driver_destroy') || array_key_exists('driver.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Product -->
        <tr>
            <td>Product</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_create" {{ old('product_create') || array_key_exists('product.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_edit" {{ old('product_edit') || array_key_exists('product.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_show" {{ old('product_show') || array_key_exists('product.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_destroy" {{ old('product_destroy') || array_key_exists('product.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_copy" {{ old('product_copy') || array_key_exists('product.copy', $permissions) ? 'checked' : ''}}>
                    <label>Copy</label>
                </div>
            </td>
        </tr>

        <!-- Product Category -->
        <tr>
            <td>Product Category</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_create" {{ old('product_category_create') || array_key_exists('product_category.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_edit" {{ old('product_category_edit') || array_key_exists('product_category.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_show" {{ old('product_category_show') || array_key_exists('product_category.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_destroy" {{ old('product_category_destroy') || array_key_exists('product_category.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Ingredient -->
        <tr>
            <td>Ingredient</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_create" {{ old('ingredient_create') || array_key_exists('ingredient.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_edit" {{ old('ingredient_edit') || array_key_exists('ingredient.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_show" {{ old('ingredient_show') || array_key_exists('ingredient.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_destroy" {{ old('ingredient_destroy') || array_key_exists('ingredient.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Ingredient Category -->
        <tr>
            <td>Ingredient Category</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_create" {{ old('ingredient_category_create') || array_key_exists('ingredient_category.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_edit" {{ old('ingredient_category_edit') || array_key_exists('ingredient_category.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_show" {{ old('ingredient_category_show') || array_key_exists('ingredient_category.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_destroy" {{ old('ingredient_category_destroy') || array_key_exists('ingredient_category.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Ingredient Group -->
        <tr>
            <td>Ingredient Group</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_create" {{ old('ingredient_group_create') || array_key_exists('ingredient_group.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_edit" {{ old('ingredient_group_edit') || array_key_exists('ingredient_group.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_show" {{ old('ingredient_group_show') || array_key_exists('ingredient_group.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_destroy" {{ old('ingredient_group_destroy') || array_key_exists('ingredient_group.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Recipe -->
        <tr>
            <td>Recipe</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_create" {{ old('recipe_create') || array_key_exists('recipe.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_edit" {{ old('recipe_edit') || array_key_exists('recipe.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_show" {{ old('recipe_show') || array_key_exists('recipe.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_destroy" {{ old('recipe_destroy') || array_key_exists('recipe.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Transaction -->
        <tr>
            <td>Transaction</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_create" {{ old('transaction_create') || array_key_exists('transaction.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_edit" {{ old('transaction_edit') || array_key_exists('transaction.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_show" {{ old('transaction_show') || array_key_exists('transaction.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_destroy" {{ old('transaction_destroy') || array_key_exists('transaction.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_paymentstatus" {{ old('transaction_paymentstatus') || array_key_exists('transaction.paymentstatus', $permissions) ? 'checked' : ''}}>
                    <label>Payment Status</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_actualongkirprice" {{ old('transaction_actualongkirprice') || array_key_exists('transaction.actualongkirprice', $permissions) ? 'checked' : ''}}>
                    <label>Actual Ongkir Price</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_pdf" {{ old('transaction_pdf') || array_key_exists('transaction.pdf', $permissions) ? 'checked' : ''}}>
                    <label>PDF</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_invoice" {{ old('transaction_invoice') || array_key_exists('transaction.invoice', $permissions) ? 'checked' : ''}}>
                    <label>Invoice</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_deliverypdf" {{ old('transaction_deliverypdf') || array_key_exists('transaction.deliverypdf', $permissions) ? 'checked' : ''}}>
                    <label>Delivery PDF</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_startcooking" {{ old('transaction_startcooking') || array_key_exists('transaction.startcooking', $permissions) ? 'checked' : ''}}>
                    <label>Start Packing</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_startdelivery" {{ old('transaction_startdelivery') || array_key_exists('transaction.startdelivery', $permissions) ? 'checked' : ''}}>
                    <label>Start Delivery</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_enddelivery" {{ old('transaction_enddelivery') || array_key_exists('transaction.enddelivery', $permissions) ? 'checked' : ''}}>
                    <label>End Delivery</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_suspend" {{ old('transaction_suspend') || array_key_exists('transaction.suspend', $permissions) ? 'checked' : ''}}>
                    <label>Suspend</label>
                </div>
            </td>
        </tr>

        <!-- Download Transaction -->
        <tr>
            <td>Download Transaction</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_download_download" {{ old('transaction_download_download') || array_key_exists('transaction_download.download', $permissions) ? 'checked' : ''}}>
                    <label>Download</label>
                </div>
            </td>
        </tr>

    </tbody>
</table>

<!-- DataTables -->
<link rel="stylesheet" href="{{url('plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<script src="{{url('plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>

<script>
    $(function () {
        var oTable = $('#acl-table').DataTable({
            aaSorting  : [[0, 'asc']],
            stateSave  : true,
            bPaginate  : false,
            bInfo      : false,
            responsive : true,
            processing : true,
            bFilter    : false,
            fixedHeader: true,
            @if(Session::get('locale') == 'cn')
            language   : {url: '{{url('plugins/datatables/language/chinese.json')}}'},
            @endif
            columns    : [
            {orderable: true, searchable: true},
            {orderable: false, searchable: false},
            {orderable: false, searchable: false},
            {orderable: false, searchable: false},
            {orderable: false, searchable: false},
            {orderable: false, searchable: false},

            ]

        });
    });

    $('#acl-all').on('click', function () {
        var all = $('#acl-all');
        if (all.is(":checked")) {
            $('.acl').prop('checked', true);
        } else {
            $('.acl').prop('checked', false);
        }
    });
</script>

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

        <!-- About Us -->
        <tr>
            <td>About Us</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="about_us_create" {{ old('about_us_create') || array_key_exists('about_us.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="about_us_edit" {{ old('about_us_edit') || array_key_exists('about_us.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="about_us_show" {{ old('about_us_show') || array_key_exists('about_us.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Contact Us -->
        <tr>
            <td>Contact Us</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="contact_us_create" {{ old('contact_us_create') || array_key_exists('contact_us.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="contact_us_edit" {{ old('contact_us_edit') || array_key_exists('contact_us.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="contact_us_show" {{ old('contact_us_show') || array_key_exists('contact_us.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Disclaimer -->
        <tr>
            <td>Disclaimer</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="disclaimer_create" {{ old('disclaimer_create') || array_key_exists('disclaimer.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="disclaimer_edit" {{ old('disclaimer_edit') || array_key_exists('disclaimer.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="disclaimer_show" {{ old('disclaimer_show') || array_key_exists('disclaimer.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Faq -->
        <tr>
            <td>Faq</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_create" {{ old('faq_create') || array_key_exists('faq.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_edit" {{ old('faq_edit') || array_key_exists('faq.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_show" {{ old('faq_show') || array_key_exists('faq.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_destroy" {{ old('faq_destroy') || array_key_exists('faq.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Media -->
        <tr>
            <td>Media</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="media_create" {{ old('media_create') || array_key_exists('media.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="media_show" {{ old('media_show') || array_key_exists('media.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- News -->
        <tr>
            <td>News</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_create" {{ old('news_create') || array_key_exists('news.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_edit" {{ old('news_edit') || array_key_exists('news.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_show" {{ old('news_show') || array_key_exists('news.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_destroy" {{ old('news_destroy') || array_key_exists('news.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Privacy Policy -->
        <tr>
            <td>Privacy Policy</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="privacy_policy_create" {{ old('privacy_policy_create') || array_key_exists('privacy_policy.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="privacy_policy_edit" {{ old('privacy_policy_edit') || array_key_exists('privacy_policy.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="privacy_policy_show" {{ old('privacy_policy_show') || array_key_exists('privacy_policy.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- Term Condition -->
        <tr>
            <td>Term Condition</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="term_condition_create" {{ old('term_condition_create') || array_key_exists('term_condition.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="term_condition_edit" {{ old('term_condition_edit') || array_key_exists('term_condition.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="term_condition_show" {{ old('term_condition_show') || array_key_exists('term_condition.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
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

        <!-- Province -->
        <tr>
            <td>Province</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="province_create" {{ old('province_create') || array_key_exists('province.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="province_edit" {{ old('province_edit') || array_key_exists('province.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="province_show" {{ old('province_show') || array_key_exists('province.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="province_destroy" {{ old('province_destroy') || array_key_exists('province.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- City -->
        <tr>
            <td>City</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="city_create" {{ old('city_create') || array_key_exists('city.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="city_edit" {{ old('city_edit') || array_key_exists('city.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="city_show" {{ old('city_show') || array_key_exists('city.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="city_destroy" {{ old('city_destroy') || array_key_exists('city.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Bank -->
        <tr>
            <td>Bank</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="bank_create" {{ old('bank_create') || array_key_exists('bank.create', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="bank_edit" {{ old('bank_edit') || array_key_exists('bank.edit', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="bank_show" {{ old('bank_show') || array_key_exists('bank.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="bank_destroy" {{ old('bank_destroy') || array_key_exists('bank.destroy', $permissions) ? 'checked' : ''}}>
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
            <td>&nbsp;</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_show" {{ old('transaction_show') || array_key_exists('transaction.show', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_destroy" {{ old('transaction_destroy') || array_key_exists('transaction.destroy', $permissions) ? 'checked' : ''}}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
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

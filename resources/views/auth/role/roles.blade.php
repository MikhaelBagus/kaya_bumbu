<div class="checkbox checkbox-success">
    <input
        type="checkbox"
        value="ok"
        name="acl_all"
        class="styled acl"
        id="acl-all"
        style="margin-left: 0;"
        {{ old('acl_all') || array_key_exists('acl.all', $permissions) ? 'checked' : '' }}
    >
    <label for="acl-all">Check All</label>
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
                    <input type="checkbox" value="ok" class="styled acl" name="dashboard" {{ old('dashboard') || array_key_exists('dashboard', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- User -->
        <tr>
            <td>User</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_create" {{ old('user_create') || array_key_exists('user.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_edit" {{ old('user_edit') || array_key_exists('user.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_show" {{ old('user_show') || array_key_exists('user.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="user_destroy" {{ old('user_destroy') || array_key_exists('user.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" id="user_status" class="styled acl" name="user_status" {{ old('user_status') || array_key_exists('user.status', $permissions) ? 'checked' : '' }}>
                    <label for="user_status">@lang('auth.index_status_th')</label>
                </div>
            </td>
        </tr>

        <!-- Role -->
        <tr>
            <td>Role</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_create" {{ old('role_create') || array_key_exists('role.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_edit" {{ old('role_edit') || array_key_exists('role.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_show" {{ old('role_show') || array_key_exists('role.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="role_destroy" {{ old('role_destroy') || array_key_exists('role.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="log_show" {{ old('log_show') || array_key_exists('log.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <!-- About Us -->
        <tr>
            <td>About Us</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="about_us_create" {{ old('about_us_create') || array_key_exists('about_us.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="about_us_edit" {{ old('about_us_edit') || array_key_exists('about_us.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="about_us_show" {{ old('about_us_show') || array_key_exists('about_us.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="about_us_destroy" {{ old('about_us_destroy') || array_key_exists('about_us.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Contact Us -->
        <tr>
            <td>Contact Us</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="contact_us_create" {{ old('contact_us_create') || array_key_exists('contact_us.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="contact_us_edit" {{ old('contact_us_edit') || array_key_exists('contact_us.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="contact_us_show" {{ old('contact_us_show') || array_key_exists('contact_us.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="contact_us_destroy" {{ old('contact_us_destroy') || array_key_exists('contact_us.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Disclaimer -->
        <tr>
            <td>Disclaimer</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="disclaimer_create" {{ old('disclaimer_create') || array_key_exists('disclaimer.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="disclaimer_edit" {{ old('disclaimer_edit') || array_key_exists('disclaimer.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="disclaimer_show" {{ old('disclaimer_show') || array_key_exists('disclaimer.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="disclaimer_destroy" {{ old('disclaimer_destroy') || array_key_exists('disclaimer.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- FAQ -->
        <tr>
            <td>FAQ</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_create" {{ old('faq_create') || array_key_exists('faq.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_edit" {{ old('faq_edit') || array_key_exists('faq.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_show" {{ old('faq_show') || array_key_exists('faq.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="faq_destroy" {{ old('faq_destroy') || array_key_exists('faq.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="media_create" {{ old('media_create') || array_key_exists('media.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="media_edit" {{ old('media_edit') || array_key_exists('media.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="media_show" {{ old('media_show') || array_key_exists('media.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="media_destroy" {{ old('media_destroy') || array_key_exists('media.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- News -->
        <tr>
            <td>News</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_create" {{ old('news_create') || array_key_exists('news.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_edit" {{ old('news_edit') || array_key_exists('news.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_show" {{ old('news_show') || array_key_exists('news.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="news_destroy" {{ old('news_destroy') || array_key_exists('news.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="privacy_policy_create" {{ old('privacy_policy_create') || array_key_exists('privacy_policy.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="privacy_policy_edit" {{ old('privacy_policy_edit') || array_key_exists('privacy_policy.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="privacy_policy_show" {{ old('privacy_policy_show') || array_key_exists('privacy_policy.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="privacy_policy_destroy" {{ old('privacy_policy_destroy') || array_key_exists('privacy_policy.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Term Condition -->
        <tr>
            <td>Term Condition</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="term_condition_create" {{ old('term_condition_create') || array_key_exists('term_condition.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="term_condition_edit" {{ old('term_condition_edit') || array_key_exists('term_condition.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="term_condition_show" {{ old('term_condition_show') || array_key_exists('term_condition.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="term_condition_destroy" {{ old('term_condition_destroy') || array_key_exists('term_condition.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Calendar -->
        <tr>
            <td>Calendar</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="calendar_show" {{ old('calendar_show') || array_key_exists('calendar.show', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="productranking_show" {{ old('productranking_show') || array_key_exists('productranking.show', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="province_create" {{ old('province_create') || array_key_exists('province.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="province_edit" {{ old('province_edit') || array_key_exists('province.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="province_show" {{ old('province_show') || array_key_exists('province.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="province_destroy" {{ old('province_destroy') || array_key_exists('province.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="city_create" {{ old('city_create') || array_key_exists('city.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="city_edit" {{ old('city_edit') || array_key_exists('city.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="city_show" {{ old('city_show') || array_key_exists('city.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="city_destroy" {{ old('city_destroy') || array_key_exists('city.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="bank_create" {{ old('bank_create') || array_key_exists('bank.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="bank_edit" {{ old('bank_edit') || array_key_exists('bank.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="bank_show" {{ old('bank_show') || array_key_exists('bank.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="bank_destroy" {{ old('bank_destroy') || array_key_exists('bank.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Wallet -->
        <tr>
            <td>Wallet</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_create" {{ old('wallet_create') || array_key_exists('wallet.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_edit" {{ old('wallet_edit') || array_key_exists('wallet.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_show" {{ old('wallet_show') || array_key_exists('wallet.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="wallet_destroy" {{ old('wallet_destroy') || array_key_exists('wallet.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="source_create" {{ old('source_create') || array_key_exists('source.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="source_edit" {{ old('source_edit') || array_key_exists('source.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="source_show" {{ old('source_show') || array_key_exists('source.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="source_destroy" {{ old('source_destroy') || array_key_exists('source.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Supplier -->
        <tr>
            <td>Supplier</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_create" {{ old('supplier_create') || array_key_exists('supplier.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_edit" {{ old('supplier_edit') || array_key_exists('supplier.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_show" {{ old('supplier_show') || array_key_exists('supplier.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_destroy" {{ old('supplier_destroy') || array_key_exists('supplier.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Supplier Account -->
        <tr>
            <td>Supplier Account</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_account_create" {{ old('supplier_account_create') || array_key_exists('supplier_account.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_account_edit" {{ old('supplier_account_edit') || array_key_exists('supplier_account.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_account_show" {{ old('supplier_account_show') || array_key_exists('supplier_account.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="supplier_account_destroy" {{ old('supplier_account_destroy') || array_key_exists('supplier_account.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Warehouse -->
        <tr>
            <td>Warehouse</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="warehouse_create" {{ old('warehouse_create') || array_key_exists('warehouse.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="warehouse_edit" {{ old('warehouse_edit') || array_key_exists('warehouse.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="warehouse_show" {{ old('warehouse_show') || array_key_exists('warehouse.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="warehouse_destroy" {{ old('warehouse_destroy') || array_key_exists('warehouse.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Payment Method -->
        <tr>
            <td>Payment Method</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="payment_method_create" {{ old('payment_method_create') || array_key_exists('payment_method.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="payment_method_edit" {{ old('payment_method_edit') || array_key_exists('payment_method.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="payment_method_show" {{ old('payment_method_show') || array_key_exists('payment_method.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="payment_method_destroy" {{ old('payment_method_destroy') || array_key_exists('payment_method.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Expenditure Type -->
        <tr>
            <td>Expenditure Type</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="expenditure_type_create" {{ old('expenditure_type_create') || array_key_exists('expenditure_type.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="expenditure_type_edit" {{ old('expenditure_type_edit') || array_key_exists('expenditure_type.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="expenditure_type_show" {{ old('expenditure_type_show') || array_key_exists('expenditure_type.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="expenditure_type_destroy" {{ old('expenditure_type_destroy') || array_key_exists('expenditure_type.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_create" {{ old('ingredient_group_create') || array_key_exists('ingredient_group.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_edit" {{ old('ingredient_group_edit') || array_key_exists('ingredient_group.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_show" {{ old('ingredient_group_show') || array_key_exists('ingredient_group.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_group_destroy" {{ old('ingredient_group_destroy') || array_key_exists('ingredient_group.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_create" {{ old('ingredient_category_create') || array_key_exists('ingredient_category.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_edit" {{ old('ingredient_category_edit') || array_key_exists('ingredient_category.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_show" {{ old('ingredient_category_show') || array_key_exists('ingredient_category.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_destroy" {{ old('ingredient_category_destroy') || array_key_exists('ingredient_category.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_category_copy" {{ old('ingredient_category_copy') || array_key_exists('ingredient_category.copy', $permissions) ? 'checked' : '' }}>
                    <label>Copy</label>
                </div>
            </td>
        </tr>

        <!-- Ingredient -->
        <tr>
            <td>Ingredient</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_create" {{ old('ingredient_create') || array_key_exists('ingredient.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_edit" {{ old('ingredient_edit') || array_key_exists('ingredient.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_show" {{ old('ingredient_show') || array_key_exists('ingredient.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="ingredient_destroy" {{ old('ingredient_destroy') || array_key_exists('ingredient.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Product Category -->
        <tr>
            <td>Product Category</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_create" {{ old('product_category_create') || array_key_exists('product_category.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_edit" {{ old('product_category_edit') || array_key_exists('product_category.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_show" {{ old('product_category_show') || array_key_exists('product_category.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_destroy" {{ old('product_category_destroy') || array_key_exists('product_category.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_category_copy" {{ old('product_category_copy') || array_key_exists('product_category.copy', $permissions) ? 'checked' : '' }}>
                    <label>Copy</label>
                </div>
            </td>
        </tr>

        <!-- Product -->
        <tr>
            <td>Product</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_create" {{ old('product_create') || array_key_exists('product.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_edit" {{ old('product_edit') || array_key_exists('product.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_show" {{ old('product_show') || array_key_exists('product.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_destroy" {{ old('product_destroy') || array_key_exists('product.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="product_copy" {{ old('product_copy') || array_key_exists('product.copy', $permissions) ? 'checked' : '' }}>
                    <label>Copy</label>
                </div>
            </td>
        </tr>

        <!-- Recipe -->
        <tr>
            <td>Recipe</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_create" {{ old('recipe_create') || array_key_exists('recipe.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_edit" {{ old('recipe_edit') || array_key_exists('recipe.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_show" {{ old('recipe_show') || array_key_exists('recipe.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="recipe_destroy" {{ old('recipe_destroy') || array_key_exists('recipe.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="customer_create" {{ old('customer_create') || array_key_exists('customer.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="customer_edit" {{ old('customer_edit') || array_key_exists('customer.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="customer_show" {{ old('customer_show') || array_key_exists('customer.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="customer_destroy" {{ old('customer_destroy') || array_key_exists('customer.destroy', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="driver_create" {{ old('driver_create') || array_key_exists('driver.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="driver_edit" {{ old('driver_edit') || array_key_exists('driver.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="driver_show" {{ old('driver_show') || array_key_exists('driver.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="driver_destroy" {{ old('driver_destroy') || array_key_exists('driver.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

        <!-- Purchase -->
        <tr>
            <td>Purchase</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="purchase_create" {{ old('purchase_create') || array_key_exists('purchase.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="purchase_edit" {{ old('purchase_edit') || array_key_exists('purchase.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="purchase_show" {{ old('purchase_show') || array_key_exists('purchase.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="purchase_destroy" {{ old('purchase_destroy') || array_key_exists('purchase.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="purchase_download" {{ old('purchase_download') || array_key_exists('purchase.download', $permissions) ? 'checked' : '' }}>
                    <label>Download</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="purchase_approve" {{ old('purchase_approve') || array_key_exists('purchase.approve', $permissions) ? 'checked' : '' }}>
                    <label>Approve</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="purchase_paid" {{ old('purchase_paid') || array_key_exists('purchase.paid', $permissions) ? 'checked' : '' }}>
                    <label>Paid</label>
                </div>
            </td>
        </tr>

        <!-- Transaction -->
        <tr>
            <td>Transaction</td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_create" {{ old('transaction_create') || array_key_exists('transaction.create', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_edit" {{ old('transaction_edit') || array_key_exists('transaction.edit', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_show" {{ old('transaction_show') || array_key_exists('transaction.show', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td class="text-center">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_destroy" {{ old('transaction_destroy') || array_key_exists('transaction.destroy', $permissions) ? 'checked' : '' }}>
                    <label></label>
                </div>
            </td>
            <td>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_paymentstatus" {{ old('transaction_paymentstatus') || array_key_exists('transaction.paymentstatus', $permissions) ? 'checked' : '' }}>
                    <label>Payment Status</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_actualongkirprice" {{ old('transaction_actualongkirprice') || array_key_exists('transaction.actualongkirprice', $permissions) ? 'checked' : '' }}>
                    <label>Actual Ongkir Price</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_pdf" {{ old('transaction_pdf') || array_key_exists('transaction.pdf', $permissions) ? 'checked' : '' }}>
                    <label>PDF</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_invoice" {{ old('transaction_invoice') || array_key_exists('transaction.invoice', $permissions) ? 'checked' : '' }}>
                    <label>Invoice</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_deliverypdf" {{ old('transaction_deliverypdf') || array_key_exists('transaction.deliverypdf', $permissions) ? 'checked' : '' }}>
                    <label>Delivery PDF</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_startcooking" {{ old('transaction_startcooking') || array_key_exists('transaction.startcooking', $permissions) ? 'checked' : '' }}>
                    <label>Start Packing</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_startdelivery" {{ old('transaction_startdelivery') || array_key_exists('transaction.startdelivery', $permissions) ? 'checked' : '' }}>
                    <label>Start Delivery</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_enddelivery" {{ old('transaction_enddelivery') || array_key_exists('transaction.enddelivery', $permissions) ? 'checked' : '' }}>
                    <label>End Delivery</label>
                </div>
                <div class="checkbox checkbox-success">
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_suspend" {{ old('transaction_suspend') || array_key_exists('transaction.suspend', $permissions) ? 'checked' : '' }}>
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
                    <input type="checkbox" value="ok" class="styled acl" name="transaction_download_download" {{ old('transaction_download_download') || array_key_exists('transaction_download.download', $permissions) ? 'checked' : '' }}>
                    <label>Download</label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<!-- DataTables -->
<link rel="stylesheet" href="{{ url('plugins/datatables/media/css/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables/extensions/Responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css') }}">

<script src="{{ url('plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.js') }}"></script>
<script src="{{ url('plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js') }}"></script>

<script>
    $(function () {
        $('#acl-table').DataTable({
            aaSorting   : [[0, 'asc']],
            stateSave   : true,
            bPaginate   : false,
            bInfo       : false,
            responsive  : true,
            processing  : true,
            bFilter     : false,
            fixedHeader : true,
            @if(Session::get('locale') == 'cn')
            language    : { url: '{{ url('plugins/datatables/language/chinese.json') }}' },
            @endif
            columns     : [
                { orderable: true,  searchable: true  },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false },
                { orderable: false, searchable: false }
            ]
        });

        $('#acl-all').on('click', function () {
            var all = $('#acl-all');
            if (all.is(':checked')) {
                $('.acl').prop('checked', true);
            } else {
                $('.acl').prop('checked', false);
            }
        });
    });
</script>
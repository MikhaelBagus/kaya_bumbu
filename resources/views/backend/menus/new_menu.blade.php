@php
    $user = Sentinel::getUser();
    $role = $user && isset($user->roles[0]) ? $user->roles[0] : null;

    function hasMenuAccess($permission)
    {
        if (Sentinel::inRole('root')) {
            return true;
        }

        $user = Sentinel::getUser();
        $role = $user && isset($user->roles[0]) ? $user->roles[0] : null;

        if (!$role) {
            return false;
        }

        if (is_array($permission)) {
            return $role->hasAnyAccess($permission);
        }

        return $role->hasAccess([$permission]);
    }

    $isDashboardMenuActive =
        request()->path() == '/' ||
        request()->is('calendar*') ||
        request()->is('ranking-product*');

    $isMasterMenuActive =
        request()->is('roles*') ||
        request()->is('users*') ||
        request()->is('log*') ||
        request()->is('product*') ||
        request()->is('category-product*') ||
        request()->is('group-ingredient*') ||
        request()->is('category-ingredient*') ||
        request()->is('ingredient*') ||
        request()->is('recipe*') ||
        request()->is('bank*') ||
        request()->is('payment-method*') ||
        request()->is('expenditure-type*') ||
        request()->is('supplier*') ||
        request()->is('account-supplier*') ||
        request()->is('customer*') ||
        request()->is('warehouse*') ||
        request()->is('driver*');

    $isPurchasingMenuActive = request()->is('purchase*');

    $isTransactionMenuActive =
        request()->is('transaction*') ||
        request()->is('download-transaction*');
@endphp

{{-- 1. DASHBOARD --}}
@if(request()->path() == '/' || hasMenuAccess(['calendar.show', 'productranking.show']))
    <li class="{{ $isDashboardMenuActive ? 'active' : '' }}">
        <a class="accordion-toggle {{ $isDashboardMenuActive ? 'menu-open' : '' }}" href="#">
            <span class="fa fa-dashboard"></span>
            <span class="sidebar-title">Dashboard</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            <li class="{{ request()->path() == '/' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-dot-circle-o"></i> Dashboard
                </a>
            </li>

            @if(hasMenuAccess('calendar.show'))
                <li class="{{ request()->is('calendar*') ? 'active' : '' }}">
                    <a href="{{ route('calendar.index') }}">
                        <i class="fa fa-dot-circle-o"></i> Capacity Calendar
                    </a>
                </li>
            @endif

            @if(hasMenuAccess('productranking.show'))
                <li class="{{ request()->is('ranking-product*') ? 'active' : '' }}">
                    <a href="{{ route('product_ranking.index') }}">
                        <i class="fa fa-dot-circle-o"></i> Product Ranking
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif

{{-- 2. MASTER --}}
@if(
    hasMenuAccess([
        'role.show',
        'user.show',
        'log.show',
        'product.show',
        'product_category.show',
        'ingredient_group.show',
        'ingredient_category.show',
        'ingredient.show',
        'recipe.show',
        'bank.show',
        'payment_method.show',
        'expenditure_type.show',
        'supplier.show',
        'supplier_account.show',
        'customer.show',
        'warehouse.show',
        'driver.show'
    ])
)
    <li class="{{ $isMasterMenuActive ? 'active' : '' }}">
        <a class="accordion-toggle {{ $isMasterMenuActive ? 'menu-open' : '' }}" href="#">
            <span class="fa fa-database"></span>
            <span class="sidebar-title">Master</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">

            {{-- 2.A Activity --}}
            @if(hasMenuAccess(['role.show', 'user.show', 'log.show']))
                <li class="sidebar-label pt20">Activity</li>

                @if(hasMenuAccess('role.show'))
                    <li class="{{ request()->is('roles*') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Role
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('user.show'))
                    <li class="{{ request()->is('users*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-dot-circle-o"></i> User
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('log.show'))
                    <li class="{{ request()->is('log*') ? 'active' : '' }}">
                        <a href="{{ route('log.index') }}">
                            <i class="fa fa-dot-circle-o"></i> System Log
                        </a>
                    </li>
                @endif
            @endif

            {{-- 2.B Product --}}
            @if(hasMenuAccess(['product.show', 'product_category.show']))
                <li class="sidebar-label pt20">Product</li>

                @if(hasMenuAccess('product.show'))
                    <li class="{{ request()->is('product') || request()->is('product/*') ? 'active' : '' }}">
                        <a href="{{ route('product.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Product
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('product_category.show'))
                    <li class="{{ request()->is('category-product*') ? 'active' : '' }}">
                        <a href="{{ route('product_category.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Product Category
                        </a>
                    </li>
                @endif
            @endif

            {{-- 2.C Bill Of Material --}}
            @if(hasMenuAccess(['ingredient_group.show', 'ingredient_category.show', 'ingredient.show', 'recipe.show']))
                <li class="sidebar-label pt20">Bill Of Material</li>

                @if(hasMenuAccess('ingredient_group.show'))
                    <li class="{{ request()->is('group-ingredient*') ? 'active' : '' }}">
                        <a href="{{ route('ingredient_group.index') }}">
                            <i class="fa fa-dot-circle-o"></i> BOM Category
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('ingredient_category.show'))
                    <li class="{{ request()->is('category-ingredient*') ? 'active' : '' }}">
                        <a href="{{ route('ingredient_category.index') }}">
                            <i class="fa fa-dot-circle-o"></i> BOM Sub-Category
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('ingredient.show'))
                    <li class="{{ request()->is('ingredient*') ? 'active' : '' }}">
                        <a href="{{ route('ingredient.index') }}">
                            <i class="fa fa-dot-circle-o"></i> BOM Items
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('recipe.show'))
                    <li class="{{ request()->is('recipe*') ? 'active' : '' }}">
                        <a href="{{ route('recipe.index') }}">
                            <i class="fa fa-dot-circle-o"></i> BOM Recipe
                        </a>
                    </li>
                @endif
            @endif

            {{-- 2.D Finance --}}
            @if(hasMenuAccess(['bank.show', 'payment_method.show', 'expenditure_type.show']))
                <li class="sidebar-label pt20">Finance</li>

                @if(hasMenuAccess('bank.show'))
                    <li class="{{ request()->is('bank*') ? 'active' : '' }}">
                        <a href="{{ route('bank.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Wallet
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('payment_method.show'))
                    <li class="{{ request()->is('payment-method*') ? 'active' : '' }}">
                        <a href="{{ route('payment_method.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Payment Method
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('expenditure_type.show'))
                    <li class="{{ request()->is('expenditure-type*') ? 'active' : '' }}">
                        <a href="{{ route('expenditure_type.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Expense Category
                        </a>
                    </li>
                @endif
            @endif

            {{-- 2.E Supplier --}}
            @if(hasMenuAccess(['supplier.show', 'supplier_account.show']))
                <li class="sidebar-label pt20">Supplier</li>

                @if(hasMenuAccess('supplier.show'))
                    <li class="{{ request()->is('supplier*') ? 'active' : '' }}">
                        <a href="{{ route('supplier.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Supplier
                        </a>
                    </li>
                @endif

                @if(hasMenuAccess('supplier_account.show'))
                    <li class="{{ request()->is('account-supplier*') ? 'active' : '' }}">
                        <a href="{{ route('supplier_account.index') }}">
                            <i class="fa fa-dot-circle-o"></i> Supplier Account
                        </a>
                    </li>
                @endif
            @endif

            {{-- 2.F Customer --}}
            @if(hasMenuAccess('customer.show'))
                <li class="sidebar-label pt20">Customer</li>
                <li class="{{ request()->is('customer*') ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}">
                        <i class="fa fa-dot-circle-o"></i> Customer
                    </a>
                </li>
            @endif

            {{-- 2.G Warehouse --}}
            @if(hasMenuAccess('warehouse.show'))
                <li class="sidebar-label pt20">Warehouse</li>
                <li class="{{ request()->is('warehouse*') ? 'active' : '' }}">
                    <a href="{{ route('warehouse.index') }}">
                        <i class="fa fa-dot-circle-o"></i> Warehouse
                    </a>
                </li>
            @endif

            {{-- 2.H Delivery --}}
            @if(hasMenuAccess('driver.show'))
                <li class="sidebar-label pt20">Delivery</li>
                <li class="{{ request()->is('driver*') ? 'active' : '' }}">
                    <a href="{{ route('driver.index') }}">
                        <i class="fa fa-dot-circle-o"></i> List Driver
                    </a>
                </li>
            @endif

        </ul>
    </li>
@endif

{{-- 3. PURCHASING --}}
@if(hasMenuAccess('purchase.show'))
    <li class="{{ $isPurchasingMenuActive ? 'active' : '' }}">
        <a class="accordion-toggle {{ $isPurchasingMenuActive ? 'menu-open' : '' }}" href="#">
            <span class="fa fa-shopping-cart"></span>
            <span class="sidebar-title">Purchasing</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            <li class="{{ request()->is('purchase*') ? 'active' : '' }}">
                <a href="{{ route('purchase.index') }}">
                    <i class="fa fa-dot-circle-o"></i> Purchase Order
                </a>
            </li>
        </ul>
    </li>
@endif

{{-- 4. TRANSACTION --}}
@if(hasMenuAccess(['transaction.show', 'transaction_download.download']))
    <li class="{{ $isTransactionMenuActive ? 'active' : '' }}">
        <a class="accordion-toggle {{ $isTransactionMenuActive ? 'menu-open' : '' }}" href="#">
            <span class="fa fa-exchange"></span>
            <span class="sidebar-title">Transaction</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(hasMenuAccess('transaction.show'))
                <li class="{{ request()->is('transaction*') ? 'active' : '' }}">
                    <a href="{{ route('transaction.index') }}">
                        <i class="fa fa-dot-circle-o"></i> Sales Order
                    </a>
                </li>
            @endif

            @if(hasMenuAccess('transaction_download.download'))
                <li class="{{ request()->is('download-transaction*') ? 'active' : '' }}">
                    <a href="{{ route('transaction_download.index') }}">
                        <i class="fa fa-dot-circle-o"></i> Download Sales Order
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
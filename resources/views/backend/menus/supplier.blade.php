@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['supplier.show']) || Sentinel::getUser()->roles[0]->hasAccess(['supplier_account.show']))
    <li class="{{request()->is('supplier*') || request()->is('account-supplier*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('supplier*') || request()->is('account-supplier*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Supplier</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['supplier.show']))
                <li class="{{request()->is('supplier*') == true  ? 'active' : '' }}">
                    <a href="{{route('supplier.index')}}"><i class="fa fa-dot-circle-o"></i> Data Supplier</a>
                </li>
            @endif

            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['supplier_account.show']))
                <li class="{{request()->is('account-supplier*') ? 'active' : '' }}">
                    <a href="{{route('supplier_account.index')}}"><i class="fa fa-dot-circle-o"></i> Supplier Accounts</a>
                </li>
            @endif
        </ul>
    </li>
@endif

@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['purchase.show']))
    <li class="{{request()->is('purchase*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('purchase*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Purchase</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['purchase.show']))
                <li class="{{request()->is('purchase') || request()->is('purchase/*/show') || request()->is('purchase/*/edit') == true  ? 'active' : '' }}">
                    <a href="{{route('purchase.index')}}"><i class="fa fa-dot-circle-o"></i> Purchase List</a>
                </li>
            @endif
        </ul>
    </li>
@endif

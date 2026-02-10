@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['warehouse.show']))
    <li class="{{request()->is('warehouse*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('warehouse*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Warehouse</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['warehouse.show']))
                <li class="{{request()->is('warehouse*') == true  ? 'active' : '' }}">
                    <a href="{{route('warehouse.index')}}"><i class="fa fa-dot-circle-o"></i> Data Warehouse</a>
                </li>
            @endif
        </ul>
    </li>
@endif

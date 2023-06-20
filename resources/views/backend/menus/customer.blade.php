@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['customer.show']))
    <li class="{{request()->is('customer*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('customer*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Customer</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['customer.show']))
                <li class="{{request()->is('customer*') == true  ? 'active' : '' }}">
                    <a href="{{route('customer.index')}}"><i class="fa fa-dot-circle-o"></i> Data Customer</a>
                </li>
            @endif
        </ul>
    </li>
@endif

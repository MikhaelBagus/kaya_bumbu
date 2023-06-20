@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['province.show']))
    <li class="{{request()->is('province*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('province*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Province</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['province.show']))
                <li class="{{request()->is('province*') == true  ? 'active' : '' }}">
                    <a href="{{route('province.index')}}"><i class="fa fa-dot-circle-o"></i> Data Province</a>
                </li>
            @endif
        </ul>
    </li>
@endif

@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['city.show']))
    <li class="{{request()->is('city*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('city*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">City</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['city.show']))
                <li class="{{request()->is('city*') == true  ? 'active' : '' }}">
                    <a href="{{route('city.index')}}"><i class="fa fa-dot-circle-o"></i> Data City</a>
                </li>
            @endif
        </ul>
    </li>
@endif

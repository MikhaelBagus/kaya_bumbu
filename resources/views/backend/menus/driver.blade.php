@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['driver.show']))
    <li class="{{request()->is('driver*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('driver*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Driver</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['driver.show']))
                <li class="{{request()->is('driver*') == true  ? 'active' : '' }}">
                    <a href="{{route('driver.index')}}"><i class="fa fa-dot-circle-o"></i> Data Driver</a>
                </li>
            @endif
        </ul>
    </li>
@endif

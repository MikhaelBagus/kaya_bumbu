@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['log.show']))
    <li class="{{request()->is('log*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('log*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Log</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['log.show']))
                <li class="{{request()->is('log*') == true  ? 'active' : '' }}">
                    <a href="{{route('log.index')}}"><i class="fa fa-dot-circle-o"></i> Data Log</a>
                </li>
            @endif
        </ul>
    </li>
@endif

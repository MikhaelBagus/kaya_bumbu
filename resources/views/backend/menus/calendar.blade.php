@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['calendar.show']))
    <li class="{{request()->is('calendar*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('calendar*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Calendar</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['calendar.show']))
                <li class="{{request()->is('calendar*') == true  ? 'active' : '' }}">
                    <a href="{{route('calendar.index')}}"><i class="fa fa-dot-circle-o"></i> Data Calendar</a>
                </li>
            @endif
        </ul>
    </li>
@endif

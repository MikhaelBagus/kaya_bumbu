@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['disclaimer.show']))
    <li class="{{request()->is('disclaimer*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('disclaimer*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Disclaimer</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['disclaimer.show']))
                <li class="{{request()->is('disclaimer*') == true  ? 'active' : '' }}">
                    <a href="{{route('disclaimer.index')}}"><i class="fa fa-dot-circle-o"></i> Data Disclaimer</a>
                </li>
            @endif
        </ul>
    </li>
@endif

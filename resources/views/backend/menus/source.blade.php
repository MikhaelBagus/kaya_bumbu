@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['source.show']))
    <li class="{{request()->is('source*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('source*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Source</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['source.show']))
                <li class="{{request()->is('source*') == true  ? 'active' : '' }}">
                    <a href="{{route('source.index')}}"><i class="fa fa-dot-circle-o"></i> Data Source</a>
                </li>
            @endif
        </ul>
    </li>
@endif

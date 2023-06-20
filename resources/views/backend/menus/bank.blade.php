@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['bank.show']))
    <li class="{{request()->is('bank*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('bank*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Bank</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['bank.show']))
                <li class="{{request()->is('bank*') == true  ? 'active' : '' }}">
                    <a href="{{route('bank.index')}}"><i class="fa fa-dot-circle-o"></i> Data Bank</a>
                </li>
            @endif
        </ul>
    </li>
@endif

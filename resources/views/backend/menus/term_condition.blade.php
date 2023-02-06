@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['term_condition.show']))
    <li class="{{request()->is('term-condition*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('term-condition*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Term Condition</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['term_condition.show']))
                <li class="{{request()->is('term-condition*') == true  ? 'active' : '' }}">
                    <a href="{{route('term_condition.index')}}"><i class="fa fa-dot-circle-o"></i> Data Term Condition</a>
                </li>
            @endif
        </ul>
    </li>
@endif

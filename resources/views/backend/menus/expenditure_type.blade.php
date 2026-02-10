@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['expenditure_type.show']))
    <li class="{{request()->is('expenditure-type*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('expenditure-type*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Expenditure Type</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['expenditure_type.show']))
                <li class="{{request()->is('expenditure-type') == true  ? 'active' : '' }}">
                    <a href="{{route('expenditure_type.index')}}"><i class="fa fa-dot-circle-o"></i> Data Expenditure Type</a>
                </li>
            @endif
        </ul>
    </li>
@endif

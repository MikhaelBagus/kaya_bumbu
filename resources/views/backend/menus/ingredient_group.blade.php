@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['ingredient_group.show']))
    <li class="{{request()->is('group-ingredient*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('group-ingredient*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Ingredient Group</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['ingredient_group.show']))
                <li class="{{request()->is('group-ingredient') == true  ? 'active' : '' }}">
                    <a href="{{route('ingredient_group.index')}}"><i class="fa fa-dot-circle-o"></i> Data Ingredient Group</a>
                </li>
            @endif
        </ul>
    </li>
@endif

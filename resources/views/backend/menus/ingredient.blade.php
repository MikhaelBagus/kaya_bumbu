@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['ingredient.show']))
    <li class="{{request()->is('ingredient*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('ingredient*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Ingredient</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['ingredient.show']))
                <li class="{{request()->is('ingredient*') == true  ? 'active' : '' }}">
                    <a href="{{route('ingredient.index')}}"><i class="fa fa-dot-circle-o"></i> Data Ingredient</a>
                </li>
            @endif
        </ul>
    </li>
@endif

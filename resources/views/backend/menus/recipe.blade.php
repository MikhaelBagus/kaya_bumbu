@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['recipe.show']))
    <li class="{{request()->is('recipe*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('recipe*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Recipe</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['recipe.show']))
                <li class="{{request()->is('recipe') == true  ? 'active' : '' }}">
                    <a href="{{route('recipe.index')}}"><i class="fa fa-dot-circle-o"></i> Data Recipe</a>
                </li>
            @endif
        </ul>
    </li>
@endif

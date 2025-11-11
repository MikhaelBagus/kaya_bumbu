@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['ingredient_category.show']))
    <li class="{{request()->is('category-ingredient*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('category-ingredient*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Ingredient Category</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['ingredient_category.show']))
                <li class="{{request()->is('category-ingredient') == true  ? 'active' : '' }}">
                    <a href="{{route('ingredient_category.index')}}"><i class="fa fa-dot-circle-o"></i> Data Ingredient Category</a>
                </li>
            @endif
        </ul>
    </li>
@endif

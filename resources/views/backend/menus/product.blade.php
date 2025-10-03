@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product.show']))
    <li class="{{request()->is('product*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('product*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Product</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product.show']))
                <li class="{{request()->is('product') == true  ? 'active' : '' }}">
                    <a href="{{route('product.index')}}"><i class="fa fa-dot-circle-o"></i> Data Product</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product.show']))
                <li class="{{request()->is('product/recipe*') == true  ? 'active' : '' }}">
                    <a href="{{route('product.recipe.index')}}"><i class="fa fa-dot-circle-o"></i> Data Resep Product</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product.show']))
                <li class="{{request()->is('product/ingredient*') == true  ? 'active' : '' }}">
                    <a href="{{route('product.ingredient.index')}}"><i class="fa fa-dot-circle-o"></i> Data Master Product</a>
                </li>
            @endif
        </ul>
    </li>
@endif

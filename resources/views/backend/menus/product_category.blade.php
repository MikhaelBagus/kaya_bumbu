@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product_category.show']))
    <li class="{{request()->is('category-product*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('category-product*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Product Category</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product_category.show']))
                <li class="{{request()->is('category-product*') == true  ? 'active' : '' }}">
                    <a href="{{route('product_category.index')}}"><i class="fa fa-dot-circle-o"></i> Data Product Category</a>
                </li>
            @endif
        </ul>
    </li>
@endif

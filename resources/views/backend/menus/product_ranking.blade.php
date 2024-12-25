@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product_ranking.show']))
    <li class="{{request()->is('ranking-product*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('ranking-product*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Product Ranking</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['product_ranking.show']))
                <li class="{{request()->is('ranking-product*') == true  ? 'active' : '' }}">
                    <a href="{{route('product_ranking.index')}}"><i class="fa fa-dot-circle-o"></i> Data Product Ranking</a>
                </li>
            @endif
        </ul>
    </li>
@endif

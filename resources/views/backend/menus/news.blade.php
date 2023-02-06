@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['news.show']))
    <li class="{{request()->is('news*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('news*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">News</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['news.show']))
                <li class="{{request()->is('news*') == true  ? 'active' : '' }}">
                    <a href="{{route('news.index')}}"><i class="fa fa-dot-circle-o"></i> Data News</a>
                </li>
            @endif
        </ul>
    </li>
@endif

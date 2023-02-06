@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['about_us.show']))
    <li class="{{request()->is('about-us*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('about-us*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">About Us</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['about_us.show']))
                <li class="{{request()->is('about-us*') == true  ? 'active' : '' }}">
                    <a href="{{route('about_us.index')}}"><i class="fa fa-dot-circle-o"></i> Data About Us</a>
                </li>
            @endif
        </ul>
    </li>
@endif

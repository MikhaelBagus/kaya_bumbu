@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['contact_us.show']))
    <li class="{{request()->is('contact-us*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('contact-us*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Contact Us</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['contact_us.show']))
                <li class="{{request()->is('contact-us*') == true  ? 'active' : '' }}">
                    <a href="{{route('contact_us.index')}}"><i class="fa fa-dot-circle-o"></i> Data Contact Us</a>
                </li>
            @endif
        </ul>
    </li>
@endif

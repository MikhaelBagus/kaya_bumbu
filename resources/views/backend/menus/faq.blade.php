@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['faq.show']))
    <li class="{{request()->is('faq*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('faq*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Faq</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['faq.show']))
                <li class="{{request()->is('faq*') == true  ? 'active' : '' }}">
                    <a href="{{route('faq.index')}}"><i class="fa fa-dot-circle-o"></i> Data Faq</a>
                </li>
            @endif
        </ul>
    </li>
@endif

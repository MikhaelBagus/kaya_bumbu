@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['province.show']) || Sentinel::getUser()->roles[0]->hasAccess(['city.show']) || Sentinel::getUser()->roles[0]->hasAccess(['about_us.show']) || Sentinel::getUser()->roles[0]->hasAccess(['contact_us.show']) || Sentinel::getUser()->roles[0]->hasAccess(['disclaimer.show']) || Sentinel::getUser()->roles[0]->hasAccess(['privacy_policy.show']) || Sentinel::getUser()->roles[0]->hasAccess(['term_condition.show']) || Sentinel::getUser()->roles[0]->hasAccess(['faq.show']) || Sentinel::getUser()->roles[0]->hasAccess(['news.show']))
    <li class="{{(request()->is('province*') || request()->is('city*') || request()->is('about-us*') || request()->is('contact-us*') || request()->is('disclaimer*') || request()->is('privacy-policy*') || request()->is('term-condition*') || request()->is('faq*') || request()->is('news*')) == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{(request()->is('province*') || request()->is('city*') || request()->is('about-us*') || request()->is('contact-us*') || request()->is('disclaimer*') || request()->is('privacy-policy*') || request()->is('term-condition*') || request()->is('faq*') || request()->is('news*')) == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Others</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['province.show']))
                <li class="{{request()->is('province*') == true  ? 'active' : '' }}">
                    <a href="{{route('province.index')}}"><i class="fa fa-dot-circle-o"></i> Data Province</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['city.show']))
                <li class="{{request()->is('city*') == true  ? 'active' : '' }}">
                    <a href="{{route('city.index')}}"><i class="fa fa-dot-circle-o"></i> Data City</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['about_us.show']))
                <li class="{{request()->is('about-us*') == true  ? 'active' : '' }}">
                    <a href="{{route('about_us.index')}}"><i class="fa fa-dot-circle-o"></i> Data About Us</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['contact_us.show']))
                <li class="{{request()->is('contact-us*') == true  ? 'active' : '' }}">
                    <a href="{{route('contact_us.index')}}"><i class="fa fa-dot-circle-o"></i> Data Contact Us</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['disclaimer.show']))
                <li class="{{request()->is('disclaimer*') == true  ? 'active' : '' }}">
                    <a href="{{route('disclaimer.index')}}"><i class="fa fa-dot-circle-o"></i> Data Disclaimer</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['privacy_policy.show']))
                <li class="{{request()->is('privacy-policy*') == true  ? 'active' : '' }}">
                    <a href="{{route('privacy_policy.index')}}"><i class="fa fa-dot-circle-o"></i> Data Privacy Policy</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['term_condition.show']))
                <li class="{{request()->is('term-condition*') == true  ? 'active' : '' }}">
                    <a href="{{route('term_condition.index')}}"><i class="fa fa-dot-circle-o"></i> Data Term Condition</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['faq.show']))
                <li class="{{request()->is('faq*') == true  ? 'active' : '' }}">
                    <a href="{{route('faq.index')}}"><i class="fa fa-dot-circle-o"></i> Data Faq</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['news.show']))
                <li class="{{request()->is('news*') == true  ? 'active' : '' }}">
                    <a href="{{route('news.index')}}"><i class="fa fa-dot-circle-o"></i> Data News</a>
                </li>
            @endif
        </ul>
    </li>
@endif

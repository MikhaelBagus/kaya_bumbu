@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['privacy_policy.show']))
    <li class="{{request()->is('privacy-policy*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('privacy-policy*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Privacy Policy</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['privacy_policy.show']))
                <li class="{{request()->is('privacy-policy*') == true  ? 'active' : '' }}">
                    <a href="{{route('privacy_policy.index')}}"><i class="fa fa-dot-circle-o"></i> Data Privacy Policy</a>
                </li>
            @endif
        </ul>
    </li>
@endif

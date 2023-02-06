@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['media.show']))
    <li class="{{request()->is('media-kayabumbu*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('media-kayabumbu*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Media</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['media.show']))
                <li class="{{request()->is('media-kayabumbu*') == true  ? 'active' : '' }}">
                    <a href="{{route('media.index')}}"><i class="fa fa-dot-circle-o"></i> Data Media</a>
                </li>
            @endif
        </ul>
    </li>
@endif

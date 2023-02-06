@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAnyAccess(['user.show', 'role.show']))
    <li class="{{(request()->is('users*') || request()->is('roles*')) == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{(request()->is('users*') || request()->is('roles*')) == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-key"></span>
            <span class="sidebar-title">USER & ACCESS</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['user.create']))
                <li class="{{request()->is('users/create') == true  ? 'active' : '' }}">
                    <a href="{{route('users.create')}}"><i class="fa fa-dot-circle-o"></i> Create User</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['user.show']))
                <li class="{{request()->is('users*') == true && request()->is('users/create') == false  ? 'active' : '' }}">
                    <a href="{{route('users.index')}}"><i class="fa fa-dot-circle-o"></i> Data User</a>
                </li>
            @endif
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['role.show']))
                <li class="{{request()->is('roles*') == true  ? 'active' : '' }}">
                    <a href="{{route('roles.index')}}"><i class="fa fa-dot-circle-o"></i> Access Control List</a>
                </li>
            @endif
        </ul>
    </li>
@endif

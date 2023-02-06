@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['transaction.show']))
    <li class="{{request()->is('transaction*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('transaction*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Transaction</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['transaction.show']))
                <li class="{{request()->is('transaction*') == true  ? 'active' : '' }}">
                    <a href="{{route('transaction.index')}}"><i class="fa fa-dot-circle-o"></i> Data Transaction</a>
                </li>
            @endif
        </ul>
    </li>
@endif

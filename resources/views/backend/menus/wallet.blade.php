@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['wallet.show']))
    <li class="{{request()->is('wallet*') ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('wallet*') ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Wallet</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            

            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['wallet.show']))
                <li class="{{request()->is('wallet*') ? 'active' : '' }}">
                    <a href="{{route('wallet.index')}}"><i class="fa fa-dot-circle-o"></i> Wallet</a>
                </li>
            @endif
        </ul>
    </li>
@endif

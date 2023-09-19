@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['transaction_download.download']))
    <li class="{{request()->is('download-transaction*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('download-transaction*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Download Transaction</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['transaction_download.download']))
                <li class="{{request()->is('download-transaction*') == true  ? 'active' : '' }}">
                    <a href="{{route('transaction_download.index')}}"><i class="fa fa-dot-circle-o"></i> Download Transaction</a>
                </li>
            @endif
        </ul>
    </li>
@endif

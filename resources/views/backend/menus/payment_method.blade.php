@if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['payment_method.show']))
    <li class="{{request()->is('payment-method*') == true  ? 'active' : '' }}">
        <a class="accordion-toggle {{request()->is('payment-method*') == true  ? 'menu-open' : '' }}" href="#">
            <span class="fas fa-dot-circle-o"></span>
            <span class="sidebar-title">Payment Method</span>
            <span class="caret"></span>
        </a>

        <ul class="nav sub-nav">
            @if(Sentinel::inRole('root') || Sentinel::getUser()->roles[0]->hasAccess(['payment_method.show']))
                <li class="{{request()->is('payment-method') == true  ? 'active' : '' }}">
                    <a href="{{route('payment_method.index')}}"><i class="fa fa-dot-circle-o"></i> Data Payment Method</a>
                </li>
            @endif
        </ul>
    </li>
@endif

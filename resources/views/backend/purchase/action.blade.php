<a style="font-size: 24px;" href="{{ route('purchase.show', $data->id) }}" id="tooltip" title="{{ trans('global.show') }}">
    <span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span>
</a>

@if(Sentinel::inRole('root'))
    <a style="font-size: 24px;" href="{{ route('purchase.edit', [$data->id]) }}" id="tooltip" title="{{ trans('global.update') }}">
        <span class="label label-warning label-sm"><i class="fa fa-edit"></i></span>
    </a>
    <a style="font-size: 24px;" href="#" data-message="{{ trans('auth.delete_confirmation', ['name' => $data->code]) }}" data-href="{{ route('purchase.destroy', [$data->id]) }}" id="tooltip" data-method="DELETE" data-title="{{ trans('global.delete') }}" data-toggle="modal" data-target="#delete">
        <span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span>
    </a>
    @if($data->status == 'draft')
    <a style="font-size: 24px;" href="#" data-message="{{ trans('auth.approve_confirmation', ['name' => $data->code]) }}" data-href="{{ route('purchase.approve', [$data->id]) }}" id="tooltip" data-method="PUT" data-title="{{ trans('global.approve') }}" data-toggle="modal" data-target="#delete">
        <span class="label label-success label-sm"><i class="fa fa-check"></i></span>
    </a>
    @elseif($data->status == 'waiting_for_payment')
    <a style="font-size: 24px;" href="#" data-message="{{ trans('auth.paid_confirmation', ['name' => $data->code]) }}" data-href="{{ route('purchase.paid', [$data->id]) }}" id="tooltip" data-method="PUT" data-title="{{ trans('global.paid') }}" data-toggle="modal" data-target="#delete">
        <span class="label label-success label-sm"><i class="fa fa-credit-card"></i></span>
    </a>
    @endif
@else
    @if($data->status == 'draft')
    <a style="font-size: 24px;" href="{{ route('purchase.edit', [$data->id]) }}" id="tooltip" title="{{ trans('global.update') }}">
        <span class="label label-warning label-sm"><i class="fa fa-edit"></i></span>
    </a>
    <a style="font-size: 24px;" href="#" data-message="{{ trans('auth.delete_confirmation', ['name' => $data->code]) }}" data-href="{{ route('purchase.destroy', [$data->id]) }}" id="tooltip" data-method="DELETE" data-title="{{ trans('global.delete') }}" data-toggle="modal" data-target="#delete">
        <span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span>
    </a>
    @elseif($data->status == 'waiting_for_payment')
    @elseif($data->status == 'paid')
    @endif
@endif
<a style="font-size: 24px;" href="{{ route('purchase.show', $data->id) }}" id="tooltip" title="{{ trans('global.show') }}">
    <span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span>
</a>
@if($data->status == 'approved' || $data->status == 'rejected')
@else
<a style="font-size: 24px;" href="{{ route('purchase.edit', [$data->id]) }}" id="tooltip" title="{{ trans('global.update') }}">
    <span class="label label-warning label-sm"><i class="fa fa-edit"></i></span>
</a>
@endif
@if($data->status == 'draft' || $data->status == 'submitted')
<a style="font-size: 24px;" href="#" data-message="{{ trans('auth.delete_confirmation', ['name' => $data->code]) }}" data-href="{{ route('purchase.destroy', [$data->id]) }}" id="tooltip" data-method="DELETE" data-title="{{ trans('global.delete') }}" data-toggle="modal" data-target="#delete">
    <span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span>
</a>
@endif
@if($data->status == 'draft' || $data->status == 'submitted')
<a style="font-size: 24px;" href="#" data-message="{{ trans('auth.approve_confirmation', ['name' => $data->code]) }}" data-href="{{ route('purchase.approve', [$data->id]) }}" id="tooltip" data-method="PUT" data-title="{{ trans('global.approve') }}" data-toggle="modal" data-target="#delete">
    <span class="label label-success label-sm"><i class="fa fa-check"></i></span>
</a>
@endif
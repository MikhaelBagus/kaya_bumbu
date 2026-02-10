@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Warehouse Update Form
                </div>
            </div>

            <form action="{{route('warehouse.update', [request()->id])}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    {{method_field('PUT')}}

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('warehouse_name')) has-error @endif">
                            <label for="warehouse_name" class="control-label">Warehouse Name <span style="color: red">*</span></label>
                            <input type="text" name="warehouse_name" id="warehouse_name" value="{{old('warehouse_name', $warehouse->warehouse_name)}}" class="form-control input-sm" placeholder="Warehouse Name ...*" required>
                            {!! $errors->first('warehouse_name', '<em for="warehouse_name" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('warehouse_description')) has-error @endif">
                            <label for="warehouse_description" class="control-label">Warehouse Description</label>
                            <textarea name="warehouse_description" id="warehouse_description" class="form-control input-sm" placeholder="Warehouse Description ..." rows="3">{{old('warehouse_description', $warehouse->warehouse_description)}}</textarea>
                            {!! $errors->first('warehouse_description', '<em for="warehouse_description" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                </div>

                <div class="panel-footer">
                    <input type="hidden" value="{{old('previousUrl', url()->previous())}}" name="previousUrl">
                    <a href="{{old('previousUrl', url()->previous())}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> @lang('global.cancel')
                    </a>

                    <div class="pull-right">
                        <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-save"></i> {{__('global.save')}}</span>
                            <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </form>
        </div>
    </section>
@endsection

@push('css')
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2-bootstrap.css')}}">
@endpush

@push('scripts')
    <script src="{{url('plugins/select2/js/select2.full.js')}}"></script>

    <script>
        //Disable Enter
        $(document).keypress(function (event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });
    </script>
@endpush

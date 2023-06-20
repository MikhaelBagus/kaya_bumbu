@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')

        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Transaction Update Form
                </div>
            </div>

            <form action="{{route('transaction.update_actual_ongkir_price', [request()->id])}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    {{method_field('PUT')}}
                    
                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('actual_ongkir_price')) has-error @endif">
                            <label for="actual_ongkir_price" class="control-label">Actual Ongkir Price <span style="color: red">*</span></label>
                            <input type="number" name="actual_ongkir_price" id="actual_ongkir_price" value="{{old('actual_ongkir_price', $transaction->actual_ongkir_price)}}" class="form-control input-sm" placeholder="Actual Ongkir Price ...*" required>
                            {!! $errors->first('actual_ongkir_price', '<em for="actual_ongkir_price" class="text-danger">:message</em>') !!}
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
    <link rel="stylesheet" href="{{url('theme/app/vendor/plugins/summernote/summernote.css')}}">

@endpush

@push('scripts')
    <script src="{{url('plugins/select2/js/select2.full.js')}}"></script>
    <script src="{{url('theme/app/vendor/plugins/summernote/summernote.min.js')}}"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                placeholder: 'Content ...*',
                tabsize: 2,
                height: 150,
                fontSizes: ['8', '9', '10', '11', '12', '13','14', '18', '24', '36', '48' , '64', '82', '150'],
                toolbar: [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "clear"]],
                    ["fontname", ["fontname"]],
                    ['fontsize', ['fontsize']],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["table", ["table"]],
                    ["insert", ["link", "hr", "video","picture"]],
                    ["view", ["fullscreen", "codeview", "help"]]
                ]
            });
        })

    </script>
    <script>
        //Disable Enter
        $(document).keypress(function (event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });
    </script>
@endpush
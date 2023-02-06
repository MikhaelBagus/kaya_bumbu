@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
        
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>Faq Create Form
                </div>
            </div>
            
            <form action="{{route('faq.store')}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('question')) has-error @endif">
                            <label for="question" class="control-label">Question <span style="color: red">*</span></label>
                            <input type="text" name="question" id="question" value="{{old('question')}}" class="form-control input-sm" placeholder="Question ...*" required>
                            {!! $errors->first('question', '<em for="question" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('answer')) has-error @endif">
                            <label for="answer" class="control-label">Answer <span style="color: red">*</span></label>
                            <textarea id="summernote" name="answer" class="form-control input-sm" placeholder="Answer ...*">{!! old('answer') !!}</textarea>
                            {!! $errors->first('answer', '<em for="answer" class="text-danger">:message</em>') !!}
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <input type="hidden" value="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" name="previousUrl">
                    <a href="{{old('previousUrl') ? old('previousUrl') : url()->previous()}}" class="btn btn-flat btn-default btn-sm"><i class="fa fa-reply"></i> @lang('auth.form_user_cancel_btn')</a>
                    
                    <div class="pull-right">
                        <button type="submit" class="btn ladda-button btn-success btn-sm" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-save"></i> @lang('auth.form_user_submit_btn')</span>
                            <span class="ladda-spinner"><div class="ladda-progress" style="width: 0px;"></div></span></button>
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
            // $('#summernote').summernote({
            //     placeholder: 'Content ...*',
            //     tabsize: 2,
            //     height: 150,
            //     fontSizes: ['8', '9', '10', '11', '12', '13','14', '18', '24', '36', '48' , '64', '82', '150'],
            //     toolbar: [
            //         ["style", ["style"]],
            //         ["font", ["bold", "underline", "clear"]],
            //         ["fontname", ["fontname"]],
            //         ['fontsize', ['fontsize']],
            //         ["color", ["color"]],
            //         ["para", ["ul", "ol", "paragraph"]],
            //         ["table", ["table"]],
            //         ["insert", ["link", "hr", "video","picture"]],
            //         ["view", ["fullscreen", "codeview", "help"]]
            //     ]
            // });

            $('#publish').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                containerCssClass: ':all:',
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
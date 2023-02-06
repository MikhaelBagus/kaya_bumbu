@extends('backend.layouts.app')
@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
        
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>News Create Form
                </div>
            </div>
            
            <form action="{{route('news.store')}}" method="post" enctype="multipart/form-data">
                <div class="panel-body">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('title')) has-error @endif">
                            <label for="title" class="control-label">Title <span style="color: red">*</span></label>
                            <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control input-sm" placeholder="Title ...*" required>
                            {!! $errors->first('title', '<em for="title" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('content')) has-error @endif">
                            <label for="content" class="control-label">Content <span style="color: red">*</span></label>
                            <textarea id="summernote" name="content" class="form-control input-sm" placeholder="Content ...*">{!! old('content') !!}</textarea>
                            {!! $errors->first('content', '<em for="content" class="text-danger">:message</em>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('publish')) has-error @endif">
                            <label class="control-label">Publish <span style="color: red">*</span></label>
                            <select name="publish" id="publish" class="form-control input-sm select_2" style="width: 100%;" data-placeholder="Select..*" required>
                                <option></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            {!! $errors->first('publish', '<p for="publish" class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group @if($errors->has('image')) has-error @endif">
                            <label for="image" class="control-label">Image (Max 10MB)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" accept="image/*" name="image" id="image"/>
                                <label class="custom-file-label" for="image" id="label_image">Choose file</label>
                            </div>
                            {!! $errors->first('image', '<em for="image" class="text-danger">:message</em>') !!}
                        </div>

                        <div class="row" id="show_image">
                            <div class="col-lg-3">
                                <div class="card card-custom gutter-b">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 mr-7">
                                                <div class="symbol symbol-50 symbol-lg-120">
                                                    <img id="preview_image"/>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="imageRemove()">Remove</button>
                                    </div>
                                </div>
                            </div>
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
        (function() {
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

            $('#publish').select2({
                theme: "bootstrap",
                placeholder: "Select",
                width: '100%',
                containerCssClass: ':all:',
            });

            $('#show_image').hide();
        })();

        function imageRemove()
        {
            // $('#image').attr("required", true);
            $('#show_image').hide();
            $('#label_image').text("Choose file");
            $('#image').val("");
        }

        function readURLImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#label_image').text(input.files[0].name);
                    $('#show_image').show();
                    $('#preview_image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function(){
            if(this.files[0].size > 10485760){
               alert("File is too big!");
               this.value = "";
            }
            else{
                readURLImage(this);
            }
        });
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
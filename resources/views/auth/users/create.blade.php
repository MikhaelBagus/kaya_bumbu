@extends('backend.layouts.app')

@section('content')
    <section id="content" class="animated fadeIn">
        @include('flash')
        <div class="panel panel-visible">
            <div class="panel-heading">
                <div class="panel-title hidden-xs">
                    <span class="glyphicon glyphicon-tasks"></span>@lang('auth.form_user_heading')
                </div>
            </div>
            <form action="{{route('users.store')}}" method="post">
                <div class="panel-body">
                    {!! csrf_field() !!}
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            <label for="name" class="control-label">@lang('auth.index_name_th') <span style="color: red">*</span></label>
                            <input type="text" name="name" class="form-control input-sm" placeholder="@lang('auth.index_name_th')" value="{{ old('name') }}" tabindex="1" required>
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('phone')) has-error @endif">
                            <label for="phone" class="control-label">@lang('auth.form_user_phone_label') <span style="color: red">*</span></label>
                            <input type="number" name="phone" class="form-control input-sm" placeholder="@lang('auth.form_user_phone_label')" value="{{ old('phone') }}" tabindex="1" required>
                            {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('email')) has-error @endif">
                            <label for="email" class="control-label">@lang('auth.form_user_email_label') <span style="color: red">*</span></label>
                            <input type="email" name="email" class="form-control input-sm" placeholder="user@klikabc.com" value="{{ old('email') }}" tabindex="3" required>
                            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group @if($errors->has('password')) has-error @endif">
                            <label for="password" class="control-label">@lang('auth.form_user_password_label') <span style="color: red">*</span></label>
                            <input type="password" name="password" class="form-control input-sm" placeholder="@lang('auth.form_user_password_label')" value="{{old('password')}}" tabindex="5" required>
                            <span class="help-block margin-top-sm">{{trans('auth.form_user_password_long')}}</span>
                            {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('role')) has-error @endif">
                            <label for="role" class="control-label">@lang('auth.form_user_role_label') <span style="color: red">*</span></label>
                            <select name="role" class="form-control input-sm" data-placeholder="@lang('auth.form_user_role_select')" tabindex="4" id="roleSelect" required>
                            </select>
                            {!! $errors->first('role', '<p class="text-danger">:message</p>') !!}

                        </div>

                        <div class="form-group @if($errors->has('password')) has-error @endif">
                            <label for="password_confirmation" class="control-label">@lang('auth.form_user_password_confirm_label') <span style="color: red">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control input-sm" placeholder="@lang('auth.form_user_password_confirm_label')" value="{{old('password_confirmation')}}" tabindex="6" required>
                            <span class="help-block margin-top-sm">@lang('auth.form_user_password_type_again')</span>
                            {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                        </div>

                    </div>

                    <div class="col-md-12" id="userPenilaiPublik">

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('no_mappi')) has-error @endif">
                                <label for="no_mappi" class="control-label">No MAPPI <span style="color: red">*</span></label>
                                <textarea name="no_mappi" id="no_mappi" class="form-control input-sm" placeholder="No MAPPI ...*">{{old('no_mappi')}}</textarea>
                                {!! $errors->first('no_mappi', '<em for="no_mappi" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('no_izin_penilai_publik')) has-error @endif">
                                <label for="no_izin_penilai_publik" class="control-label">No Izin Penilai Publik <span style="color: red">*</span></label>
                                <textarea name="no_izin_penilai_publik" id="no_izin_penilai_publik" class="form-control input-sm" placeholder="No Izin Penilai Publik ...*">{{old('no_izin_penilai_publik')}}</textarea>
                                {!! $errors->first('no_izin_penilai_publik', '<em for="no_izin_penilai_publik" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('no_izin_bpn')) has-error @endif">
                                <label for="no_izin_bpn" class="control-label">No Izin BPN <span style="color: red">*</span></label>
                                <textarea name="no_izin_bpn" id="no_izin_bpn" class="form-control input-sm" placeholder="No Izin BPN ...*">{{old('no_izin_bpn')}}</textarea>
                                {!! $errors->first('no_izin_bpn', '<em for="no_izin_bpn" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('no_register_penilai')) has-error @endif">
                                <label for="no_register_penilai" class="control-label">No Register Penilai <span style="color: red">*</span></label>
                                <textarea name="no_register_penilai" id="no_register_penilai" class="form-control input-sm" placeholder="no_register_penilai ...*">{{old('no_register_penilai')}}</textarea>
                                {!! $errors->first('no_register_penilai', '<em for="no_register_penilai" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('description')) has-error @endif">
                                <label for="description" class="control-label">Description <span style="color: red">*</span></label>
                                <textarea name="description" id="description" class="form-control input-sm" placeholder="Description ...*">{{old('description')}}</textarea>
                                {!! $errors->first('description', '<em for="description" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('address')) has-error @endif">
                                <label for="address" class="control-label">Address <span style="color: red">*</span></label>
                                <textarea name="address" id="address" class="form-control input-sm" placeholder="Address ...*">{{old('address')}}</textarea>
                                {!! $errors->first('address', '<em for="address" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('city_id')) has-error @endif">
                                <label class="control-label">City <span style="color: red">*</span></label>
                                <select name="city_id" id="city_id" class="form-control input-sm select_2" style="width: 100%;" data-placeholder="City..*">
                                </select>
                                {!! $errors->first('city_id', '<p for="city_id" class="text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('price')) has-error @endif">
                                <label for="price" class="control-label">Price <span style="color: red">*</span></label>
                                <input type="number" name="price" id="price" value="{{old('price')}}" class="form-control input-sm" placeholder="Price ...*" min="0">
                                {!! $errors->first('price', '<em for="price" class="text-danger">:message</em>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jenis_keahlian_id')) has-error @endif">
                                <label class="control-label">Jenis Keahlian <span style="color: red">*</span></label>
                                <select name="jenis_keahlian_id[]" id="jenis_keahlian_id" class="form-control input-sm select_2" style="width: 100%;" data-placeholder="Jenis Keahlian..*" multiple>
                                </select>
                                {!! $errors->first('jenis_keahlian_id', '<p for="jenis_keahlian_id" class="text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('kjpp_id')) has-error @endif">
                                <label class="control-label">KJPP <span style="color: red">*</span></label>
                                <select name="kjpp_id" id="kjpp_id" class="form-control input-sm select_2" style="width: 100%;" data-placeholder="KJPP..*">
                                </select>
                                {!! $errors->first('kjpp_id', '<p for="kjpp_id" class="text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group @if($errors->has('photo')) has-error @endif">
                                <label for="photo" class="control-label">Photo (Max 10MB)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept=".jpg,.jpeg,.png" name="photo" id="photo"/>
                                    <label class="custom-file-label" for="photo" id="label_photo">Choose file</label>
                                </div>
                                {!! $errors->first('photo', '<em for="photo" class="text-danger">:message</em>') !!}
                            </div>

                            <div class="row" id="show_photo">
                                <div class="col-lg-3">
                                    <div class="card card-custom gutter-b">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 mr-7">
                                                    <div class="symbol symbol-50 symbol-lg-120">
                                                        <img id="preview_photo"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="photoRemove()">Remove</button>
                                        </div>
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
@endpush

@push('scripts')
    <script src="{{url('plugins/select2/js/select2.full.js')}}"></script>

    <script type="text/javascript">

        $(function () {
            $('#show_photo').hide();
            $('#userPenilaiPublik').hide();
        });

        $('#roleSelect').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('roles.ajax.select2')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * data.per_page) < data.total
                        }
                    };
                },
                cache: true,
            }
        });

        $('#jenis_keahlian_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            allowClear: true,
            multiple: true,
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('jenis_keahlian.ajax.select2')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * data.per_page) < data.total
                        }
                    };
                },
                cache: true,
            }
        });

        $('#city_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('city.ajax.select2')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * data.per_page) < data.total
                        }
                    };
                },
                cache: true,
            }
        });

        $('#kjpp_id').select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            containerCssClass: ':all:',
            ajax: {
                url: '{{route('kjpp.ajax.select2')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * data.per_page) < data.total
                        }
                    };
                },
                cache: true,
            }
        });

        $('#roleSelect').on("select2:select", function() {
            const select2Data = $(this).select2("data");
            console.log(select2Data);
            if(select2Data[0].slug == 'penilai-publik' || select2Data[0].slug == 'penilai-publik-admin'){
                $('#userPenilaiPublik').show();
                $('#address').prop('required',true);
                $('#city').prop('required',true);
                $('#no_mappi').prop('required',true);
                $('#no_izin_penilai_publik').prop('required',true);
                $('#no_izin_bpn').prop('required',true);
                $('#no_register_penilai').prop('required',true);
                $('#price').prop('required',true);
                $('#jenis_keahlian_id').prop('required',true);
                $('#kjpp_id').prop('required',true);
            }
            else{
                $('#userPenilaiPublik').hide();
                $('#address').removeAttr('required');
                $('#city').removeAttr('required');
                $('#no_mappi').removeAttr('required');
                $('#no_izin_penilai_publik').removeAttr('required');
                $('#no_izin_bpn').removeAttr('required');
                $('#no_register_penilai').removeAttr('required');
                $('#price').removeAttr('required');
                $('#jenis_keahlian_id').removeAttr('required');
                $('#kjpp_id').removeAttr('required');
            }
        });

        function photoRemove()
        {
            // $('#photo').attr("required", true);
            $('#old_photo').val("");
            $('#show_photo').hide();
            $('#label_photo').text("Choose file");
            $('#photo').val("");
        }

        function readURLPhoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#label_photo').text(input.files[0].name);
                    $('#show_photo').show();
                    $('#preview_photo').attr('src', e.target.result);
                    $('#old_photo').val("");
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function(){
            if(this.files[0].size > 10485760){
               alert("File is too big!");
               this.value = "";
            }
            else{
                readURLPhoto(this);
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

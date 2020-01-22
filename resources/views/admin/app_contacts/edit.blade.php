@extends('admin.layouts.master')

@section('title')
    تعديل  ارقام الاتصال
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
@endsection

@section('page_header')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('/admin/home')}}">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{route('Contacts')}}">أرقام الاتصال</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>تعديل  ارقام الاتصال</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">  أرقام الاتصال
        <small>تعديل  ارقام الاتصال</small>
    </h1>
@endsection

@section('content')



    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <form role="form" action="{{route('updateContact' , $contact->id)}}" method="post" enctype="multipart/form-data">
                                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                <div class="portlet-body">

                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
                                            <div class="form-group">
                                                <label class="control-label">الاسم</label>
                                                <input type="text" name="name" placeholder="الاسم" class="form-control" value="{{$contact->name}}" />
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class=" form-group">

                                                <label class="control-label">رقم الهاتف</label>

                                                <input type="text" name="phone" placeholder="رقم الهاتف" class="form-control" value="{{$contact->phone}}" />

                                                @if ($errors->has('phone_number'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-body">
                                                <div class="form-group ">
                                                    <label class="control-label col-md-3"> صوره الاتصال</label>
                                                    <div class="col-md-9">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                                @if ($contact->photo !== null)
                                                                    <img src="{{asset('/uploads/contacts_photos/'.$contact->photo)}}">
                                                                @endif
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اختر الصورة </span>
                                                                <span class="fileinput-exists"> تغيير </span>
                                                                <input type="file" name="photo"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> إزالة </a>



                                                            </div>
                                                        </div>
                                                        @if ($errors->has('image'))
                                                            <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('image') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- END PERSONAL INFO TAB -->


                                        <!-- PRIVACY SETTINGS TAB -->
                                        <div class="tab-pane" id="tab_1_4">

                                            <table class="table table-light table-hover">

                                                <tr>
                                                    <td> تفعيل الارقام الاتصال</td>
                                                    <td>
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="active" value="1" {{ old('active') == "1" ? 'checked' : '' }}/> نعم
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="active" value="0" {{ old('active') == "0" ? 'checked' : '' }}/> لا
                                                                <span></span>
                                                            </label>
                                                            @if ($errors->has('active'))
                                                                <span class="help-block">
                                                                       <strong style="color: red;">{{ $errors->first('active') }}</strong>
                                                                    </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>


                                            </table>


                                        </div>
                                        <!-- END PRIVACY SETTINGS TAB -->
                                    </div>

                                </div>
                                <div class="margiv-top-10">
                                    <div class="form-actions">
                                        <button type="submit" class="btn green" value="حفظ" onclick="this.disabled=true;this.value='تم الارسال, انتظر...';this.form.submit();">حفظ</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>
    <script>
        $(document).ready(function() {
            // for get regions
            $('select[name="city_id"]').on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/admin/get/regions/' + id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#choose_region').empty();
                            $('#places').empty();
                            $('#choose_city').empty();

                            $('select[name="c"]').append('<option value>اختر المنطقة</option>');
                            $.each(data['regions'], function (index, regions) {

                                $('select[name="region_id"]').append('<option value="' + regions.id + '">' + regions.name + '</option>');

                            });
                            $('select[name="places"]').append('<option value>اختر المنطقة</option>');
                            $.each(data['regions'], function (index, regions) {

                                $('select[name="places"]').append('<option value="' + regions.id + '">' + regions.name + '</option>');

                            });


                        }
                    });
                }else{
                    $('#choose_region').empty();
                    $('#places').empty();
                    $('#choose_city').empty();
                }
            });


            $( "body" ).on( "change", "input[type=radio][name=multi_place]", function() {
                // $( this ).after( "<p>Another paragraph! " + (++count) + "</p>" );

                all_payment_status = $(this).val();
                var id = $(this).val();
                if (id == "1") {

                    $('#multi_placce').show();



                }else{
                    $('#multi_placce').hide();


                }


            });
        });
    </script>
@endsection

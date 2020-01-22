@extends('admin.layouts.master')

@section('title')
    أسباب الرفض
@endsection

@section('page_header')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{url('/admin/home')}}">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('/admin/reasons')}}">أسباب الرفض</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>اضافة سبب رفض الطلب</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">أسباب الرفض
        <small>اضافة أسباب الرفض</small>
    </h1>
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">
            <!-- BEGIN TAB PORTLET-->
            <form method="post" action="{{url('/admin/add/reasons')}}" enctype="multipart/form-data">
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <!-- BEGIN CONTENT -->

                <!-- BEGIN CONTENT BODY -->
                <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light bordered table-responsive">
                        <div class="portlet-body form">
                            <div class="form-horizontal" role="form">

                                <div class="form-group">
                                    <label class="col-md-3 control-label">سبب الرفض</label>
                                    <div class="col-md-9">
                                        <input type="text" name="reason" class="form-control" placeholder="سبب الرفض" value="{{old('reason')}}">
                                        @if ($errors->has('reason'))
                                            <span class="help-block">
                                                           <strong style="color: red;">{{ $errors->first('reason') }}</strong>
                                                        </span>
                                        @endif
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->


                </div>


                <!-- END CONTENT BODY -->

                <!-- END CONTENT -->



                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green" value="حفظ" onclick="this.disabled=true;this.value='تم الارسال, انتظر...';this.form.submit();">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END TAB PORTLET-->





        </div>
    </div>

@endsection

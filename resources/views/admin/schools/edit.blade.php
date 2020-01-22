@extends('admin.layouts.master')

@section('title')
    اسم الجامعة
@endsection

@section('page_header')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/admin/home">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="/admin/age">اسم الجامعة</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>تعديل اسم الجامعة</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">اسم الجامعة
        <small>تعديل اسم الجامعة</small>
    </h1>
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">
            <!-- BEGIN TAB PORTLET-->
            <form method="post" action="/admin/update/school/{{$place->id}}" enctype="multipart/form-data">
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>








                            <!-- BEGIN CONTENT -->
                            <div class="page-content-wrapper">
                                <!-- BEGIN CONTENT BODY -->
                                <div class="row">
                                    <!-- BEGIN SAMPLE FORM PORTLET-->
                                    <div class="portlet light bordered table-responsive">
                                        <div class="portlet-body form">
                                            <div class="form-horizontal" role="form">

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">اسم الجامعة</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="name" class="form-control" placeholder="اسم الجامعة" value="{{$place->name}}">
                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('name') }}</strong>
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
                            </div>
                            <!-- END CONTENT -->



                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END TAB PORTLET-->





        </div>
    </div>

@endsection

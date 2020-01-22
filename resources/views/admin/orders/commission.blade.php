@extends('admin.layouts.master')

@section('title')
العمولة
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.bootstrap-rtl.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
@endsection

@section('page_header')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/admin/home">لوحة التحكم</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="/admin/order/offer">العمولة</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>عرض العمولة</span>
        </li>
    </ul>
</div>

<h1 class="page-title">عرض العمولة
    <small>عرض جميع العمولة</small>
</h1>
@endsection

@section('content')

@if (session('msg'))
<div class="alert alert-success">
    {{ session('msg') }}
</div>
@endif


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered table-responsive">

            <div class="portlet-body">

                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                    <tr>
                        <th>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                <span></span>
                            </label>
                        </th>

                        <th></th>
                        <th> اسم السواق </th>
                        <th> سعر السواق </th>
                        <th> حالة العمولة </th>
                        <th> صورة العمولة </th>
                        <th> تاريخ انتهاء دفع العمولة </th>
                        <th> خيارات </th>



                    </tr>
                    </thead>
                    <tbody>

                    <?php $i=0 ?>
                    @foreach($offers as $offer)

                        <tr class="odd gradeX">
                            <td>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="checkboxes" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td><?php echo ++$i ?></td>
                            <td> {{\App\User::find($offer->sawaq_user_id) == null ? null : \App\User::find($offer->sawaq_user_id)->name}} </td>
                            <td>{{$offer->price}}</td>


                            <td>
                                @if($offer->commission_status !==1)
                                   لم يتم الدفع بعد
                                @else

                                   تم دفع العمولة
                                @endif
                            </td>
                            <td>
                                @if($offer->commission !== null)
                                    <img   src='{{ asset("uploads/users/$offer->commission") }}' style="height: 50px; width: 50px;" alt="{{$offer->commission}}">
                                @endif
                            </td>
                            <td>{{$offer->end_date}}</td>
                            <td>
                                <a href="/admin/edit/commission/{{$offer->id}}" class="btn btn-sm blue">
                                    <i class="icon-docs"></i> تغيير حالة العمولة</a>
                            </td>









                        </tr>

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

@endsection


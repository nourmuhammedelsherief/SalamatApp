@extends('admin.layouts.master')

@section('title')
    طلبات طالب
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
                <a href="/admin/order/student">طلبات طالب</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>عرض طلبات طالب</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">عرض طلبات طالب
        <small>عرض جميع طلبات طالب</small>
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
                            <th> اسم صاحب الطلب </th>
                            <th> الحالة </th>
                            <th> العرض </th>

                            <th>  من مدينة </th>
                            <th>  من حي </th>
                            <th>  نوع التوصيل </th>
                            <th>  موعد الذهاب </th>
                            <th>  موعد العودة </th>
                            <th>  الي جامعة </th>
                            <th>  تاريخ البداية  </th>
                            <th>  تاريخ النهاية </th>



                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach($places as $data)

                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1" />
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo ++$i ?></td>
                                    <td> {{\App\User::find($data->user_id)->name}} </td>
                                    <td>
                                        @if($data->status ==1)
                                            طلب جديد
                                        @elseif($data->status == 2)
                                            طلب ساري
                                        @elseif($data->status == 3)
                                            طلب منتهي
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/admin/show/offer/{{$data->id}}" class="btn btn-sm blue">
                                            <i class="icon-eye"></i> عرض</a>
                                    </td>
                                    <td> {{\App\City::find($data->from_city_id)->name}} </td>
                                    <td> {{\App\City::find($data->from_region_id)->name}} </td>
                                    <td>
                                    @if($data->deliver_time == 1)
                                        اسبوعي
                                        @else
                                        شهري
                                        @endif
                                    </td>
                                    <td>{{$data->from_time}}</td>
                                    <td>{{$data->to_time}}</td>
                                    <td>{{\App\School::find($data->to_school)->name}}</td>


                                    <td>{{$data->start_date}}</td>
                                    <td>{{$data->end_date}}</td>








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

@section('scripts')
    <script src="{{ URL::asset('admin/js/datatable.js') }}"></script>
    <script src="{{ URL::asset('admin/js/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/datatables.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('admin/js/table-datatables-managed.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_city', function() {
                var id = $(this).attr('data');

                var swal_text = 'حذف ' + $(this).attr('data_name') + '؟';
                var swal_title = 'هل أنت متأكد من الحذف ؟';

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "تأكيد",
                    cancelButtonText: "إغلاق",
                    closeOnConfirm: false
                }, function() {

                    window.location.href = "{{ url('/') }}" + "/admin/delete/"+id+"/region";


                });

            });

        });
    </script>



@endsection
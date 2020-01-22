@extends('admin.layouts.master')

@section('title')
    موديل السنة
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
@endsection

@section('pmodelCity_header')
    <div class="pmodelCity-bar">
        <ul class="pmodelCity-breadcrumb">
            <li>
                <a href="/admin/home">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="/admin/modelCity">موديل السنة</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>عرض موديل السنة</span>
            </li>
        </ul>
    </div>

    <h1 class="pmodelCity-title">عرض موديل السنة
        <small>عرض موديل السنة</small>
    </h1>
@endsection

@section('content')

    @if (session('msg'))
        <div class="alert alert-danger">
            {{ session('msg') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered table-responsive">

                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="/admin/add/modelCity">
                                        <button id="sample_editable_1_new" class="btn sbold green"> جديد
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" >
                        <thead>
                        <tr>
                            <th>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                    <span></span>
                                </label>
                            </th>
                            <th></th>
                            <th> موديل السنة</th>




                            <th> خيارات </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach($places as $place)
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td><?php echo ++$i ?></td>
                                <td> {{$place->year}} </td>

                                  <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> خيارات
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" role="menu">

                                            <li>
                                                <a href="/admin/edit/modelCity/{{$place->id}}">
                                                    <i class="icon-docs"></i> تعديل </a>
                                            </li>

                                            <li>
                                                <a class="delete_offer" data="{{$place->id}}" data_name="{{$place->year}}" >
                                                    <i class="fa fa-key"></i> مسح
                                                </a>
                                            </li>


                                        </ul>
                                    </div>

                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $places->render() !!}
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ URL::asset('admin/js/datatable.js') }}"></script>
    <script src="{{ URL::asset('admin/js/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/datatables.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('admin/js/table-datatables-manmodelCityd.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_offer', function() {
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

                    window.location.href = "{{ url('/') }}" + "/admin/delete/"+id+"/modelCity";


                });

            });

        });
    </script>



@endsection
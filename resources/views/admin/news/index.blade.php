@extends('admin.layouts.master')

@section('title')
    الاخبار
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
                <a href="{{url('/admin/home')}}">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{route('News')}}">الاخبار</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>عرض الاخبار</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">عرض الاخبار
        <small>عرض الاخبار</small>
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
                                    <a href="{{route('createNews')}}">
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
                            <th>  أسم المستخدم </th>
                            <th> صورة المستخدم </th>
                            <th> العنوان </th>
                            <th> صورة الخبر </th>
                            <th> متحوي الخبر </th>
                            <th> خيارات </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach($news as $new)
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td><?php echo ++$i ?></td>
                                <td> {{$new->user_name}} </td>
                                <td>
                                    <img src="{{asset('/uploads/users/'.$new->user_photo)}}" height="80" width="100">
                                </td>
                                <td>
                                    {{$new->title}}
                                </td>
                                <td>
                                    <img src="{{asset('/uploads/news_photos/'.$new->news_photo)}}" height="80" width="100">
                                </td>
                                <td>
                                    <a> {{str_limit($new->content , 30)}} </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> خيارات
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" role="menu">

                                            <li>
                                                <a href="{{route('editNews' , $new->id)}}">
                                                    <i class="icon-docs"></i> تعديل </a>
                                            </li>

                                            <li>
                                                <a class="delete_offer" data="{{$new->id}}" data_name="{{$new->title}}" >
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
                {!! $news->render() !!}
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

                    window.location.href = "{{ url('/') }}" + "/admin/news/delete/"+id;


                });

            });

        });
    </script>



@endsection

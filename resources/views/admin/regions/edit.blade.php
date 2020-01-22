@extends('admin.layouts.master')

@section('title')
    تعديل جميع الاحياء
@endsection

@section('styles')
    <style>
        #map_canvas {
            width: 980px;
            height: 500px;
        }
        #current {
            padding-top: 25px;
        }
    </style>
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
@endsection

@section('page_header')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/admin/home">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="/admin/region">المناطق</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>عرض المناطق</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">عرض المناطق
        <small>تعديل جميع المناطق</small>
    </h1>
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">
            <!-- BEGIN TAB PORTLET-->
            <form method="post" action="/admin/update/region/{{$city->id}}" enctype="multipart/form-data">
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
                                            <label for="gender" class="col-md-3 control-label">اختر الدولة</label>
                                            <div class="col-lg-9">
                                                <div class=" input-group select2-bootstrap-append">
                                                    <select id="gender" name="country" class="form-control select2-allow-clear">
                                                        @foreach($countries as $country)
                                                            @if($country->parent_id == null)
                                                                <option value="{{$country->id}}" {{ $city->parent_id ==$country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                                            @endif
                                                        @endforeach

                                                    </select>
                                                    @if ($errors->has('country'))
                                                        <span class="help-block">
                                           <strong style="color: red;">{{ $errors->first('country') }}</strong>
                                        </span>
                                                    @endif
                                                    <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">الاسم</label>
                                            <div class="col-md-9">
                                                <input type="text" name="name" class="form-control" placeholder="الاسم" value="{{$city->name}}">
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group" id="sub_map">

                                            <label class="col-md-3 control-label">الخريطة</label>
                                            <div class="col-md-9">
                                                {{--<div id="googleMap" style="width:100%;height:380px;"dir="ltr"></div>--}}
                                                <pre> <div id='map_canvas'></div>
                                                            <div id="current">Nothing yet...</div></pre>

                                                <input  type="hidden" name="longitude" id="longitude" value="{{$city->longitude}}">
                                                <input  type="hidden" name="latitude" id="latitude" value="{{$city->latitude}}"  >
                                                @if ($errors->has('latitude'))
                                                    <span class="help-block">
                                                                 <strong style="color: red;">{{ $errors->first('latitude') }}</strong>
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
@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>
    <script>
        function loadScript(src,callback){

            var script = document.createElement("script");
            script.type = "text/javascript";
            if(callback)script.onload=callback;
            document.getElementsByTagName("head")[0].appendChild(script);
            script.src = src;
        }


        loadScript('http://maps.googleapis.com/maps/api/js?key=AIzaSyA9UeezZ2xyNjrwck8SLdh9NxsJp6HhLQc&callback=initialize',
            function(){
                // log('google-loader has been loaded, but not the maps-API ');
            });


        function initialize() {

            // log('maps-API has been loaded, ready to use');
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 5,
                center: new google.maps.LatLng(23.8859425,45.0791626),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            if (document.getElementById("latitude").value !== ""){
                var myMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(document.getElementById("latitude").value ,document.getElementById("longitude").value),
                    draggable: true
                });

            }else{
                var myMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(23.8859425,45.0791626),
                    draggable: true
                });
            }

            google.maps.event.addListener(myMarker, 'dragend', function (evt) {
                document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat()+ ' Current Lng: ' + evt.latLng.lng() + '</p>';
                document.getElementById("latitude").value =evt.latLng.lat();
                document.getElementById("longitude").value =evt.latLng.lng();

            });

            google.maps.event.addListener(myMarker, 'dragstart', function (evt) {
                document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
            });

            map.setCenter(myMarker.position);
            myMarker.setMap(map);
        }

        function log(str){
            document.getElementsByTagName('pre')[0].appendChild(document.createTextNode('['+new Date().getTime()+']\n'+str+'\n\n'));
        }
    </script>
@endsection
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item start active open" >
                <a href="/admin/home" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">الرئيسية</span>
                    <span class="selected"></span>

                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">القائمة الجانبية</h3>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'admins') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">المشرفين</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="{{ url('/admin/admins') }}" class="nav-link ">
                            <span class="title">عرض المشرفين</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/admins/create') }}" class="nav-link ">
                            <span class="title">اضافة مشرف</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/user') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">المستخدمين</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="{{ url('/admin/user/1') }}" class="nav-link ">
                            <span class="title">مستخدمين ( سائق)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/user/2') }}" class="nav-link ">
                            <span class="title">مستخدمين (عادي)</span>
                        </a>
                    </li>

                </ul>
            </li>


            <li class="nav-item {{ strpos(URL::current(), 'admin/nationality') !== false ? 'active' : '' }}">
                <a href="/admin/nationality" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">الجنسية</span>
                    <span class="pull-right-container">
            </span>

                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/car_type') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/car_type')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">أنواع الساطحات</span>
                    <span class="pull-right-container">
            </span>

                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/reasons') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/reasons')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">أسباب رفض الطلب</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/CancelOrder') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/CancelOrder')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  الطلبات الملغيه </span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/commission') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/commission')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">العمولة</span>

                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/reports') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/reports')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title"> الابلاغ عن السائقين</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/contacts') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/contacts')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title"> أرقام الاتصال </span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/call_center') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/call_center')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title"> خدمة العملاء </span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/news') !== false ? 'active' : '' }}">
                <a href="{{url('/admin/news')}}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title"> الاخبار </span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'admin/setting') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الاعدادات العامة</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="/admin/setting" class="nav-link ">
                            <span class="title">اعدادات الموقع</span>
                        </a>
                    </li>




                </ul>
            </li>


            <li class="nav-item {{ strpos(URL::current(), 'admin/pages') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الصفحات</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="/admin/pages/about" class="nav-link ">
                            <span class="title">من نحن</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="/admin/pages/terms" class="nav-link ">
                            <span class="title">الشروط والاحكام</span>
                        </a>
                    </li>




                </ul>
            </li>



        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>

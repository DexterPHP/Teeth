@extends('adminlte::page')

@section('title', '  عرض بطاقة المريض  ')

@section('content_header')

    <h1 class="text-center">  عرض بطاقة المريض    </h1>
@stop

@section('content')

    {{csrf_field()}}
    @if(isset($user))
<div class="row">
    <div class="col-md-12" style="direction: rtl;text-align: right;">
        <div id="user-profile-2" class="user-profile">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-18">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green ace-icon fa fa-user bigger-120"></i>
                        المعلومات العامة
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#feed">
                        <i class="orange ace-icon fa fa-rss bigger-120"></i>
                        الأمراض
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#friends">
                        <i class="blue ace-icon fa fa-users bigger-120"></i>
                        السجلات
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#pictures">
                        <i class="pink ace-icon fa fa-picture-o bigger-120"></i>
                        الصور
                    </a>
                </li>
            </ul>

            <div class="tab-content no-border padding-24">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 center">
							<span class="profile-picture">
								<img class="editable img-responsive" alt=" Avatar" id="avatar2" src="{{$user->user_image}}">
							</span>

                            <div class="space space-4"></div>

                            <a href="{{$user->user_image}}" download class="btn btn-sm btn-block btn-success">
                                <i class="ace-icon fa fa-download bigger-120"></i>
                                <span class="bigger-110">Download</span>
                            </a>


                        </div><!-- /.col -->

                        <div class="col-xs-12 col-sm-9">
                            <h4 class="blue">
                                <span class="middle">{{ $user->username }} {{$user->user_middel }} {{ $user->lastname }}</span>


                            </h4>

                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> الأسم </div>

                                    <div class="profile-info-value">
                                        <span>{{ $user->username }}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> اسم الأب </div>

                                    <div class="profile-info-value">

                                        <span>{{$user->user_middel }}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> الكنية </div>

                                    <div class="profile-info-value">
                                        <span>{{ $user->lastname }}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> تاريخ الميلاد </div>

                                    <div class="profile-info-value">
                                        <span>{{$user->birthday}}</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> العمر  </div>

                                    <div class="profile-info-value">
                                        <span>{{$user->user_age}}</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> الجنس  </div>

                                    <div class="profile-info-value">
                                        <span>{{$user->gender}}</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> تاريخ التسجيل   </div>

                                    <div class="profile-info-value"><i class="fa fa-map-marker light-orange bigger-110"></i>
                                        <span>	{{$user->created_at}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> آخر زيارة </div>

                                    <div class="profile-info-value">
                                        <span>3 hours ago</span>
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-8 dotted"></div>


                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="space-20"></div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-small">
                                    <h4 class="widget-title smaller">
                                        <i class="ace-icon fa fa-check-square-o bigger-110"></i>
                                        معلومات
                                    </h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <p>
                                            {{$user->notes}}
                                        </p>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /#home -->

                <div id="feed" class="tab-pane">
                    <div class="profile-feed row">
                        <div class="col-sm-6">
                            <div class="profile-activity clearfix">
                                <div>
                                    <p>هل يعاني من مرض السكري:
                                        @if($user->shoug == true) نعم @else لا @endif
                                    </p>
                                    <p>هل يعاني من أمراض الضغط:
                                        @if($user->depress == true) نعم @else لا @endif</p>
                                    <p>هل يدخن:
                                        @if($user->smoking == true) نعم @else لا @endif
                                    </p>
                                    <p>رقم البطاقة الخاصة: {{$user->card_number}}</p>
                                </div>

                            </div>

                        </div><!-- /.col -->


                    </div><!-- /.row -->
                </div><!-- /#feed -->
<!--
                <div id="friends" class="tab-pane">
                    <div class="profile-users clearfix">
                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar6.png" alt="Bob Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-online"></span>
                                            Bob Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">Content Editor</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 orange"></i>
                                            <span class="green"> 20 mins ago </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="Rose Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-offline"></span>
                                            Rose Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">Graphic Designer</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 grey"></i>
                                            <span class="grey"> 30 min ago </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar2.png" alt="Jim Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-busy"></span>
                                            Jim Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">SEO &amp; Advertising</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 red"></i>
                                            <span class="grey"> 1 hour ago </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar3.png" alt="Alex Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-idle"></span>
                                            Alex Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">Marketing</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 orange"></i>
                                            <span class=""> 40 minutes idle </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar4.png" alt="Phil Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-online"></span>
                                            Phil Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">Public Relations</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 orange"></i>
                                            <span class="green"> 2 hours ago </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar6.png" alt="Susan Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-online"></span>
                                            Susan Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">HR Management</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 orange"></i>
                                            <span class="green"> 20 mins ago </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="Jennifer Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-offline"></span>
                                            Jennifer Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">Graphic Designer</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 grey"></i>
                                            <span class="grey"> 2 hours ago </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="itemdiv memberdiv">
                            <div class="inline pos-rel">
                                <div class="user">
                                    <a href="#">
                                        <img src="http://bootdey.com/img/Content/avatar/avatar2.png" alt="Alexa Doe's avatar">
                                    </a>
                                </div>

                                <div class="body">
                                    <div class="name">
                                        <a href="#">
                                            <span class="user-status status-offline"></span>
                                            Alexa Doe
                                        </a>
                                    </div>
                                </div>

                                <div class="popover">
                                    <div class="arrow"></div>

                                    <div class="popover-content">
                                        <div class="bolder">Accounting</div>

                                        <div class="time">
                                            <i class="ace-icon fa fa-clock-o middle bigger-120 grey"></i>
                                            <span class="grey"> 4 hours ago </span>
                                        </div>

                                        <div class="hr dotted hr-8"></div>

                                        <div class="tools action-buttons">
                                            <a href="#">
                                                <i class="ace-icon fa fa-facebook-square blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-google-plus-square red bigger-150"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr hr10 hr-double"></div>

                    <ul class="pager pull-right">
                        <li class="previous disabled">
                            <a href="#">← Prev</a>
                        </li>

                        <li class="next">
                            <a href="#">Next →</a>
                        </li>
                    </ul>
                </div>
-->
                <div id="pictures" class="tab-pane">
                    <ul class="ace-thumbnails">
                        <li>
                            <a href="#" data-rel="colorbox">
                                <img alt="150x150" src="http://lorempixel.com/200/200/nature/1/">
                                <div class="text">
                                    <div class="inner">Sample Caption on Hover</div>
                                </div>
                            </a>

                            <div class="tools tools-bottom">
                                <a href="#">
                                    <i class="ace-icon fa fa-link"></i>
                                </a>

                                <a href="#">
                                    <i class="ace-icon fa fa-paperclip"></i>
                                </a>

                                <a href="#">
                                    <i class="ace-icon fa fa-pencil"></i>
                                </a>

                                <a href="#">
                                    <i class="ace-icon fa fa-times red"></i>
                                </a>
                            </div>
                        </li>

                    </ul>
                </div><!-- /#pictures -->
            </div>
        </div>
    </div>
    </div>
</div>
<!-- Hello -->

    @endif

@stop

@section('js')

    <script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" ></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" ></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@stop
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/profile.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />
@stop


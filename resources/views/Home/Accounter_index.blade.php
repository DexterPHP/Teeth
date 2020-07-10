@extends('adminlte::page')

@section('title', 'برنامج أدارة عيادات الأسنان')

@section('content_header')
    <h1>{{Auth::user()->name}}</h1>
@stop

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- First Row -->
            <div class="row">
                @if(isset($center))
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success text-center">
                                <div class="inner">
                                    <h3> {{$center->moneybox}} </h3>
                                    <p>{{$center->center_name}}</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a class="small-box-footer">في صندوق المركز </a>
                            </div>
                        </div>
                        <!-- ./col -->
                @endif
                @if(isset($doctors))
                    @foreach($doctors as $doctor)
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info text-center">
                                <div class="inner">
                                    <h3> {{$doctor->moneybox}} </h3>

                                    <p>{{$doctor->doctor_fname}}</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a class="small-box-footer">في صندوق الطبيب </a>
                            </div>
                        </div>
                        <!-- ./col -->
                    @endforeach
                @endif
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger text-center">
                        <div class="inner">
                            <h3>{{ $Patiens }}</h3>

                            <p>مريض</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a class="small-box-footer">في المركز</a>
                    </div>
                </div>
                <!-- ./col -->
                {{--<div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- End First Row -->--}}
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@stop

@section('css')

@stop

@section('js')
    <script type="text/javascript" src="{{asset("js/dashboard3 .js")}}" ></script>
@stop

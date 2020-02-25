@extends('adminlte::page')

@section('title', 'برنامج أدارة عيادات الأسنان')

@section('content_header')
    <h1>{{Auth::user()->name}}</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')

@stop

@section('js')

@stop

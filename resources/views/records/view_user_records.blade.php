@extends('adminlte::page')

@section('title', 'عرض سجلات مريض')

@section('content_header')
    <h1 class="text-center">عرض سجلات المريض: {{ $user->username }} {{ $user->user_middel }} {{ $user->lastname }}</h1>
@stop

@section('content')


    @if(isset($datas))
        <a href="../../records/add/{{$user_id}}" class="float-right""><button class="btn btn-danger">  إضافة سجل لهذا المريض</button></a>
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>الباقي</th>
                <th>دفعة</th>
                <th>المبلغ المطلوب</th>
                <th> تاريخ الادخال</th>
                <th>اسم العمل</th>
                <th>السن</th>
                <th>تاريخ السجل</th>
                <th>اسم الطبيب المشرف </th>
                <th>رقم المريض الخاص</th>
            </tr>
            </thead>
            <tbody>
            <?php $count=$paid=$require=0; ?>
            @foreach($datas as $record)
                <tr>
                    <td class="text-danger">{{  $all =  $record->set_total - $record->set_payment }}<?php $count = $count+$all; ?></td>
                    <td class="text-success">{{ $all2 = $record->set_payment }}<?php $paid = $paid+$all2; ?></td>
                    <td class="text-warning">{{ $all3 = $record->set_total }}<?php $require = $require+$all3; ?></td>
                    <td>{{ $record->record_time }}</td>
                    <td>{{ $record->working_teeth }}</td>
                    <td>{{ $record->teeth_work_name }}</td>
                    <td>{{ $record->created_at->format('d/m/Y') }}  {{ $record->created_at->format('H:i:s') }} </td>
                    <td>{{ (App\Models\Doctor::find($record->doctor_id))->doctor_fname }} </td>
                    <td>{{ $record->id }} </td>
                </tr>
            @endforeach


            </tbody>
            <tfoot>
            <tr>
                <th>الباقي</th>
                <th>دفعة</th>
                <th>المبلغ المطلوب</th>
                <th> تاريخ السجل</th>
                <th>اسم العمل</th>
                <th>السن</th>
                <th>تاريخ الإدخال</th>
                <th>اسم الطبيب المشرف </th>
                <th>رقم المريض الخاص</th>
            </tr>
            </tfoot>
        </table>

    @endif
<h3 class="text-warning text-center"> مجموع الدفعات : {{$paid}} ليرة سورية</h3>
<h3 class="text-success text-center"> مجموع المبالغ المطلوبة : {{$require}} ليرة سورية</h3>
    <hr />
    <h3 class="text-danger text-center"> المبلغ المطلوب : {{$count}} ليرة سورية</h3>


@stop

@section('js')
    <script src="{{asset('js/jquery-3.3.1.js')}}" ></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}" ></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}" ></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@stop

@section('css')
    <link href="{{asset('css/bootstrap.css')}}" />
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" />
@stop


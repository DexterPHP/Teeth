@extends('adminlte::page')

@section('title', 'تعديل سجل مريض')

@section('content_header')

    <h1 class="text-center">
        تعديل سجل مريض
،    الرجاء اختيار الطبيب أولاً
    </h1>
@stop

@section('content')


    @if(isset($All))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>عرض المرضى والسجلات </th>
                <th>رقم الهاتف</th>
                <th>اسم الطبيب كاملاً</th>
                <th>رقم مميز</th>
            </tr>
            </thead>
            <tbody>
            @foreach($All as $user)
                <tr>
                    <td><a href="doctor/{{ $user->uuid }}" title="عرض كافة لمرضى مع السجلات "><i class="fas fa-id-card"></i></a></td>
                    <td>{{ $user->doctor_mobile }}</td>
                    <td>{{ $user->doctor_fname }}</td>
                    <td>{{ $user->id }}</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>عرض المرضى والسجلات </th>
                <th>رقم الهاتف</th>
                <th>اسم الطبيب كاملاً</th>
                <th>رقم مميز</th>
            </tr>
            </tfoot>
        </table>

    @endif

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

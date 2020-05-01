@extends('adminlte::page')

@section('title', 'عرض الأطباء لأظهار الواعيد')

@section('content_header')
    <h1 class="text-center">قائمة الأطباء في المركز  </h1>
@stop

@section('content')


    @if(isset($doctors))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>عرض المواعيد</th>
                <th>هاتف الطبيب</th>
                <th>اسم الطبيب </th>
                <th>رقم الطبيب </th>
            </tr>
            </thead>
            <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td><a href="DatesList/{{ $doctor->uuid }}" title="بطاقة الطبيب" ><i class="fa fa-user-md" aria-hidden="true"></i></a> </td>
                    <td>{{ $doctor->doctor_mobile }} </td>
                    <td>{{ $doctor->doctor_fname }} </td>
                    <td>{{ $doctor->id }} </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>عرض المواعيد</th>
                <th>هاتف الطبيب</th>
                <th>اسم الطبيب </th>
                <th>رقم الطبيب </th>
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

@extends('adminlte::page')

@section('title', 'اختيار الطبيب لاضافة موعد')

@section('content_header')
    <h1 class="text-center">اختيار طبيب لاضافة موعد</h1>
@stop

@section('content')


    @if(isset($doctors))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th> اضافة موعد</th>
                <th>هاتف الطبيب</th>
                <th>اسم الطبيب </th>
                <th>رقم الطبيب </th>
            </tr>
            </thead>
            <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td><a href="choose/{{ $doctor->uuid }}" title="اضافة موعد" ><i class="fa fa-user-md" aria-hidden="true"></i></a></td>
                    <td>{{ $doctor->doctor_mobile }} </td>
                    <td>{{ $doctor->doctor_fname }} </td>
                    <td>{{ $doctor->id }} </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th> اضافة موعد</th>
                <th>هاتف الطبيب</th>
                <th>اسم الطبيب </th>
                <th>رقم الطبيب </th>
            </tfoot>
        </table>

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
     <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />
@stop

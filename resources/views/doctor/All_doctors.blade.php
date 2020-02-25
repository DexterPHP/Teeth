@extends('adminlte::page')

@section('title', '  البحث عن طبيب')

@section('content_header')

    <h1 class="text-center">  البحث عن طبيب  </h1>
@stop

@section('content')


    @if(isset($doctors))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th> بطاقة الطبيب</th>
                <th>  الاختصاص</th>
                <th> رقم الهاتف</th>
                <th> اسم المستخدم</th>
                <th>اسم الطبيب </th>
                <th>رقم الطبيب </th>
            </tr>
            </thead>
            <tbody>
            @foreach($doctors as $doctor)
                <tr>


                    <td><a href="card/{{ $doctor->uuid }}" title="بطاقة الطبيب" ><i class="fa fa-user-md" aria-hidden="true"></i></a></td>
                    <td>{{ $doctor->doctor_spicalest }} </td>
                    <td>{{ $doctor->doctor_mobile }} </td>
                    <td>{{ $doctor->doctor_username }} </td>
                    <td>{{ $doctor->doctor_fname }} </td>
                    <td>{{ $doctor->id }} </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th> بطاقة الطبيب</th>
                <th>  الاختصاص</th>
                <th> رقم الهاتف</th>
                <th> اسم المستخدم</th>
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
@section('js')
    <script> console.log('Hi!'); </script>
@stop

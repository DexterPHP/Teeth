@extends('adminlte::page')

@section('title', '  تعديل  محاسب')

@section('content_header')

    <h1 class="text-center">  تعديل  محاسب  </h1>
@stop

@section('content')
    @if(isset($Account_data))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th> تعديل </th>
                <th> اسم المركز</th>
                <th> اسم الهاتف</th>
                <th>اسم المحاسب </th>
                <th>رقم المحاسب </th>
            </tr>
            </thead>
            <tbody>

            @foreach($Account_data as $accounter)

                <tr>
                    <td><a href="update/{{$accounter->uuid}}" ><i class="fa fa-user-edit"></i></a></td>
                    {{--<td>{{ $centes[$accounter->center_id]->center_name }} </td>--}}
                    <td>{{ $accounter->center_id }} </td>
                    <td>{{ $accounter->accounter_phone }} </td>
                    <td>{{ $accounter->accounter_fname }} </td>
                    <td>{{ $accounter->id }} </td>
                </tr>
            @endforeach


            </tbody>
            <tfoot>
            <tr>
                <th> تعديل </th>
                <th> اسم المركز</th>
                <th> اسم الهاتف</th>
                <th>اسم المحاسب </th>
                <th>رقم المحاسب </th>
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

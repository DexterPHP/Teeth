@extends('adminlte::page')

@section('title', '  البحث عن مخبر')

@section('content_header')

    <h1 class="text-center">  البحث عن مخبر  </h1>
@stop

@section('content')


    @if(isset($data))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>  العنوان</th>
                <th> رقم الهاتف</th>
                <th>  اختصاص  المخبر</th>
                <th>اسم المخبر </th>
                <th>رقم المخبر </th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $labs)
                <tr>
                    <td>{{ $labs->lab_location }} </td>
                    <td>{{ $labs->lab_phone }} </td>
                    <td>{{ $labs->lab_spi }} </td>
                    <td>{{ $labs->lab_name }} </td>
                    <td>{{ $labs->id }} </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>  العنوان</th>
                <th> رقم الهاتف</th>
                <th>  اختصاص  المخبر</th>
                <th>اسم المخبر </th>
                <th>رقم المخبر </th>
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

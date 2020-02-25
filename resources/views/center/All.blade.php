@extends('adminlte::page')

@section('title', ' تعديل معلومات مركز')

@section('content_header')

    <h1 class="text-center">  تعديل  معلومات مركز  </h1>
@stop

@section('content')

    {{csrf_field()}}
    @if(isset($data))
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>معلومات شاملة</th>
                <th>عدد الأطباء في المركز</th>
                <th>   محاسب المركز</th>
                <th>الأسم</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $user)
                <tr>
                    <td>
                        <a href="edit/{{$user->uuid}}" title="عرض معلومات المريض كافة"><i class="fas fa-user-injured"></i></a>
                    </td>
                    <td>قريباً</td>
                    <td>قريباً</td>
                    <td>{{ $user->center_name }}</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>معلومات شاملة</th>
                <th>عدد الأطباء في المركز</th>
                <th>   محاسب المركز</th>
                <th>الأسم</th>
            </tr>
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

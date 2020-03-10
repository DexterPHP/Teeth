@extends('adminlte::page')

@section('title', 'محاسبة |  سحب من صندوق طبيب')
@if(isset($center) and isset($DoctordsData))
@section('content_header')
    <h1 class="text-center">  سحب من صندوق طبيب</h1>
    <h3 class="text-center">قائمة الأطباء في مركز
        <b class="text-success">{{$center->center_name}}</b>
    </h3>
@stop

@section('content')
        <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
            <thead>
            <tr>
                <th>سحب</th>
                <th>القيمة   </th>
                <th>نوع الاشتراك  </th>
                <th>الأختصاص  </th>
                <th>الطبيب  </th>
            </tr>
            </thead>
            <tbody>
            @if(isset($admin))
                @foreach($DoctordsData as $center)
                    <tr>
                        <th><a href="pull/{{ $center->uuid }}" title="سحب"><i class="fas fa-id-card"></i></a></th>
                        <th>{{$center->Type == 'Percent'  ? $center->cash_percent.' %' : $center->cash_percent.' SP' }}</th>
                        <th>{{$center->Type == 'Percent'  ? 'نسبة مئوية' : 'نقدي' }}</th>
                        <th>{{ $center->doctor_spicalest }}</th>
                        <td>{{ $center->doctor_fname }}</td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <th><a href="pull/{{ $DoctordsData->uuid }}" title="سحب"><i class="fas fa-id-card"></i></a></th>
                    <th>{{$DoctordsData->Type == 'Percent'  ? $DoctordsData->cash_percent.' %' : $DoctordsData->cash_percent.' SP' }}</th>
                    <th>{{$DoctordsData->Type == 'Percent'  ? 'نسبة مئوية' : 'نقدي' }}</th>
                    <th>{{ $DoctordsData->doctor_spicalest }}</th>
                    <td>{{ $DoctordsData->doctor_fname }}</td>
                </tr>
             @endif

            </tbody>
            <tfoot>
            <tr>
                <th>سحب</th>
                <th>القيمة   </th>
                <th>نوع الاشتراك  </th>
                <th>الأختصاص  </th>
                <th>الطبيب  </th>
            </tr>
            </tfoot>
        </table>



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
@endif

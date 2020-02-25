@extends('adminlte::page')

@section('title', 'إعرض مواعيد طبيب')



@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-body p-0">
                        <!-- THE CALENDAR -->
                        <div id="calendar" ></div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="card-title text-right">دلالات الألوان</h4>
                    </div>
                    <div class="card-body text-right">
                        <!-- the events -->
                        <div id="external-events">
                            <div class="external-event bg-success ui-draggable ui-draggable-handle" style="position: relative;">جديدة</div>
                            <div class="external-event bg-warning ui-draggable ui-draggable-handle" style="position: relative;">مراجعة</div>
                            <div class="external-event bg-primary ui-draggable ui-draggable-handle" style="position: relative;">زيارة مريض</div>
                            <div class="external-event bg-danger ui-draggable ui-draggable-handle" style="position: relative;">مستعجلة</div>

                        </div>
                        <br/>
                        <a  href="/dates/choose/{{$doctor}}" title=""> <button type="button" class="btn btn-block btn-outline-secondary btn-flat">أضافة موعد جديد</button></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /. box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@section('content_header')

    <h1 class="text-center">عرض مواعيد طبيب  </h1>
@stop

@stop
@section('js')
    <link href='{{asset('fullcalender/packages/list/main.css')}}' rel='stylesheet' />
    <script src='{{asset('fullcalender/packages/core/main.js')}}'></script>
    <script src='{{asset('fullcalender/packages/interaction/main.js')}}'></script>
    <script src='{{asset('fullcalender/packages/daygrid/main.js')}}'></script>
    <script src='{{asset('fullcalender/packages/timegrid/main.js')}}'></script>
    <script src='{{asset('fullcalender/packages/core/locales/ar.js')}}'></script>
    <script src='{{asset('fullcalender/packages/list/main.js')}}'></script>
    <!--<script src='{{asset('js/fullcalender.js')}}'></script>-->
    <script type="text/javascript">
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()
        document.addEventListener('DOMContentLoaded', function() {
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendarInteraction.Draggable

            /* initialize the external events
            -----------------------------------------------------------------*/

            var containerEl = document.getElementById('external-events');
            new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText.trim()
                    }
                }
            });
            /* initialize the calendar
            -----------------------------------------------------------------*/

            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                locale: 'ar',
                dir: 'rtl',
                navLinks: true,
                eventLimit: true,
                eventResize:false,
                selectable:true,
                editable:false,
                views: {
                    dayGridMonth: { // name of view
                        titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
                        // other view-specific options here
                    }
                },
                plugins: ['listPlugin', 'list','interaction', 'dayGrid', 'timeGrid'],
                defaultView: 'timeGridDay',
                header: {
                    left: 'next,prev, today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: [
                    @foreach($datar as $dates)
                  {
                        title          : '{{$dates->title}} {{isset($dates->patients_id) ? $dates->patients_id : ''}}',
                        start          : new Date({{ date("Y", strtotime($dates->what_date))}}, {{date("n", strtotime($dates->what_date))-1 }}, {{date("d", strtotime($dates->what_date))}}, {{date("H", strtotime($dates->start_time))}},{{date("i", strtotime($dates->start_time))}}),
                        end            : new Date({{ date("Y", strtotime($dates->what_date))}}, {{date("n", strtotime($dates->what_date))-1 }}, {{date("d", strtotime($dates->what_date))}}, {{date("H", strtotime($dates->left_time))}},{{date("i", strtotime($dates->left_time))}}),
                        allDay         : false,
                        backgroundColor: '{{$dates->priority}}', //Info (aqua)
                        borderColor    : '{{$dates->priority}}', //Info (aqua)
                        url: '/dates/view/{{$dates->uuid}}'
                  },
                    @endforeach

                ],
                editable: false,
                droppable: false, // this allows things to be dropped onto the calendar

            });
            calendar.render();

        });







    </script>
@endsection
@section('css')
    <link href='{{asset('fullcalender/packages/core/main.css')}}' rel='stylesheet' />
    <link href='{{asset('fullcalender/packages/daygrid/main.css')}}' rel='stylesheet' />
    <link href='{{asset('fullcalender/packages/timegrid/main.css')}}' rel='stylesheet' />
@endsection


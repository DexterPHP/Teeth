@extends('adminlte::page')

@section('title', '  البحث عن مريض')

@section('content_header')

    <h1 class="text-center">  البحث عن مريض  </h1>
@stop

@section('content')

   {{csrf_field()}}
 @if(isset($usersm))
     <table id="example" class="table table-striped table-bordered display text-center" style="width:100%">
         <thead>
         <tr>
             <th>معلومات شاملة</th>
             <th>تاريخ التسجيل</th>
             <th>ملاحظات</th>
             <th>رقم الهاتف</th>
             <th>العمر والمواليد</th>
             <th>الأسم</th>
             <th>رقم البطاقة</th>
         </tr>
         </thead>
         <tbody>
         @foreach($usersm as $user)
             <tr>

                 <td>

                      @if (isset($viewcard) and $viewcard==true)        <a href="view/{{$user->uuid}}" title="عرض بطاقة المريض "><i class="fas fa-user-injured"></i></a>  @endif
                      @if (isset($viewrecord) and $viewrecord==true)  - <a href="../records/view/{{$user->uuid}}" title="عرض  سجلات المريض"><i class="fas fa-id-card"></i></a>  @endif
                      @if (isset($deleteuser) and $deleteuser==true)  - <a href="#" class="deleteNow" data-username="{{ $user->username }}" data-uid="{{ $user->uuid }}"> <i class="fas fa-trash"></i></a> @endif

                 </td>
                 <td>{{ $user->created_at->format('Y/m/d') }}</td>
                 <td>{{ $user->notes }}</td>
                 <td>{{ $user->user_mobile }}</td>
                 <td>{{ $user->user_age }}  - {{$user->birthday }}</td>
                 <td>{{ $user->username }} {{$user->user_middel }} {{ $user->lastname }}</td>
                 <td> @if(strlen($user->card_number)>0) {{$user->card_number}} @else  لا يوجد  @endif</td>

             </tr>
         @endforeach

         </tbody>
         <tfoot>
         <tr>
             <th>معلومات شاملة</th>
             <th>تاريخ التسجيل</th>
             <th>ملاحظات</th>
             <th>رقم الهاتف</th>
             <th>العمر والمواليد</th>
             <th>الأسم</th>
             <th>رقم البطاقة</th>
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
        $(function() {

            $('.deleteNow').on('click',function(){
                console.log('hug');
                var User = $(this).data('username');
                var Uuid = $(this).data('uid');
                Swal.fire({
                    title: '  هل انت واثق من حذف المريض  '+User,
                    text: "تحذير !! بعد الحذف لن تتمكن من استرجاع البيانات",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'متأكد، قم بالحذف'
                }).then((result) => {
                    if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: "{{url('/user/delete/')}}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id": Uuid
                                },
                                success: function (data) {
                                    console.log(data);
                                   if(data == 1){
                                       Swal.fire(
                                           ' أكتمل الحذف',
                                           'إن عملية الحذف قد تمت  الرجاء الإنتظار',
                                           'موافق'
                                       )
                                       setTimeout(function(){ location.reload(); }, 1500);
                                   }else{
                                       Swal.fire({
                                           icon: 'error',
                                           title: 'لأسف',
                                           text: 'هاك خطأ حدث ولم نتمكن م حذف هذا المريض ',
                                           footer: '<a href>في حال معاودة المشكلة الرجاء التواصل مع المبرمج</a>'
                                       })
                                   }
                                }
                            });
                }

            });
                return false;
            });
            $('#example').DataTable();
        });


    </script>
@stop
@section('css')
    <link href="{{asset('css/bootstrap.css')}}" />
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" />
@stop



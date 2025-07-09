@extends('configuration.layout')

@section('contentbody')

<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> রেজিস্ট্রেশন সময়নিরুপণ হালনাগাদ</span>
        <a href="{{ route('registration_permission_times.index') }}" class="btn btn-secondary">
            আগের পৃষ্ঠা
        </a>
    </div>

    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
        <strong>দুঃখিত!</strong> আপনার হালনাগাদ করতে কোনো সমস্যা হয়েছে|<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('registration_permission_times.update',$registration_permission_time->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
         <div class="row">
             <table>
                 <tbody>
                         <tr>
                             <td >সময় শুরু<span style="color: red;"> * </span> </td>
                             <td><strong>:</strong></td>
                             <td class="input-append date" name="perm_start_time" id="perm_start_time">
                                <input class="form-control" data-format="yyyy/MM/dd hh:mm:ss" 
                                name="perm_start_time" type="text" id="perm_start_time" 
                                value="{{$registration_permission_time->perm_start_time}}" />
                                 <span class="add-on">
                                     <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                   </span>
                             </td>
                         </tr>
                         <tr>
                             <td>শেষ সময় <span style="color: red;"> * </span></td>
                             <td><strong>:</strong></td>
                               <td class="input-append date" name="period_end_time" id="period_end_time">
                                  <input class="form-control" data-format="yyyy/MM/dd hh:mm:ss" 
                                  name="period_end_time" type="text" id="perm_start_time" 
                                  value="{{$registration_permission_time->period_end_time}}"/>
                                    <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                  </span>
                            </td>
                         </tr>
                                                      
                         </tbody>
                 </table>

                 
              </div> 
              <div class="col-xs-12 col-sm-6 col-md-6 text-center">
               <button type="submit" class="btn btn-primary">জমা দিন</button>
         </div>
       </div>
   
     </form>
    </div>
</div>   
   
   
@endsection









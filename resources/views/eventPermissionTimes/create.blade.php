@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> নতুন ইভেন্ট পারমিশন সময়নিরুপণ যুক্ত করুন</span>
        <a href="{{ route('eventPermissionTimes.index') }}" class="btn btn-secondary">
            আগের পৃষ্ঠা
        </a>
    </div>

    <div class="card-body">
        @if ($errors->any())
    <div class="alert alert-danger">
    <strong>দুঃখিত!</strong> আপনার এন্ট্রি করতে কোনো সমস্যা হয়েছে|<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('eventPermissionTimes.store') }}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <table>
                               <tbody>
                               <tr>
                                   <td width="50%">ইভেন্ট<span style="color: red;"> * </span></td>
                                   <td><strong>:</strong> </td>
                                   <td>
                                   <select name="event_id" id="event_id" class="form-control" title="অনুগ্রহ করে ইভেন্ট বাছাই করুন" required="">
                                        <option value="">ইভেন্ট</option>
                                         @foreach($events as $event)
                                         <option value="{{ $event->event_id}}">{{ $event->event_name}}</option>
                                         @endforeach
                                   </select>
                                   </td>
                               </tr>
                               <tr>
                                   <td width="50%">সময় শুরু<span style="color: red;"> * </span> </td>
                                   <td><strong>:</strong></td>
                                   <td class="input-append date" name="perm_start_time" id="perm_start_time">
                                      <input class="form-control" placeholder="একটি তারিখ বাছাই করুন"
                                      data-format="yyyy/MM/dd hh:mm:ss" name="perm_start_time" type="text" />
                                       <span class="add-on">
                                           <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                         </span>

                                   </td>
                               </tr>
                               <tr>
                                   <td>শেষ সময় <span style="color: red;"> * </span></td>
                                   <td><strong>:</strong></td>
                                     <td class="input-append date" name="perm_end_time" id="perm_end_time">
                                        <input class="form-control" data-format="yyyy/MM/dd hh:mm:ss"
                                        placeholder="একটি তারিখ বাছাই করুন" name="perm_end_time" type="text" />
                                          <span class="add-on">
                                          <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                        </span>
                                  </td>
                               </tr>

                               </tbody>
                           </table>

        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
                <button type="submit" class="btn btn-primary">জমা দিন</button>
        </div>

 </div>

</form>
    </div>
</div>


@endsection










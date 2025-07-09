@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> নতুন ইন্সপেকশন পিরিয়ড যুক্ত করুন</span>
        <a href="{{ route('inspection_periods.index') }}" class="btn btn-secondary">
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

    <form action="{{ route('inspection_periods.store') }}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <table>
                               <tbody>
                               <tr>
                                   <td width="50%">ইন্সপেকশন পিরিয়ড<span style="color: red;"> * </span></td>
                                   <td><strong>:</strong> </td>
                                   <td>
                                   <input type="text" name="period_name" class="form-control"
                                          placeholder="ইন্সপেকশন পিরিয়ড" required>
                                   </td>
                               </tr>
                               <tr>
                                   <td width="50%">সময় শুরু<span style="color: red;"> * </span> </td>
                                   <td><strong>:</strong></td>
                                   <td class="input-append date" name="period_start_time" id="period_start_time">
                                      <input class="form-control" data-format="yyyy/MM/dd hh:mm:ss"
                                      placeholder="একটি তারিখ বাছাই করুন" name="period_start_time" type="text" />
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
                                        placeholder="একটি তারিখ বাছাই করুন" name="period_end_time" type="text" />
                                          <span class="add-on">
                                          <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                        </span>
                                  </td>
                               </tr>

                               <tr>
                                  <td>একটিভ </td>
                                  <td><strong>:</strong></td>
                                  <td><input type="checkbox" id="isActive" name="isActive" value="1"></td>
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










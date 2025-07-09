@extends('layouts.app')

@section('content')
<div class="card">
   <div class="card-header flex justify-between">
       <span class="text-2xl">মিল অনুসন্ধান</span>
    </div>
    <form action="{{ route('searchSubmitMiller') }} " method="POST" >
     @csrf
     <div class="p-4">
         <table>
             <tbody>
                <tr>
                     <td>মোবাইল নং</td>
                     <td><strong>:</strong></td>
                     <td><input maxlength="99" placeholder="মোবাইল নং লিখুন"
                         type="text" name="mobile_no" id="mobile_no" class="form-control"
                          value="" title="মোবাইল নং">
                    </td>

                    <td>মিল মািলেকর NID</td>
                     <td><strong>:</strong></td>
                     <td><input maxlength="99" placeholder="মিল মালিকের এনআইডি লিখুন"
                         type="number" name="nid_no" id="nid_no" class="form-control"
                          value="" title="মিল মালিকের এনআইডি">
                    </td>

                    <td><span style="text-align: right; color:red"> মোবাইল নং অথবা NID যেকোন একটি দিতে হবে।</span></td>

                </tr>

                <tr>
                   <td>পাস কোড</td>
                   <td><strong>:</strong></td>
                   <td><input maxlength="99" placeholder="পাস কোড লিখুন"
                       type="text" name="pass_code" id="pass_code" class="form-control"
                        value="" required="" title="পাস কোড">
                  </td>
              </tr>

                     <td  style="padding-left:10px"><input type="submit" class="btn btn-primary" name="filter" id="listOfoffice" value="ফলাফল"></td>
                 </tr>
             </tbody>
         </table>
     </div>

 </form>


    <div class="card-body">
        <table id="table_id" class="table table-bordered" cellspacing="0" cellpadding="5" width="100%">

            <thead>
                <tr>
                     <th>চালকলের নাম </th>
                     <th>চালের ধরণ </th>
                     <th>চালকলের ধরণ </th>
                     <th>উপজেলা </th>
                     <th>জেলা </th>
                     <th>বিভাগ </th>
                     <th>তথ্য স্ট্যাটাস </th>
                </tr>
            </thead>

            <tbody>
                @foreach($millers as $miller)
                <tr>
                    <td><span><a class="dropdown-item" href="{{ route('millerregister.edit',$miller->miller_id) }}">{{$miller->mill_name}}</a> </span></td>
                    <td><span>{{$miller->chaltype->chal_type_name}}</span></td>
                    <td><span>{{$miller->milltype->mill_type_name}}</span></td>
                    <td><span>{{($miller->mill_upazila_id)? $miller->upazilla->upazillaname : ""}}</span></td>
                    <td><span>{{$miller->district->distname}}</span></td>
                    <td><span>{{$miller->division->divname}}</span></td>
                    <td><span>@if($miller->cmp_status) সম্পূর্ণ @else অসম্পূর্ণ @endif</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection


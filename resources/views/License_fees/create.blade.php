@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> নতুন লাইসেন্স ফী যুক্ত করুন</span>
        <a href="{{ route('license_fees.index') }}" class="btn btn-secondary">
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

<form action="{{ route('license_fees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <table>
                            <tbody>
                               <tr>
                                   <td width="50%">লাইসেন্স টাইপ <span style="color: red;"> * </span></td>
                                   <td><strong>:</strong> </td>
                                   <td>
                                   <select name="license_type_id" id="license_type_id" class="form-control" size="1" title="অনুগ্রহ করে লাইসেন্স টাইপ বাছাই করুন" required="">
                                        <option value="">লাইসেন্স টাইপ</option>
                                        @foreach($license_types as $license_type)
                                        <option value="{{ $license_type->id}}">{{ $license_type->name}}</option>
                                        @endforeach
                                    </select>
                                   </td>
                               </tr>

                               <tr>
                                   <td width="50%">লাইসেন্সের নাম <span style="color: red;"> * </span> </td>
                                   <td><strong>:</strong></td>
                                   <td> <input type="text" name="name" class="form-control" placeholder="লাইসেন্সের নাম" required="">

                                   </td>
                               </tr>

                               <tr>
                                   <td>এফেক্টিভ ডেট <span style="color: red;"> * </span></td>
                                   <td><strong>:</strong></td>
                            
                                   <td class="input-append date" name="effective_todate" id="effective_todate">
                                   <input class="form-control" data-format="yyyy/MM/dd hh:mm:ss"
                                        placeholder="একটি তারিখ বাছাই করুন" name="effective_todate" type="text" required=""/>
                                            <span class="add-on">
                                                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>

                                   </td>
                               </tr>

                               <tr>
                                  <td>লাইসেন্স ফী </td>
                                  <td><strong>:</strong></td>
                                  <td><input type="number" min="0" name="license_fee" required=""
                                   class="form-control" placeholder="লাইসেন্স ফী"></td>
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










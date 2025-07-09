@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> নতুন অফিস যুক্ত করুন</span>
        <a href="{{ route('offices.index') }}" class="btn btn-secondary">
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

<form action="{{ route('offices.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
       <div class="col-xs-12 col-sm-6 col-md-6">
           <div class="form-group">
               <strong>নাম:</strong>
               <input type="text" name="office_name"
               class="form-control" placeholder="অফিস নাম" required="">
           </div>
       </div>
   </div>

    <div class="row">
       <div class="col-xs-12 col-sm-6 col-md-6">
           <div class="form-group">
               <strong>ঠিকানা:</strong>
               <input type="text" name="office_address"
               class="form-control" placeholder="অফিস ঠিকানা">
           </div>
       </div>
   </div>

     <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>বিভাগ:</strong>
                <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                    <option value="">বিভাগ</option>
                    @foreach($divisions as $division)
                    <option value="{{ $division->divid}}">{{ $division->divname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>জেলা:</strong>
                <select name="district_id" id="district_id" class="form-control" size="1" title="অনুগ্রহ করে  জেলা বাছাই করুন">
                    <option value="">জেলা</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
       <div class="col-xs-12 col-sm-6 col-md-6">
           <div class="form-group">
               <strong>উপজেলা:</strong>
               <select name="upazilla_id" id="mill_upazila_id" class="form-control" size="1"
               title="অনুগ্রহ করে উপজেলা বাছাই করুন">
                   <option value="">উপজেলা</option>
               </select>
           </div>
       </div>
   </div>

   <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="form-group">
              <strong>অফিস টাইপ:</strong><span style="color: red">*</span>
              <select required name="office_type_id" id="office_type_id" class="form-control" size="1"
               title="অনুগ্রহ করে অফিস টাইপ বাছাই করুন">
                  <option value="">অফিস টাইপ</option>
                  @foreach($office_types as $office_type)
                  <option value="{{$office_type->office_type_id}}">{{ $office_type->type_name}}</option>
                  @endforeach
              </select>
          </div>
      </div>
  </div>


        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
                <button type="submit" class="btn btn-primary">জমা দিন</button>
        </div>

 </div>

</form>
    </div>
</div>



@endsection










@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> নতুন জেলা যুক্ত করুন</span>
        <a href="{{ route('districts.index') }}" class="btn btn-secondary">
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
   
<form action="{{ route('districts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>বিভাগ:</strong>
                <select name="divid" id="divid" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন"  required="">
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
                <strong>জেলা(বাংলা নাম):</strong>
                <input type="text" name="distname"  
                class="form-control" placeholder="জেলা নাম বাংলা">
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>জেলা(ইংরেজি নাম):</strong>
                <input type="text" name="name"  
                class="form-control" placeholder="জেলা নাম ইংরেজি">
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










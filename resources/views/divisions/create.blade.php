@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> নতুন বিভাগ যুক্ত করুন</span>
        <a href="{{ route('divisions.index') }}" class="btn btn-secondary">
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
   
<form action="{{ route('divisions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf  
     
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>বিভাগের আইডি:</strong>
                <input type="text" name="divid" class="form-control" placeholder="বিভাগের আইডি">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>বিভাগ(বাংলা নাম):</strong>
                <input type="text" name="divname" class="form-control" placeholder="বিভাগের নাম">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>বিভাগ(ইংরেজি নাম):</strong>
                <input type="text" name="name"  
                class="form-control" placeholder="বিভাগ নাম ইংরেজি">
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










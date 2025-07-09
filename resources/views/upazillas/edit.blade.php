@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> উপজেলা হালনাগাদ</span>
        <a href="{{ route('upazillas.index') }}?page={{$pp_page}}&division_id={{$pp_division}}&district_id={{$pp_district}}&searchtext={{$pp_searchtext}}" class="btn btn-secondary">
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

<form action="{{ route('upazillas.update',$upazilla->upazillaid) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

     <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>বিভাগ:</strong>
                <select name="divid" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন"  required="">
                    <option value="">বিভাগ</option>
                    @foreach($divisions as $division)
                    <option value="{{ $division->divid}}" {{ $division->divid == $divid ? 'selected' : '' }}>{{ $division->divname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>জেলা:</strong>
                <select name="distid" id="district_id" class="form-control" size="1"
                 title="অনুগ্রহ করে  জেলা বাছাই করুন">
                    <option value="">জেলা</option>
                    @foreach($districts as $district)
                    <option value="{{$district->distid}}" {{$district->distid == $distid ? 'selected' : '' }}>{{ $district->distname}}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div> 
    

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>উপজেলা(বাংলা নাম):</strong>
                <input type="text" name="upazillaname"  value="{{$upazilla->upazillaname }}" 
                class="form-control" placeholder="উপজেলা নাম বাংলা">
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>উপজেলা(ইংরেজি নাম):</strong>
                <input type="text" name="name"  value="{{$upazilla->name}}" 
                class="form-control" placeholder="উপজেলা নাম ইংরেজি">
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










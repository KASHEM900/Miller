@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl">মিলার ইন্যাক্টিভ রিজনস এন্ট্রি </span>
        <a href="{{ route('millerInactiveReasons.index') }}" class="btn btn-secondary">
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
   
<form action="{{ route('millerInactiveReasons.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>মিলার ইন্যাক্টিভ রিজনস:</strong>
                <input type="text" name="reason_name" class="form-control" placeholder="মিলার ইন্যাক্টিভ রিজনস">
            </div>
        </div>
 </div>

        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
                <button type="submit" class="btn btn-primary">সাবমিট</button>
        </div>
    </div>
   
</form>
    </div>
</div>

@endsection










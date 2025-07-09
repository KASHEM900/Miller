@extends('configuration.layout')

@section('contentbody')

<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> ইভেন্ট হালনাগাদ</span>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">
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
  
    <form action="{{ route('events.update',$event->event_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
         <div class="row">
         <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>ইভেন্ট:</strong>
                    <input type="text" name="event_name" value="{{$event->event_name }}" class="form-control"
                     placeholder="ইভেন্টের নাম">
                </div>
            </div>
           
           
        </div> <div class="col-xs-12 col-sm-6 col-md-6 text-center">
         <button type="submit" class="btn btn-primary">জমা দিন</button>
 </div>
 </div>
   
    </form>
    </div>
</div>   
   
   
@endsection









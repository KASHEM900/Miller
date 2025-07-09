@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl">এডিট মিলিং ইউনিটের যন্ত্রপাতি </span>
        <a href="{{ route('millingunitmachineries.index') }}" class="btn btn-secondary">
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
  
    <form action="{{ route('millingunitmachineries.update', $millingunitmachinery->machinery_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
         <div class="row">
         <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>মিলিং ইউনিটের যন্ত্রপাতি:</strong>
                    <input type="text" name="name" value="{{ $millingunitmachinery->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
           
           
        </div> <div class="col-xs-12 col-sm-6 col-md-6 text-center">
         <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
    </form>
    </div>
</div>

    
@endsection









@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> এডিট চালের ধরন</span>
        <a href="{{ route('chaltypes.index') }}" class="btn btn-secondary">
            আগের পৃষ্ঠা
        </a>
    </div>

    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('chaltypes.update',$chaltype->chal_type_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>নাম:</strong>
                    <input type="text" name="chal_type_name" value="{{$chaltype->chal_type_name }}" class="form-control" placeholder="Name">
                </div>
            </div>
         
         </div>
         <div class="col-xs-12 col-sm-6 col-md-6 text-center">
            <button type="submit" class="btn btn-primary">সাবমিট</button>
         </div>
   
    </form>
    </div>
</div>
   
    
@endsection









@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> নতুন মটরের ক্ষমতা এন্ট্রি</span>
        <a href="{{ route('motorpowers.index') }}" class="btn btn-secondary">
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
   
<form action="{{ route('motorpowers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>অশ্বশক্তি:</strong>
                <input type="text" name="motor_power" class="form-control" placeholder="অশ্বশক্তি">
            </div>
            <div class="form-group">
                <strong>হলার সংখ্যা:</strong>
                <input type="text" name="holar_num" class="form-control" placeholder="হলার সংখ্যা">
            </div>
            <div class="form-group">
                <strong>ছাঁটাই ক্ষমতা:</strong>
                <input type="text" name="power_per_hour" class="form-control" placeholder="ছাঁটাই ক্ষমতা">
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </div>
   
</form>

    </div>
</div>



@endsection










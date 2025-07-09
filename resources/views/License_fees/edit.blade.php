@extends('configuration.layout')

@section('contentbody')
    <div class="card">
        <div class="card-header flex justify-between">
            <span class="text-2xl">লাইসেন্স ফী হালনাগাদ </span>
            <a href="{{ route('license_fees.index') }}" class="btn btn-secondary">
                আগের পৃষ্ঠা
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <div class="alert alert-danger">
                    <strong>দুঃখিত!</strong> আপনার হালনাগাদ করতে কোনো সমস্যা হয়েছে|<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <form action="{{ route('license_fees.update',$license_fee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')


                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>লাইসেন্স টাইপ:</strong>
                            <select name="license_type_id" id="license_type_id" class="form-control" size="1"
                            title="অনুগ্রহ করে লাইসেন্স টাইপ বাছাই করুন" required="">
                                <option value="">লাইসেন্স টাইপ</option>
                                @foreach($license_types as $license_type)
                                <option value="{{ $license_type->id}}" {{ $license_type->id == $license_type_id ? 'selected' : '' }}>{{ $license_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>লাইসেন্স টাইপ:</strong>
                        <input type="text" name="name" value="{{$license_fee->name }}"
                        class="form-control" placeholder="লাইসেন্স টাইপ নাম" required="">
                    </div>
               </div>
            </div>

     <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="input-append date" name="effective_todate" id="effective_todate">
                <strong>এফেক্টিভ ডেট:</strong>
                <input class="form-control" data-format="yyyy/MM/dd hh:mm:ss" value="{{$license_fee->effective_todate }}"
                placeholder="একটি তারিখ বাছাই করুন" name="effective_todate" type="text" required="" />
                    <span class="add-on">
                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>লাইসেন্স ফী:</strong>
                <input type="number" min="0" name="license_fee" value="{{$license_fee->license_fee }}"
                class="form-control" placeholder="লাইসেন্স ফী" required="">
            </div>
        </div>
    </div>



                <div class="col-xs-12 col-sm-6 col-md-6 text-center">
                    <button type="submit" class="btn btn-primary">জমা দিন</button>
                </div>
            </form>
        </div>
    </div>
@endsection









@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> লাইসেন্স ফী</span>
        <a href="{{ route('license_fees.create') }}" class="btn btn-secondary">
            নতুন এন্ট্রি
        </a>
    </div>

    <div class="card-body">
        <table id="table_id" class="table table-bordered" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th>লাইসেন্স টাইপ</th>
                    <th>লাইসেন্সের নাম</th>
                    <th>এফেক্টিভ ডেট</th>
                    <th>লাইসেন্স ফী</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>

            <tbody>
                @foreach($license_fees as $license_fee)
                <tr>       
                    <td><span>{{$license_fee->license_type->name}}</span></td>
                    <td><span>{{$license_fee->name}}</span></td>
                    <td><span>{{$license_fee->effective_todate}}</span></td>
                    <td><span>{{$license_fee->license_fee}}</span></td>
                             <td>   
                                <a href="{{ route('license_fees.edit',$license_fee->id) }}" class="btn2 btn-primary">
                                এডিট</a>
                                        
                                <span class="btn2 btn-danger"  
                                        onclick="event.preventDefault();
                                            if(confirm('Are you really want to delete?')){
                                                document.getElementById('form-delete-{{$license_fee->id}}')
                                                .submit()
                                            }">ডিলিট</span>
                                <form style="display:none" id="{{'form-delete-'.$license_fee->id}}" method="post" action="{{route('license_fees.destroy',$license_fee->id)}}">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-center pt-2"> {!! $license_fees->links() !!} </div>
    </div>
</div>

@endsection


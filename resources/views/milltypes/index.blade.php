@extends('configuration.layout')

@section('contentbody')

<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> চালকলের ধরন </span>
        <a href="{{ route('milltypes.create') }}" class="btn btn-secondary">
            নতুন এন্ট্রি
        </a>       
    </div>

    <div class="card-body">

        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th width="300px">চালকলের ধরন</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($millTypes as $millType)
        <tr>
            <td>{{ $millType->mill_type_name}}</td>
            <td>   
                <a href="{{route('milltypes.edit',$millType->mill_type_id)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$millType->mill_type_id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$millType->mill_type_id}}" method="post" action="{{route('milltypes.destroy',$millType->mill_type_id)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $millTypes->links() !!} </div>
    </div>
</div>   
    
@endsection


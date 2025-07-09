@extends('configuration.layout')

@section('contentbody')

<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> ইউজারের ধরন </span>
        <a href="{{ route('usertypes.create') }}" class="btn btn-secondary">
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
            <th width="300px">ইউজারের ধরন</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($userTypes as $userType)
        <tr>
            <td>{{ $userType->name}}</td>
            <td>   
                <a href="{{route('usertypes.edit',$userType->id)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$userType->id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$userType->id}}" method="post" action="{{route('usertypes.destroy',$userType->id)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $userTypes->links() !!} </div>
    </div>
</div>   
    
@endsection


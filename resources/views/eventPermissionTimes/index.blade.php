@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl">ইভেন্টস পারমিশন সময়নিরুপণ </span>
        <a href="{{ route('eventPermissionTimes.create') }}" class="btn btn-secondary">
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
            <th width="300px">ইভেন্ট</th>
            <th width="300px">সময় শুরু</th>
            <th width="300px">শেষ সময়</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($eventPermissionTimes as $eventPermissionTime)
        <tr>
            <td>{{ $eventPermissionTime->event->event_name}}</td>
            <td>{{ $eventPermissionTime->perm_start_time}}</td>
            <td>{{ $eventPermissionTime->perm_end_time}}</td>
            
            <td>   
                <a href="{{route('eventPermissionTimes.edit',$eventPermissionTime->id)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$eventPermissionTime->id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$eventPermissionTime->id}}" method="post" 
                action="{{route('eventPermissionTimes.destroy',$eventPermissionTime->id)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>
            
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $eventPermissionTimes->links() !!} </div>
    </div>
</div>
@endsection


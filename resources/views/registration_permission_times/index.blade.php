@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl">রেজিস্ট্রেশন সময়নিরুপণ </span>
        <a href="{{ route('registration_permission_times.create') }}" class="btn btn-secondary">
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
            <th width="300px">সময় শুরু</th>
            <th width="300px">শেষ সময়</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($registration_permission_times as $registration_permission_time)
        <tr>
            <td>{{ $registration_permission_time->perm_start_time}}</td>
            <td>{{ $registration_permission_time->period_end_time}}</td>
            
            <td>   
                <a href="{{route('registration_permission_times.edit',$registration_permission_time->id)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$registration_permission_time->id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$registration_permission_time->id}}" method="post" 
                action="{{route('registration_permission_times.destroy',$registration_permission_time->id)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>
            
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $registration_permission_times->links() !!} </div>
    </div>
</div>
@endsection


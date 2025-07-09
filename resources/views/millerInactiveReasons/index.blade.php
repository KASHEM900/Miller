@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> মিলার ইন্যাক্টিভ রিজনস</span>
        <a href="{{ route('millerInactiveReasons.create') }}" class="btn btn-secondary">
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
            <th width="300px">নাম </th>
            <th width="250px">অ্যাকশন </th>
        </tr>
        @forelse($millerInactiveReasons as $millerInactiveReason)
        <tr>
            <td>{{$millerInactiveReason->reason_name}}</td>
            <td>   
                <a href="{{route('millerInactiveReasons.edit',$millerInactiveReason->reason_id)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$millerInactiveReason->reason_id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$millerInactiveReason->reason_id}}" method="post" action="{{route('millerInactiveReasons.destroy',$millerInactiveReason->reason_id)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>          
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $millerInactiveReasons->links() !!} </div>
    </div>
</div>
        
@endsection


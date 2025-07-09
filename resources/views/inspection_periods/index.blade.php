@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl">ইন্সপেকশন পিরিয়ড </span>
        <a href="{{ route('inspection_periods.create') }}" class="btn btn-secondary">
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
            <th width="250px">পিরিয়ড নাম</th>
            <th width="250px">সময় শুরু</th>
            <th width="250px">শেষ সময়</th>
            <th width="250px">একটিভ</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($inspection_periods as $inspection_period)
        <tr>
            <td>{{ $inspection_period->period_name}}</td>
            <td>{{ $inspection_period->period_start_time}}</td>
            <td>{{ $inspection_period->period_end_time}}</td>
            @if( $inspection_period->isActive==1)
                <td>একটিভ</td>
            
            @else
                <td>ইন্যাক্টিভ</td>
           
            @endif
            
            <td>   
                <a href="{{route('inspection_periods.edit',$inspection_period->id)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$inspection_period->id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$inspection_period->id}}" method="post" 
                action="{{route('inspection_periods.destroy',$inspection_period->id)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>
            
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $inspection_periods->links() !!} </div>
    </div>
</div>
@endsection


@extends('configuration.layout')

@section('contentbody')

<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> মটরের ক্ষমতা</span>
        <a href="{{ route('motorpowers.create') }}" class="btn btn-secondary">
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
            <th width="300px">অশ্বশক্তি</th>
            <th width="300px">হলার সংখ্যা </th>
            <th width="300px">ছাঁটাই ক্ষমতা</th> 
            
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($motorpowers as $motorpower)
        <tr>
            <td>{{ $motorpower->motor_power}}</td>
            <td>{{ $motorpower->holar_num}}</td>
            <td>{{ $motorpower->power_per_hour}}</td>
            <td>   
                <a href="{{route('motorpowers.edit',$motorpower->motorid)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$motorpower->motorid}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$motorpower->motorid}}" method="post" action="{{route('motorpowers.destroy',$motorpower->motorid)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $motorpowers->links() !!} </div>
    </div>
</div>

    
@endsection


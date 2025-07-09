@extends('configuration.layout')

@section('contentbody')

<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> মিলিং ইউনিটের যন্ত্রপাতি </span>
        <a href="{{ route('millingunitmachineries.create') }}" class="btn btn-secondary">
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
            <th width="300px">মিলিং ইউনিটের যন্ত্রপাতি</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($millingUnitMachineries as $millingunitmachinery)
        <tr>
            <td>{{ $millingunitmachinery->name}}</td>
            <td>   
                <a href="{{route('millingunitmachineries.edit',$millingunitmachinery->machinery_id)}}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$millingunitmachinery->machinery_id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$millingunitmachinery->machinery_id}}" method="post" action="{{route('millingunitmachineries.destroy',$millingunitmachinery->machinery_id)}}">
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $millingUnitMachineries->links() !!} </div>
    </div>
</div>   
    
@endsection


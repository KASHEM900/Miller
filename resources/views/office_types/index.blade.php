@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> অফিস টাইপ</span>
        <a href="{{ route('office_types.create') }}" class="btn btn-secondary">
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
            <th width="300px">নাম</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($office_types as $office_type)
        <tr>
            <td>{{ $office_type->type_name}}</td>
            
            <td>   
                <a href="{{ route('office_types.edit',$office_type->office_type_id) }}" class="btn2 btn-primary">
                এডিট</a>
                        
                <span class="btn2 btn-danger"  
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$office_type->office_type_id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$office_type->office_type_id}}" method="post" action="{{ route('office_types.destroy',$office_type->office_type_id) }}">
                    @csrf
                    @method('delete')
                </form>
            </td>
            
        </tr>
        
        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $office_types->links() !!} </div>
    </div>
</div>
    
@endsection


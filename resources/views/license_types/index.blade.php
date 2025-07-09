@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> লাইসেন্স টাইপ</span>
        <!--<a href="{{ route('license_types.create') }}" class="btn btn-secondary">
            নতুন এন্ট্রি
        </a>-->
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
        @forelse($license_types as $license_type)
        <tr>
            <td>{{ $license_type->name}}</td>

            <td>
                <a href="{{ route('license_types.edit',$license_type->id) }}" class="btn2 btn-primary">
                এডিট</a>

                <span class="btn2 btn-danger"
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$license_type->id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$license_type->id}}" method="post" action="{{ route('license_types.destroy',$license_type->id) }}">
                    @csrf
                    @method('delete')
                </form>
            </td>

        </tr>

        @endforeach
    </table>
    <div class="flex justify-center pt-2"> {!! $license_types->links() !!} </div>
    </div>
</div>

@endsection


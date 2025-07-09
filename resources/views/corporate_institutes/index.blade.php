@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> কর্পোরেট প্রতিষ্ঠান</span>
        <a href="{{ route('corporate_institutes.create') }}" class="btn btn-secondary">
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
            <th>নাম</th>
            <th>ঠিকানা</th>
            <th>অ্যাকশন</th>
        </tr>
        @forelse($corporate_institutes as $corporate_institute)
        <tr>
        <td>{{ $corporate_institute->name}}</td>
        <td>{{ $corporate_institute->address}}</td>

            <td>
                <a href="{{ route('corporate_institutes.edit',$corporate_institute->id) }}" class="btn2 btn-primary">
                এডিট</a>

                <span class="btn2 btn-danger"
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$corporate_institute->id}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$corporate_institute->id}}" method="post" action="{{ route('corporate_institutes.destroy',$corporate_institute->id) }}">
                    @csrf
                    @method('delete')
                </form>
            </td>

        </tr>

        @endforeach
    </table>
    <div class="flex justify-center pt-2"> {!! $corporate_institutes->links() !!} </div>
    </div>
</div>

@endsection


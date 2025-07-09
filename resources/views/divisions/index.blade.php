@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> বিভাগ</span>
        <a href="{{ route('divisions.create') }}" class="btn btn-secondary">
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
            <th width="300px">বিভাগ (বাংলা নাম)</th>
            <th>বিভাগ(ইংরেজি নাম)</th>
            <th width="250px">অ্যাকশন</th>
        </tr>
        @forelse($divisions as $division)
        <tr>
            <td>{{ $division->divname}}</td>
            <td>{{$division->name}}</td>
            <td>
                <a href="{{ route('divisions.edit',$division->divid) }}"" class="btn2 btn-primary">
                এডিট</a>

                <span class="btn2 btn-danger"
                        onclick="event.preventDefault();
                            if(confirm('Are you really want to delete?')){
                                document.getElementById('form-delete-{{$division->divid}}')
                                .submit()
                            }">ডিলিট</span>
                <form style="display:none" id="{{'form-delete-'.$division->divid}}" method="post" action="{{ route('divisions.destroy',$division->divid) }}">
                    @csrf
                    @method('delete')
                </form>
            </td>

        </tr>

        @endforeach
    </table>
        <div class="flex justify-center pt-2"> {!! $divisions->links() !!} </div>
    </div>
</div>

@endsection


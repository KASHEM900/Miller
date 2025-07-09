@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> জেলা</span>
        <!--<a href="{{ route('districts.create') }}" class="btn btn-secondary">
            নতুন এন্ট্রি
        </a>-->
    </div>

    <div class="card-body">
        <table id="table_id" class="table table-bordered" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th>জেলা(বাংলা নাম)</th>
                    <th>জেলা(ইংরেজি নাম)</th>
                    <th>বিভাগ</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>

            <tbody>
                @foreach($districts as $district)
                <tr>
                    <td><span>{{$district->distname}}</span></td>
                    <td><span>{{$district->name}}</span></td>
                    <td><span>{{$district->division->divname}}</span></td>
                             <td>   
                                <a href="{{ route('districts.edit',$district->distid) }}" class="btn2 btn-primary">
                                এডিট</a>
                                        
                                <span class="btn2 btn-danger"  
                                        onclick="event.preventDefault();
                                            if(confirm('Are you really want to delete?')){
                                                document.getElementById('form-delete-{{$district->distid}}')
                                                .submit()
                                            }">ডিলিট</span>
                                <form style="display:none" id="{{'form-delete-'.$district->distid}}" method="post" action="{{route('districts.destroy',$district->distid)}}">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-center pt-2"> {!! $districts->links() !!} </div>
    </div>
</div>

@endsection


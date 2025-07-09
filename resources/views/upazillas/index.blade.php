@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl"> উপজেলা</span>
        <!--<a href="{{route('upazillas.create')}}" class="btn btn-secondary">
            নতুন এন্ট্রি
        </a>-->
    </div>

    <form action="{{ route('upazillas.index') }}">
                    @csrf
                    <div>
        <table cellpadding="2px">
            <tbody>
                <tr>
                    <td>বিভাগ:</td>
                    <td>
                        <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                                <option value="">বিভাগ</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->divid}}"{{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                @endforeach
                        </select>
                    </td>

                    <td>জেলা:</td>
                    <td><select name="district_id" id="district_id" class="form-control" size="1" title="অনুগ্রহ করে  জেলা বাছাই করুন">
                        <option value="">জেলা</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->distid}}"{{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                        @endforeach
                        </select>
                    </td>
                    <td><input maxlength="50" placeholder="অনুসন্ধান" type="text"
                                        name="searchtext" id="searchtext" class="form-control" value="{{$searchtext}}" /></td>
                    
                    <td style="padding-left:10px"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary"  value="ফলাফল"></td>
            </tbody>
        </table>
        </div>
                </form>

    <div class="card-body">
        <table id="table_id" class="table table-bordered" cellspacing="0" cellpadding="5" width="100%">

            <thead>
                <tr>
                    <th>উপজেলা(বাংলা নাম)</th>                  
                    <th>উপজেলা(ইংরেজি নাম)</th>
                    <th>জেলা</th>
                    <th>বিভাগ</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>

            <tbody>
                @foreach($upazillas as $upazilla)
                <tr>
                    <td><span>{{$upazilla->upazillaname}}</span></td>
                    <td><span>{{$upazilla->name}}</span></td>
                    <td><span>{{$upazilla->district->distname}}</span></td>
                    <td><span>{{$upazilla->district->division->divname}}</span></td>
                    <td>   
                        <a href="{{route('upazillas.edit',$upazilla->upazillaid)}}" class="btn2 btn-primary">
                        এডিট</a>
                                
                        <span class="btn2 btn-danger"  
                                onclick="event.preventDefault();
                                    if(confirm('Are you really want to delete?')){
                                        document.getElementById('form-delete-{{$upazilla->upazillaid}}')
                                        .submit()
                                    }">ডিলিট</span>
                        <form style="display:none" id="{{'form-delete-'.$upazilla->upazillaid}}" method="post" action="{{route('upazillas.destroy',$upazilla->upazillaid)}}">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-center pt-2"> 
            {!! $upazillas->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
</div>
@endsection


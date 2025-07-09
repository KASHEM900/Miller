@extends('miller.layout')

@section('contentbody')
<div class="card">

<div class="card-header text-2xl"> ডুপ্লিকেট লাইসেন্স সমূহের তালিকা </div>
<form action="{{ route('duplicateLicence') }}">
                    @csrf
                    <div class="p-4">
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

                                    <td>উপজেলা:</td>
                                    <td>
                                        <select name="mill_upazila_id" id="mill_upazila_id" class="form-control" title="অনুগ্রহ করে  উপজেলা বাছাই করুন">
                                            <option value="">উপজেলা</option>
                                            @foreach($upazillas as $upazilla)
                                            <option value="{{ $upazilla->upazillaid}}"{{ ( $upazilla->upazillaid == $mill_upazila_id) ? 'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td style="padding-left:10px"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary"  value="ফলাফল"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
    <div class="card-body">
        <table id="table_id" class="table table-bordered" cellspacing="0" width="100%">

            <thead>
                <tr>
                <th>চালকলের নাম	@sortablelink('mill_name', '')</th>
                    <th>মালিকের নাম	@sortablelink('owner_name', '')</th>
                    <th>জেলা</th>
                    <th>উপজেলা</th>
                    <th>লাইসেন্স নম্বর	@sortablelink('license_no', '')</th>
                    <th>চালকলের ধরণ @sortablelink('milltype.mill_type_name', '')</th>
                    <th>চালকলের অবস্থা</th>
                    <th>ডিপোসিট তারিখ</th>
                    <th>এমাউন্ট</th>
                </tr>
            </thead>

            <tbody>
            @foreach($millers as $key => $miller)
                <tr>
                            <td><a href="{{ route('millers.edit',$miller->miller_id) }}"><span>{{$miller->mill_name}}</span></a></td>
                            <td><span>{{$miller->owner_name}}</span></td>
                            <td><span>{{$miller->district->distname}}</span></td>
                            <td><span>{{$miller->upazilla->upazillaname}}</span></td>
                            <td><span>{{$miller->license_no}}</span></td>
                            <td><span>@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif</span></td>
                            <td><span>@if($miller->miller_status == "new_register") নতুন নিবন্ধন @elseif($miller->miller_status == "inactive") বন্ধ চালকল @else সচল চালকল @endif</span></td>
                            <td><span>{{$miller->license_deposit_date}}</span></td>
                            <td><span>{{$miller->license_deposit_amount}}</span></td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-center pt-2"> {!! $millers->links() !!} </div>
    </div>
</div>

@endsection


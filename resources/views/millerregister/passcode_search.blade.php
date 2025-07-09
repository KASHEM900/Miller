@extends('miller.layout')

@section('contentbody')
<div class="card">
    @if(session()->has('message'))
    <div class="alert alert-success">
        {!! session()->get('message') !!}
    </div>
    @endif

    <div class="card-header flex justify-between">
        <span class="text-2xl">পাসকোড অনুসন্ধান</span>
    </div>

    <div class="card-body">
        <div class="row">
            <form action="{{ route('searchPasscode') }}">
                @csrf
                <div class="p-4">
                    <table>
                        <tbody>
                        <tr>
                                <td>মোবাইল নং</td>
                                <td><strong>:</strong></td>
                                <td><input required maxlength="99" placeholder="মোবাইল নং লিখুন"
                                type="text" name="mobile_no" id="mobile_no" class="form-control"
                                value="" title="মোবাইল নং">
                            </td>


                                <td  style="padding-left:10px"><input type="submit" class="btn btn-primary" name="filter" id="listOfoffice" value="ফলাফল"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <form action="{{ route('generate_pass_code') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4">
                    <table cellpadding="2px">
                        <tbody>
                            <tr>
                                @csrf
                                <input type="hidden" name="mobile_no"  value="{{$mobile_no}}">

                                <td style="padding-left:10px">
                                    <input type="submit" name="filter" id="listOfckol" class="btn btn-secondary" value="{{ __('জেনারেট পাসকোড') }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        @if($pass_code_message)
            <div class="alert alert-danger text-center">
                <h4>{!! $pass_code_message !!}</h4>
            </div>
        @endif

        <table id="table_id" class="table table-bordered" cellspacing="0" cellpadding="5" width="100%">

            <thead>
                <tr>
                    <th>মোবাইল </th>
                    <th>পাসকোড </th>
                        <th>চালকলের নাম </th>
                        <th>চালের ধরণ </th>
                        <th>চালকলের ধরণ </th>
                        <th>উপজেলা </th>
                        <th>জেলা </th>
                        <th>বিভাগ </th>

                </tr>
            </thead>

            <tbody>
            @foreach($millers as $miller)
                <tr>
                    <td><span>{{$miller->mobile_no}}</span></td>
                    <td><span>{{$miller->pass_code}}</span></td>
                    <td><span>{{$miller->mill_name}}</span></td>
                    <td><span>{{$miller->chaltype->chal_type_name}}</span></td>
                    <td><span>{{$miller->milltype->mill_type_name}}</span></td>
                    <td><span>{{($miller->mill_upazila_id)? $miller->upazilla->upazillaname : ""}}</span></td>
                    <td><span>{{$miller->district->distname}}</span></td>
                    <td><span>{{$miller->division->divname}}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-header flex justify-between">
            <span class="text-2xl">বিভাগ, জেলা এবং উপজেলা পাসকোড অনুসন্ধান</span>
        </div>

        <div class="row">
            <form action="{{ route('searchPasscode') }}">
                @csrf
                <div class="p-4">
                    <table>
                        <tbody>
                            <tr>
                                <td>বিভাগ</td>
                                <td><strong>:</strong></td>
                                <td>
                                <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                                    <option value="">বিভাগ</option>
                                    @foreach($divisions as $division)
                                    <option value="{{ $division->divid}}" {{ $division->divid == $division_id ? 'selected' : '' }}>{{ $division->divname}}</option>
                                    @endforeach
                                </select>
                                </td>



                                <td>জেলা</td>
                                <td><strong>:</strong></td>
                                <td>
                                <select name="district_id" id="district_id" class="form-control" size="1" title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                    <option value="">জেলা</option>
                                    @foreach($districts as $district)
                                    <option value="{{ $district->distid}}" {{ $district->distid == $district_id ? 'selected' : '' }}> {{ $district->distname}}</option>
                                    @endforeach
                                </select>
                                </td>



                                <td>উপজেলা</td>
                                <td><strong>:</strong></td>
                                <td>
                                <select name="upazila_id" id="mill_upazila_id" class="form-control" class="form-control" size="1" title="অনুগ্রহ করে উপজেলা বাছাই করুন">
                                    <option value="">উপজেলা</option>
                                    @foreach($upazillas as $upazilla)
                                    <option value="{{ $upazilla->upazillaid}}" {{ ( $upazilla->upazillaid == $upazila_id) ? 'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                                    @endforeach
                                </select>
                                </td>


                                <td  style="padding-left:10px"><input type="submit" class="btn btn-primary" name="filter" id="listOfoffice" value="ফলাফল"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <form action="{{ route('generate_pass_code') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4">
                    <table cellpadding="2px">
                        <tbody>
                            <tr>
                                @csrf
                                <input type="hidden" name="division_id"  value="{{$division_id}}">
                                <input type="hidden" name="district_id"  value="{{$district_id}}">
                                <input type="hidden" name="upazila_id"  value="{{$upazila_id}}">

                                <td style="padding-left:10px">
                                    <input type="submit" name="filter" id="listOfckol" class="btn btn-secondary" value="{{ __('জেনারেট পাসকোড') }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <form action="{{ route('exportpasscode') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4">
                    <input type="hidden" name="division_id"  value="{{$division_id}}">
                    <input type="hidden" name="district_id"  value="{{$district_id}}">
                    <input type="hidden" name="upazila_id"  value="{{$upazila_id}}">

                    <span class="print_hide" style="float: right;">
                        <input type="submit" class="btn btn-secondary" value="Export">
                    </span>
                </div>
            </form>
        </div>
        
        <table id="table_id" class="table table-bordered" cellspacing="0" cellpadding="5" width="100%">

            <thead>
                <tr>
                    <th>মোবাইল </th>
                    <th>পাসকোড </th>
                    <th>চালকলের নাম </th>
                    <th>চালের ধরণ </th>
                    <th>চালকলের ধরণ </th>
                    <th>উপজেলা </th>
                    <th>জেলা </th>
                    <th>বিভাগ </th>
                </tr>
            </thead>

            <tbody>


            @foreach($millers2 as $miller2)
                <tr>
                    <td><span>{{$miller2->mobile_no}}</span></td>
                    <td><span>{{$miller2->pass_code}}</span></td>
                    <td><span>{{$miller2->mill_name}}</span></td>
                    <td><span>{{$miller2->chaltype->chal_type_name}}</span></td>
                    <td><span>{{$miller2->milltype->mill_type_name}}</span></td>
                    <td><span>{{($miller2->mill_upazila_id)? $miller2->upazilla->upazillaname : ""}}</span></td>
                    <td><span>{{$miller2->district->distname}}</span></td>
                    <td><span>{{$miller2->division->divname}}</span></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
@endsection
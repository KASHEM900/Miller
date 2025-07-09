@extends('miller.layout')
@section('title', 'চালকল পরিদর্শন')

@section('contentbody')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl"> মিলার পরিদর্শন সমূহের তালিকা </div>
                <div class="p-3 flex justify-between justify-middle">
                    <form action="{{ route('inspections.index') }}">
                        @csrf
                        <div>
                            <table cellpadding="3px">
                                <tbody>
                                    <tr>
                                    <td class="pl-2">পিরিয়ড</td>
                                    <td class="pl-2">স্ট্যাটাস</td>
                                    <td class="pl-2">অযোগ্যতার কারন</td>
                                    <td class="pl-2">কারণ</td>
                                    <td class="pl-2">বিভাগ</td>
                                    <td class="pl-2"> জেলা</td>
                                    <td class="pl-2">উপজেলা </td>
                                    <td class="pl-2">মালিকানার ধরন </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <select required name="inspection_period_id" id="inspection_period_id" class="form-control" size="1"
                                            title="অনুগ্রহ করে পিরিয়ড নাম বাছাই করুন">
                                            <option value="">পিরিয়ড নাম</option>
                                            @foreach($inspection_periods as $inspection_period)
                                            <option value="{{ $inspection_period->id}}"
                                                    {{ ( $inspection_period->id == $inspection_period_id) ? 'selected' : '' }}>
                                                    {{ $inspection_period->period_name}}</option>
                                            @endforeach
                                        </select>
                                        </td>

                                        <td>
                                            <select name="inspection_status" id="inspection_status" class="form-control" size="1"
                                                title="অনুগ্রহ করে ইন্সপেকশন স্ট্যাটাস বাছাই করুন">
                                                <option value=""> স্ট্যাটাস</option>
                                                <option value="যোগ্য" {{ ( $inspection_status == "যোগ্য") ? 'selected' : '' }}> যোগ্য</option>
                                                <option value="অযোগ্য" {{ ( $inspection_status == "অযোগ্য") ? 'selected' : '' }}> অযোগ্য</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="inactive_reason" id="inactive_reason" class="form-control" size="1"
                                                title="অনুগ্রহ করে অযোগ্যতার কারন বাছাই করুন">
                                                <option value=""> অযোগ্যতার কারন</option>
                                                @foreach($inactive_reasons as $inactivereason)
                                                <option value="{{ $inactivereason->reason_name}}"
                                                        {{ ( $inactivereason->reason_name == $inactive_reason) ? 'selected' : '' }}>
                                                        {{ $inactivereason->reason_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select name="cause_of_inspection" id="cause_of_inspection" class="form-control" size="1"
                                                title="অনুগ্রহ করে ইন্সপেকশনের কারণ বাছাই করুন">
                                                <option value="">ইইন্সপেকশনের কারণ</option>
                                                <option value="new_register" {{ ( $cause_of_inspection == "new_register") ? 'selected' : '' }}>নতুন নিবন্ধন</option>
                                                <option value="Scheduled" {{ ( $cause_of_inspection == "Scheduled") ? 'selected' : '' }}>শিডিউল চেক</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                                                        <option value="">বিভাগ</option>
                                                        @foreach($divisions as $division)
                                                        <option value="{{ $division->divid}}"
                                                        {{ ( $division->divid == $division_id) ? 'selected' : '' }}>
                                                        {{ $division->divname}}</option>
                                                        @endforeach
                                                </select>
                                            </td>

                                            <td><select name="district_id" id="district_id" class="form-control" size="1" title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                                <option value="">জেলা</option>
                                                @foreach($districts as $district)
                                                <option value="{{ $district->distid}}"{{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                                                @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="mill_upazila_id" id="mill_upazila_id" class="form-control" title="অনুগ্রহ করে  উপজেলা বাছাই করুন" >
                                                    <option value="">উপজেলা</option>
                                                    @foreach($upazillas as $upazilla)
                                                    <option value="{{ $upazilla->upazillaid}}"{{ ( $upazilla->upazillaid == $mill_upazila_id) ? 'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                           
                                            <td >
                                            <select name="owner_type" id="owner_type" class="form-control" size="1" title="অনুগ্রহ করে মালিকানার ধরন বাছাই করুন" onchange="">
                                                <option value="">মালিকানার ধরন</option>
                                                <option value="single" {{ ( $owner_type == "single") ? 'selected' : '' }}>একক</option>
                                                <option value="multi" {{ ( $owner_type == "multi") ? 'selected' : '' }}>যৌথ</option>
                                                <option value="corporate" {{ ( $owner_type == "corporate") ? 'selected' : '' }}>কর্পোরেট</option>
                                            </select>
                                            </td>
                                            <td style="padding-left:10px"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary"  value="ফলাফল"></td>

                                        </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                    <span style="color:red"> অবশ্যই কিছু বাছাই করতে হবে</span>
                </div>


                <div class="card-body mb-2">
                    <table id="table_id" class="table-bordered" cellpadding="5px" width="100%">

                        <thead>
                            <tr>
                            <th>চালকলের নাম</th>
                            <th>চালকলের ঠিকানা</th>
                            <th>মালিকের নাম</th>
                            <th>মালিকানার ধরন</th>
                            <th>চালকলের অবস্থা</th>
                            <th>ইন্সপেকশনের কারণ</th>
                            <th>ইন্সপেকশন স্ট্যাটাস</th>
                            <th>ইন্সপেকশন ডেট</th>
                            <th>পিরিয়ড নাম</th>
                            <th>ইন্সপেকশন রিপোর্ট</th>
                            <th>ইন্সপেকট</th>
                            <th>এপ্র্যুভ/রিটার্ন</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($millers as $miller)
                            <tr>
                                <td><span>{{$miller->mill_name}}</span></td>
                                <td><span>{{$miller->mill_address}}</span></td>
                                <td><span>{{$miller->owner_name}}</span></td>
                                <td><span>@if($miller->owner_type == "corporate") কর্পোরেট @elseif($miller->owner_type == "multi") যৌথ @else একক @endif</span></td>
                                <td><span>@if($miller->miller_status == "new_register") নতুন নিবন্ধন @elseif($miller->miller_status == "inactive") বন্ধ চালকল @else সচল চালকল @endif</span></td>
                                <td><span>@if($miller->cause_of_inspection == "new_register") নতুন নিবন্ধন @else শিডিউল চেক @endif</span></td>
                                <td><span>{{$miller->inspection_status}}</span></td>
                                <td><span>{{$miller->inspection_date}}</span></td>
                                <td><span>{{$miller->period_name}}</span></td>
                                <td>
                                    @if($miller->inspection_document != '')
                                        <a target="_blank" href="{{ asset('images/inspection_document/large/'.$miller->inspection_document) }}">
                                            রিপোর্ট দেখুন
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($miller->inspection_id)
                                        @if(DGFAuth::check2(1,  3))
                                            <a class="btn2 btn-primary" class="dropdown-item" href="{{ route('inspections.edit', $miller->inspection_id) }}">এডিট</a>
                                        @elseif(DGFAuth::check2(1,  2))
                                            <a class="btn2 btn-primary" class="dropdown-item" href="{{ route('inspections.edit', $miller->inspection_id) }}">ভিউ</a>
                                        @endif
                                    @else
                                        @if(DGFAuth::check2(1,  1))
                                            <a class="btn2 btn-primary" class="dropdown-item" href="{{ route('inspections.create')."?miller_id=".$miller->miller_id."&inspection_period_id=".$inspection_period_id}}">ইন্সপেকশন</a>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($miller->inspection_id)
                                        @if(DGFAuth::check2(1,  5))
                                            @if($miller->approval_status == "এপ্র্যুভড")
                                                <a class="btn btn-success" class="dropdown-item" href="{{ route('inspections.edit', $miller->inspection_id) }}">এপ্র্যুভড</a>
                                            @elseif($miller->approval_status == "রিটার্ন ফর ইন্সপেকশন")
                                                <a class="btn btn-danger" class="dropdown-item" href="{{ route('inspections.edit', $miller->inspection_id) }}">রিটার্ন ফর ইন্সপেকশন</a>
                                            @else
                                                <a class="btn btn-danger" class="dropdown-item" href="{{ route('inspections.edit', $miller->inspection_id) }}">এপ্র্যুভ/রিটার্ন</a>
                                            @endif
                                        @else
                                            @if($miller->approval_status == "এপ্র্যুভড")
                                                <span class="btn btn-success">এপ্র্যুভড</span>
                                            @elseif($miller->approval_status == "রিটার্ন ফর ইন্সপেকশন")
                                                <span class="btn btn-danger">রিটার্ন ফর ইন্সপেকশন</span>
                                            @else
                                                <span class="btn btn-danger">এপ্র্যুভ/রিটার্ন</span>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($millers) > 0)
                    <div class="print_hide pt-3">
                        {!! $millers->appends(\Request::except('page'))->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

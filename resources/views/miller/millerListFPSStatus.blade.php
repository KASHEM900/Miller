@extends('miller.layout')

@section('contentbody')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session()->has('message'))
            <div class="alert alert-success">
                {!! session()->get('message') !!}
            </div>
            @endif
            <div class="card">
                <div class="card-header text-2xl">মিলার স্ট্যাটাস ইন এফ পি এস সিস্টেম</div>
                <div class="p-3 flex justify-between">
                <form action="{{ route('millerListFPSStatus') }}">
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

                                    <td>উপজেলা:</td>
                                    <td>
                                        <select name="mill_upazila_id" id="mill_upazila_id" class="form-control" title="অনুগ্রহ করে  উপজেলা বাছাই করুন">
                                            <option value="">উপজেলা</option>
                                            @foreach($upazillas as $upazilla)
                                            <option value="{{ $upazilla->upazillaid}}"{{ ( $upazilla->upazillaid == $mill_upazila_id) ? 'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td><input maxlength="50" placeholder="অনুসন্ধান" type="text"
                                        name="searchtext" id="searchtext" class="form-control" value="{{$searchtext}}" /></td>
                                    
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                   

                                </tr>
                                <tr>
                                    <td>চালকলের অবস্থা:</td>
                                    <td>
                                        <select name="miller_status" id="miller_status" class="form-control" size="1"
                                            title="অনুগ্রহ করে চালকলের অবস্থা বাছাই করুন">
                                            <option value="">চালকলের অবস্থা</option>
                                            <option value="new_register" {{ ( $miller_status == "new_register") ? 'selected' : '' }}> নতুন নিবন্ধন</option>
                                            <option value="active" {{ ( $miller_status == "active") ? 'selected' : '' }}> সচল চালকল</option>
                                            <option value="inactive" {{ ( $miller_status == "inactive") ? 'selected' : '' }}> বন্ধ চালকল</option>
                                        </select>
                                    </td>

                                    <td>মিল মালিকের স্ট্যাটাস</td>
                                    <td>
                                        <select name="fps_mo_status" id="fps_mo_status" class="form-control" size="1"
                                            title="অনুগ্রহ করে তথ্য স্ট্যাটাস বাছাই করুন">
                                            <option value="">সিলেক্ট করুন</option>
                                            <option value="insert_success" {{ ( $fps_mo_status == "insert_success") ? 'selected' : '' }}>insert success</option>
                                            <option value="insert_fail" {{ ( $fps_mo_status == "insert_fail") ? 'selected' : '' }}>insert fail</option>
                                            <option value="update_success" {{ ( $fps_mo_status == "update_success") ? 'selected' : '' }}>update success</option>
                                            <option value="update_fail" {{ ( $fps_mo_status == "update_fail") ? 'selected' : '' }}>update fail</option>
                                            <option value="not_sent" {{ ( $fps_mo_status == "not_sent") ? 'selected' : '' }}>Not Sent</option>
                                        </select>
                                    </td>

                                    <td>চালকলের অবস্থা:</td>
                                    <td>
                                        <select name="fps_mill_status" id="fps_mill_status" class="form-control" size="1"
                                            title="অনুগ্রহ করে তথ্য স্ট্যাটাস বাছাই করুন">
                                            <option value="">সিলেক্ট করুন</option>
                                            <option value="insert_success" {{ ( $fps_mill_status == "insert_success") ? 'selected' : '' }}>insert success</option>
                                            <option value="insert_fail" {{ ( $fps_mill_status == "insert_fail") ? 'selected' : '' }}>insert fail</option>
                                            <option value="update_success" {{ ( $fps_mill_status == "update_success") ? 'selected' : '' }}>update success</option>
                                            <option value="update_fail" {{ ( $fps_mill_status == "update_fail") ? 'selected' : '' }}>update fail</option>
                                            <option value="not_sent" {{ ( $fps_mill_status == "not_sent") ? 'selected' : '' }}>Not Sent</option>
                                        </select>
                                    </td>

                                    <td colspan="2">
                                            
                                                <span class="modify-td">মালিকানার ধরণ:</span>
                                                <span class="modify-td">
                                                    <select class="modify-form-control" name="owner_type" id="owner_type"  size="1" title="অনুগ্রহ করে মালিকানার ধরন বাছাই করুন" onchange="">
                                                        <option value="">মালিকানার ধরণ</option>
                                                        <option value="single" {{ ( $owner_type == "single") ? 'selected' : '' }}>একক</option>
                                                        <option value="multi" {{ ( $owner_type == "multi") ? 'selected' : '' }}>যৌথ</option>
                                                        <option value="corporate" {{ ( $owner_type == "corporate") ? 'selected' : '' }}>কর্পোরেট</option>
                                                    </select>
                                                </span>
                                            
                                        </td>

                                    <td style="padding-left:10px"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary"  value="ফলাফল"></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>


            <div class="card-body mb-2">
                <table id="table_id" class="table-bordered" cellpadding="5px" width="100%">

                    <thead>
                        <tr>
                            <th width="7%">ফর্ম নং</th>
                            <th width="7%">জেলা</th>
                            <th width="7%">উপজেলা</th>
                            <th width="13%">মালিকের নাম	@sortablelink('owner_name', '')</th>
                            <th width="13%">মালিকানার ধরন @sortablelink('owner_type', '')</th>
                            <th width="5%">মিল মালিকের এনআইডি @sortablelink('nid_no', '')</th>
                            <th width="13%">মিল মালিকের স্ট্যাটাস</th>
                            <th width="13%">চালকলের নাম	@sortablelink('mill_name', '')</th>
                            <th width="13%">চালকলের ধরণ @sortablelink('milltype.mill_type_name', '')</th>
                            <th width="7%"> লাইসেন্স নম্বর @sortablelink('license_no', '')</th>
                            <th width="10%">চালকলের অবস্থা</th>
                            <th width="7%">অ্যাকশন</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($millers as $key => $miller)
                        <tr>
                            <td><span>{{$miller->form_no}}</span></td>
                            <td><span>{{$miller->district->distname}}</span></td>
                            <td><span>{{$miller->upazilla->upazillaname}}</span></td>
                            <td><span>{{$miller->owner_name}}</span></td>
                            <td><span>@if($miller->owner_type == "corporate") কর্পোরেট @elseif($miller->owner_type == "multi") যৌথ @else একক @endif</span></td>
                            <td><span>{{$miller->nid_no}}</span></td>
                            <td>
                                @if($miller->fps_mo_status != null)
                                    @if($miller->fps_mo_status == "insert_success" || $miller->fps_mo_status == "update_success")
                                        <span style="padding:4px; background-color:#83C89C;" class="btn-primary">{{$miller->fps_mo_status}}</span>
                                    @else
                                        <span style="padding:4px; background-color:#eb3a0a;" class="btn-primary">{{$miller->fps_mo_status}}</span>
                                    @endif
                                @else
                                    <span style="padding:4px; background-color:#f1a008;" class="btn-primary">Not Sent</span>
                                @endif
                                <br /><span>{{$miller->fps_mo_last_date}}</span>
                            </td>
                            <td><span>{{$miller->mill_name}}</span></td>
                            <td><span>@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif</span></td>
                            <td>
                                <span>{{$miller->license_no}}</span>
                            </td>
                            <td>
                                @if($miller->fps_mill_status != null)
                                    @if($miller->fps_mill_status == "insert_success" || $miller->fps_mill_status == "update_success")
                                        <span style="padding:4px; background-color:#83C89C;" class="btn-primary">{{$miller->fps_mill_status}}</span>
                                    @else
                                        <span style="padding:4px; background-color:#eb3a0a;" class="btn-primary">{{$miller->fps_mill_status}}</span>
                                    @endif
                                @else
                                    <span style="padding:4px; background-color:#f1a008;" class="btn-primary">Not Sent</span>
                                @endif
                                <br /><span>{{$miller->fps_mill_last_date}}</span>
                            </td>
                            <td>
                                <a href="millers.sendtofps?miller_id={{$miller->miller_id}}&division_id={{$division_id}}&district_id={{$district_id}}&mill_upazila_id={{$mill_upazila_id}}&miller_status={{$miller_status}}&fps_mo_status={{$fps_mo_status}}&fps_mill_status={{$fps_mill_status}}&searchtext={{$searchtext}}&page={{$page}}" class="btn2 btn-danger show_confirm">Send to FPS</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="print_hide pt-3">
                    {!! $millers->appends(\Request::except('page'))->render() !!}
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('.show_confirm').click(function(e) {
        if(!confirm("এফ পি এস সিস্টেমে তথ্য পাঠানোর পূর্বে অনুগ্রহ করে চালকলের লাইসেন্স নম্বর চেক করে নিন| একবার এফ পি এস সিস্টেমে তথ্য পাঠানোর পর, লাইসেন্স নম্বর পরিবর্তন করার কোনো সুযোগ নেই| আপনি কি এফ পি এস সিস্টেমে তথ্য পাঠাতে চান?")) {
            e.preventDefault();
        }
    });
</script>    

@endsection

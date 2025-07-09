@extends('miller.layout')

@section('contentbody')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl">@if($cmp_status == "0") অসম্পূর্ণ তথ্য @endif চালকল সমূহের তালিকা
                    <input type="button" id="chalkol_print" style="float: right;" class="btn btn-secondary" value="প্রিন্ট ফরম" onclick="printForms()">
                    <input type="button" id="chalkol_print" style="float: right;" class="btn btn-secondary" value="প্রিন্ট লাইসেন্স" onclick="printLicenseForms()">
                </div>

                @if ($message = Session::get('message'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="p-3 flex justify-between">
                <form action="{{ route('millers.list') }}">
                    @csrf
                    <div>
                        <table cellpadding="2px">
                            <tbody>
                                <tr>
                                    <td width="10%">বিভাগ:</td>
                                    <td width="15%">
                                        <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                                                <option value="">বিভাগ</option>
                                                @foreach($divisions as $division)
                                                <option value="{{ $division->divid}}"{{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                @endforeach
                                        </select>
                                    </td>

                                    <td width="10%">জেলা:</td>
                                    <td width="15%"><select name="district_id" id="district_id" class="form-control" size="1" title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                        <option value="">জেলা</option>
                                        @foreach($districts as $district)
                                        <option value="{{ $district->distid}}"{{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                                        @endforeach
                                        </select>
                                    </td>

                                    <td width="10%">উপজেলা:</td>
                                    <td width="15%">
                                        <select name="mill_upazila_id" id="mill_upazila_id" class="form-control" title="অনুগ্রহ করে  উপজেলা বাছাই করুন">
                                            <option value="">উপজেলা</option>
                                            @foreach($upazillas as $upazilla)
                                            <option value="{{ $upazilla->upazillaid}}"{{ ( $upazilla->upazillaid == $mill_upazila_id) ? 'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%">তথ্য স্ট্যাটাস:</td>
                                    <td width="15%">
                                        <select name="cmp_status" id="cmp_status" class="form-control" size="1"
                                            title="অনুগ্রহ করে তথ্য স্ট্যাটাস বাছাই করুন">
                                            <option value="">তথ্য স্ট্যাটাস</option>
                                            <option value="1" {{ ( $cmp_status == "1") ? 'selected' : '' }}>সম্পূর্ণ</option>
                                            <option value="0" {{ ( $cmp_status == "0") ? 'selected' : '' }}>অসম্পূর্ণ</option>
                                        </select>
                                    </td>


                                    <td style="padding-left:10px"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary"  value="ফলাফল"></td>

                                </tr>
                                <tr>
                                    <td width="10%">চালকলের ধরণ:</td>
                                    <td width="15%">
                                        <select name="mill_type_id" id="mill_type_id" class="form-control" title="অনুগ্রহ করে  চালকলের ধরন বাছাই করুন" onchange="">
                                            <option value="">চালকলের ধরন</option>

                                            @foreach($millTypes as $millType)
                                            <option value="{{ $millType->mill_type_id}}" {{ ( $millType->mill_type_id == $mill_type_id) ? 'selected' : '' }}>{{ $millType->mill_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td width="10%">চালকলের অবস্থা:</td>
                                    <td width="15%">
                                        <select name="miller_status" id="miller_status" class="form-control" size="1"
                                            title="অনুগ্রহ করে চালকলের অবস্থা বাছাই করুন">
                                            <option value="">চালকলের অবস্থা</option>
                                            <option value="new_register" {{ ( $miller_status == "new_register") ? 'selected' : '' }}> নতুন নিবন্ধন</option>
                                            <option value="active" {{ ( $miller_status == "active") ? 'selected' : '' }}> সচল চালকল</option>
                                            <option value="inactive" {{ ( $miller_status == "inactive") ? 'selected' : '' }}> বন্ধ চালকল</option>
                                        </select>
                                    </td>

                                    <td width="10%">মালিকানার ধরণ:</td>
                                    <td width="15%">
                                        <select name="owner_type" id="owner_type" class="form-control" size="1" title="অনুগ্রহ করে মালিকানার ধরন বাছাই করুন" onchange="">
                                            <option value="">মালিকানার ধরন</option>
                                            <option value="single" {{ ( $owner_type == "single") ? 'selected' : '' }}>একক</option>
                                            <option value="multi" {{ ( $owner_type == "multi") ? 'selected' : '' }}>যৌথ</option>
                                            <option value="corporate" {{ ( $owner_type == "corporate") ? 'selected' : '' }}>কর্পোরেট</option>
                                        </select>
                                    </td>

                                    <td width="15%">
                                        <select name="corporate_institute_id" id="corporate_institute_id" class="form-control" title="অনুগ্রহ করে কর্পোরেট বাছাই করুন">
                                            <option value="">কর্পোরেট</option>
                                            @foreach($corporate_institutes as $corporate)
                                            <option value="{{ $corporate->id}}"{{ ( $corporate->id == $corporate_institute_id) ? 'selected' : '' }}>{{ $corporate->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>


                                    <td><input maxlength="50" placeholder="অনুসন্ধান" type="text"
                                        name="searchtext" id="searchtext" class="form-control" value="{{$searchtext}}" /></td>


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
                            <th><input type="checkbox" id="select-all" name="selectAll" value=""/></th>
                            <th width="10%">ফর্ম নম্বর	@sortablelink('form_no', '')</th>
                            <th width="13%">মালিকানার ধরন @sortablelink('owner_type', '')</th>
                            <th width="13%">চালকলের নাম	@sortablelink('mill_name', '')</th>
                            <th width="13%">মালিকের নাম	@sortablelink('owner_name', '')</th>
                            <th>জেলা</th>
                            <th>উপজেলা</th>
                            <th width="10%">লাইসেন্স নম্বর	@sortablelink('license_no', '')</th>
                            <th width="10%">চালের ধরণ @sortablelink('chaltype.chal_type_name', '')	</th>
                            <th width="10%">চালকলের ধরণ @sortablelink('milltype.mill_type_name', '')</th>
                            <!--<th width="10%">পাক্ষিক ক্ষমতা(ধান) @sortablelink('millar_p_power', '') </th>-->
                            <th width="10%">পাক্ষিক ক্ষমতা(চাল)@sortablelink('millar_p_power_chal', '') </th>
                            <th width="10%">চালকলের অবস্থা</th>
                            <th>তথ্য স্ট্যাটাস</th>
                            @if(DGFAuth::check(4020, 1,  3))
                            <th>এডিট</th>
                            @endif
                            @if(DGFAuth::check(4010, 1,  4))
                            <th>ডিলিট</th>
                            @endif
                            <th>হালনাগাদকৃত অটোমেটিক</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($millers as $key => $miller)
                        <tr>
                            <td><span><input type="checkbox" name="selected_id" value="{{$miller->miller_id}}" /></span></td>
                            <td>
                                <span>{{App\BanglaConverter::en2bt($miller->form_no)}}</span>
                            </td>
                            <td><span>@if($miller->owner_type == "corporate") কর্পোরেট @elseif($miller->owner_type == "multi") যৌথ @else একক @endif</span></td>
                            <td><span>{{$miller->mill_name}}</span></td>
                            <td><span>{{$miller->owner_name}}</span></td>
                            <td><span>{{$miller->district->distname}}</span></td>
                            <td><span>{{$miller->upazilla->upazillaname}}</span></td>
                            <td>
                                <span>{{$miller->license_no}}</span>
                                <br />
                                @if(DGFAuth::check(4020, 1, 3))
                                    <a style="padding:4px; background-color:#83C89C;" class="btn2 btn-primary" class="dropdown-item" href="{{ route('millers.edit', $miller->miller_id) }}?option=licenseonly">নবা/ডুপ্লি/নতুন</a>
                                @endif
                            </td>
                            <td><span>@if($miller->chaltype){{$miller->chaltype->chal_type_name}}@endif</span></td>
                            <td><span>@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif</span></td>
                            <!--<td><span>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power)}}</span></td>-->
                            <td><span>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}}</span></td>
                            <td>
                            <b>@if($miller->miller_status == "new_register") নতুন নিবন্ধন @elseif($miller->miller_status == "inactive") বন্ধ চালকল @else সচল চালকল @endif</b>
                            <br/>
                                @if($miller->last_inactive_reason)
                                <span>({{$miller->last_inactive_reason}})</span>
                                @endif
                            </td>
                            <td><span>@if($miller->cmp_status == 1) সম্পূর্ণ @else অসম্পূর্ণ @endif</span></td>
                            @if(DGFAuth::check(4020, 1,  3))
                            <td>
                                <a class="btn2 btn-primary" class="dropdown-item" href="{{ route('millers.edit',$miller->miller_id) }}">এডিট</a>
                            </td>
                            @elseif(DGFAuth::check(4020, 1,  2))
                            <td>
                                <a class="btn2 btn-primary" class="dropdown-item" href="{{ route('millers.edit',$miller->miller_id) }}">ভিউ</a>
                            </td>
                            @endif
                            @if(DGFAuth::check(4010, 1,  4))
                                <td>
                                    <span class="btn2 btn-danger" onclick="event.preventDefault();
                                        if(confirm('Are you really want to delete?')){
                                        document.getElementById('form-delete-{{$miller->miller_id}}')
                                        .submit()
                                    }">ডিলিট</span>
                                    <form id="{{'form-delete-'.$miller->miller_id}}" method="post" action="{{route('millers.destroy',$miller->miller_id)}}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            @endif
                            @if($miller->mill_type_id == "2")
                            <td>
                                <a href="../../millers.moveToHalnagadAutometic?miller_id={{$miller->miller_id}}" class="btn2 btn-info">ট্রান্সফার</a>
                            </td>
                            @endif
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

@endsection

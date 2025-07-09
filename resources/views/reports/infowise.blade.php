@extends('reports.layout')

@section('contentbody')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" id="miller_list">
                <div class="card-header text-2xl">
                    <span class="print_hide" style="float: left;">
                        তথ্য অনুযায়ী চালকলের সমূহের তালিকা
                    </span>
                    <form action="{{ route('exportinfowise') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="division_id"  value="{{$division_id}}">
                        <input type="hidden" name="district_id"  value="{{$district_id}}">
                        <input type="hidden" name="cmp_status"  value="{{$cmp_status}}">

                        <span class="print_hide" style="float: right;">
                            <input type="button" class="btn btn-secondary" value="প্রিন্ট করুন" onclick="printInfoWiseReport()" />
                            <input type="submit" class="btn btn-secondary" value="Export">
                        </span>
                   </form>
                </div>
                <div class="p-3 flex justify-between">

                    <form action="{{ route('infowise') }}">
                        @csrf
                        <div>
                            <table cellpadding="2px">
                                <tbody>
                                    <tr>

                                        <td><input maxlength="50" placeholder="অনুসন্ধান" type="text"
                                            name="searchtext" id="searchtext" class="form-control" value="{{$searchtext}}" /></td>

                                        <td>বিভাগ</td>
                                        <td>:</td>
                                        <td>
                                            <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                                                    <option value="">বিভাগ</option>
                                                    @foreach($divisions as $division)
                                                    <option value="{{ $division->divid}}" {{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td> জেলা</td>
                                        <td>:</td>
                                        <td>
                                            <select name="district_id" id="district_id"
                                            class="form-control" size="1"
                                            title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                            <option value="">জেলা</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->distid}}"
                                                {{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td> চালকলের তথ্য</td>
                                        <td>:</td>
                                        <td>
                                            <select name="cmp_status" id="cmp_status" class="form-control" size="1"
                                            title="অনুগ্রহ করে তথ্য স্ট্যাটাস বাছাই করুন">
                                                <option value="">তথ্য স্ট্যাটাস</option>
                                                <option value="1" {{ ( $cmp_status == "1") ? 'selected' : '' }}>সম্পূর্ণ</option>
                                                <option value="0" {{ ( $cmp_status == "0") ? 'selected' : '' }}>অসম্পূর্ণ</option>
                                            </select>
                                        </td>

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
                                        <td class="print_hide" style="padding-left:10px"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary" value="ফলাফল"></td>

                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            
                                                <span>মালিকানার ধরণ:</span>
                                                <span >
                                                    <select class="modify-form-control" name="owner_type" id="owner_type"  size="1" title="অনুগ্রহ করে মালিকানার ধরন বাছাই করুন" onchange="">
                                                        <option value="">মালিকানার ধরণ</option>
                                                        <option value="single" {{ ( $owner_type == "single") ? 'selected' : '' }}>একক</option>
                                                        <option value="multi" {{ ( $owner_type == "multi") ? 'selected' : '' }}>যৌথ</option>
                                                        <option value="corporate" {{ ( $owner_type == "corporate") ? 'selected' : '' }}>কর্পোরেট</option>
                                                    </select>
                                                </span>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>

                </div>
                <span style="color:red"> বিভাগ, জেলা ও চালকলের তথ্য বাছাই করতে হবে</span>

                <div class="card-header flex justify-between">
                    <span>চালকলের তথ্য</span>
                </div>

                <div class="card-body">
                    <table id="table_id" class="table table-bordered" cellspacing="0" width="100%">

                        <thead>
                            <tr>
                                <th>ক্রমিক নং</th>
                                <th width="7%">ফর্ম নম্বর	@sortablelink('form_no', '')</th>
                                <th width="10%">চালকলের নাম @sortablelink('mill_name', '')	</th>
                                <th width="10%">মালিকের নাম @sortablelink('owner_name', '')	</th>
                                <th width="13%">মালিকানার ধরন @sortablelink('owner_type', '')</th>
                                <th width="9%">মোবাইল @sortablelink('mobile_no', '')	</th>
                                <th width="11%">লাইসেন্স নম্বর @sortablelink('license_no', '')	</th>
                                <th width="12%">চালকলের ধরণ @sortablelink('milltype.mill_type_name', '')	</th>
                                <th width="9%">চালের ধরণ @sortablelink('chaltype.chal_type_name', '')</th>
                                <!--<th width="10%">পাক্ষিক ক্ষমতা(ধান) @sortablelink('millar_p_power', '') </th>-->
                                <th width="9%">পাক্ষিক ক্ষমতা(চাল)@sortablelink('millar_p_power_chal', '') </th>
                                <th width="8%">উপজেলা @sortablelink('upazilla.upazillaname', '')</th>
                                <th width="8%">জেলা @sortablelink('district.distname', '')</th>
                                <th width="9%">তথ্য স্ট্যাটাস @sortablelink('cmp_status', '')</th>
                                <th width="11%">চালকলের অবস্থা</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $count = 1; ?>
                            @foreach($millers as $key => $miller)
                            <tr>
                                <td style="text-align: center;"><span>{{App\BanglaConverter::en2bn(0, $count)}}</span></td>
                                <td>
                                    <span>{{App\BanglaConverter::en2bt($miller->form_no)}}</span>
                                </td>
                                <td><span>{{$miller->mill_name}}</span></td>
                                <td><span>{{$miller->owner_name}}</span></td>
                                <td><span>@if($miller->owner_type == "corporate") কর্পোরেট @elseif($miller->owner_type == "multi") যৌথ @else একক @endif</span></td>
                                <td><span>{{$miller->mobile_no}}</span></td>
                                <td><span>{{$miller->license_no}}</span></td>
                                <td><span>{{($miller->mill_type_id>0)? $miller->milltype->mill_type_name : ''}}</span></td>
                                <td><span>@if($miller->chaltype){{$miller->chaltype->chal_type_name}}@endif</span></td>
                                <!--<td style="text-align: center;"><span>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power)}}</span></td>-->
                                <td style="text-align: center;"><span>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}}</span></td>
                                <td><span>{{($miller->mill_upazila_id)? $miller->upazilla->upazillaname : ""}}</span></td>
                                <td><span>{{$miller->district->distname}}</span></td>
                                <td><span>@if($miller->cmp_status == 1) সম্পূর্ণ @else অসম্পূর্ণ @endif</span></td>
                                <td><span>@if($miller->miller_status == "new_register") নতুন নিবন্ধন @elseif($miller->miller_status == "inactive") বন্ধ চালকল @else সচল চালকল @endif</span></td>
                            </tr>
                            <?php $count ++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="print_hide">
                    {!! $millers->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

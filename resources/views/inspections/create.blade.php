@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div style="float:right">
                <a class="btn btn-primary" href="{{ route('inspections.index') }}?page={{$pp_page}}&inspection_period_id={{$pp_inspection_period}}&inspection_status={{$pp_inspection_status}}&cause_of_inspection={{$pp_cause_of_inspection}}&division_id={{$pp_division}}&district_id={{$pp_district}}&mill_upazila_id={{$pp_mill_upazila}}">আগের পৃষ্ঠা</a>
            </div>
            <div id="form_margin" class="form_page">
                <h2 align="center">@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif
                    চালকলের মিলিং ক্ষমতা নির্ণয় ফরম
                </h2>
                <h4>
                    <span class="px-5 pt-2 flex justify-between">
                        <span><b>ইন্সপেকশন পিরিয়ডঃ</b> {{$inspection_period_name}}</span>
                        <span><b>ইন্সপেকশনের কারনঃ</b> {{$cause_of_inspection}}</span>
                    </span>
                </h4>

                <div id="chalkol_div">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                        <strong>দুঃখিত!</strong> আপনার এন্ট্রি করতে কোনো সমস্যা হয়েছে|<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="inspectionform" action="{{ route('inspections.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="miller_id" value="{{$miller->miller_id}}"/>
                        <input type="hidden" name="inspection_by" value="1"/>
                        <fieldset id="chalkol_preview" style="display:block;">
                            <div class="card">

                            <div class="card-header flex justify-between">
                                <span class="text-xl"> <b>চালকলের তথ্য  </b> ফরম নম্বর: {{App\BanglaConverter::en2bt($miller->form_no)}} </span>

                            </div>

                            <div class="card-body">

                                <table width="100%" align="center" class="miller_inspect report_fontsize">
                                <tbody>
                                <tr>

                                    <td width="20%">মালিকানার ধরন</td>

                                    <td><strong>:</strong></td>

                                    <td width="20%">
                                        {{$miller->owner_type}}
                                    </td>

                                    <td>ঠিক নাকি ভূল?</td>

                                    <td><strong>:</strong></td>

                                    <td><input type="radio" name="owner_type_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp; <input type="radio" name="owner_type_status" value="0">&nbsp;ভূল </td>

                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                    <td><strong>:</strong></td>

                                    <td><textarea maxlength="200" name="owner_type_comment" class="form-control" value=""></textarea></td>
                                    </tr>

                                    <tr>

                                    <td width="20%">কর্পোরেট প্রতিষ্ঠান</td>

                                    <td><strong>:</strong></td>

                                    <td width="20%">
                                     {{ $miller->corporate_institute->name ?? '' }}

                                    </td>

                                    <td>ঠিক নাকি ভূল?</td>

                                    <td><strong>:</strong></td>

                                    <td><input type="radio" name="corporate_institute_id_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp; <input type="radio" name="corporate_institute_id_status" value="0">&nbsp;ভূল </td>

                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                    <td><strong>:</strong></td>

                                    <td><textarea maxlength="200" name="corporate_institute_id_comment" class="form-control" value=""></textarea></td>
                                    </tr>

                                    <tr>

                                    <td width="20%">চালকল মালিকের ছবি</td>

                                    <td><strong>:</strong></td>

                                    <td width="20%">
                                        @if($miller->photo_of_miller != '')
                                        <a target="_blank" href="{{ asset('images/photo_file/large/'.$miller->photo_of_miller) }}">
                                            <img width="100" height="100" src="{{ asset('images/photo_file/thumb/'.$miller->photo_of_miller) }}" alt="{{$miller->mill_name}}"/>
                                        </a>
                                        @endif
                                    </td>

                                    <td>ঠিক নাকি ভূল?</td>

                                    <td><strong>:</strong></td>

                                    <td><input type="radio" name="photo_of_miller_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp; <input type="radio" name="photo_of_miller_status" value="0">&nbsp;ভূল </td>

                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                    <td><strong>:</strong></td>

                                    <td><textarea maxlength="200" name="photo_of_miller_comment" class="form-control" value=""></textarea></td>
                                    </tr>

                                    <tr>

                                        <td>বিভাগ</td>

                                        <td><strong>:</strong> </td>

                                        <td>

                                            {{$miller->division->divname}}

                                        </td>

                                    </tr>
                                    <tr style="background-color: transparent">

                                        <td>জেলা</td>

                                        <td><strong>:</strong></td>

                                        <td>

                                            {{$miller->district->distname}}

                                        </td>

                                    </tr>

                                    <tr>

                                        <td>উপজেলা</td>

                                        <td><strong>:</strong></td>

                                        <td>

                                            {{$miller->upazilla->upazillaname}}

                                        </td>

                                    </tr>

                                    <tr>

                                        <td>চালকলের নাম</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->mill_name}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="mill_name_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="mill_name_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="mill_name_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>চালকলের ঠিকানা</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->mill_address}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="mill_address_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="mill_address_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="mill_address_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>মালিকের নাম</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->owner_name}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="owner_name_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="owner_name_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="owner_name_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>মালিকের ঠিকানা</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->owner_address}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="owner_address_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="owner_address_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="owner_address_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>মালিকের জন্মস্থান</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->miller_birth_place}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="miller_birth_place" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="miller_birth_place" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="miller_birth_place_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>মালিকের জাতীয়তা</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->miller_nationality}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="miller_nationality" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="miller_nationality" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="miller_nationality_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                     <tr>

                                        <td>মালিকের ধর্ম</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->miller_religion}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="miller_religion" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="miller_religion" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="miller_religion_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>মোবাইল নং</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->mobile_no}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="mobile_no_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="mobile_no_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="mobile_no_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>ব্যাংক একাউন্ট</td>

                                        <td><strong>:</strong></td>

                                        <td>একাউন্ট নংঃ {{$miller->bank_account_no}}, একাউন্ট নামঃ {{$miller->bank_account_name}}, ব্যাংকের নামঃ {{$miller->bank_name}} ব্যাংকের শাখার নামঃ {{$miller->bank_branch_name}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="bank_account_no_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="bank_account_no_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="bank_account_no_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>মিল মালিকের এনআইডি</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->nid_no}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="nid_no_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="nid_no_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="nid_no_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>ইনকাম ট্যাক্স এর ডকুমেন্ট</td>

                                        <td><strong>:</strong></td>

                                        <td>
                                            @if($miller->tax_file_of_miller != '')
                                            <a target="_blank" href="{{ asset('images/tax_file/large/'.$miller->tax_file_of_miller) }}">
                                                <img width="100" height="100" src="{{ asset('images/tax_file/thumb/'.$miller->tax_file_of_miller) }}" alt="{{$miller->mill_name}}"/>
                                            </a>
                                            @endif
                                        </td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="tax_file_of_miller_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="tax_file_of_miller_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="tax_file_of_miller_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>চালের ধরন</td>

                                        <td><strong>:</strong></td>

                                        <td>@if($miller->chaltype) {{$miller->chaltype->chal_type_name}} @endif</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="chal_type_name_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="chal_type_name_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="chal_type_name_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>চালকলের ধরন</td>

                                        <td><strong>:</strong></td>

                                        <td>@if($miller->milltype) {{$miller->milltype->mill_type_name}} @endif</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="mill_type_name_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="mill_type_name_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="mill_type_name_comment" class="form-control" value=""></textarea></td>

                                    </tr>



                                </tbody>
                                </table>

                            </div>
                            </div>
                        </fieldset>

                        @if($miller->mill_type_id==2)

                            <fieldset id="license_preview" style="display:block;">
                                <div class="card">

                                <div class="card-header flex justify-between">
                                    <span class="text-xl"> <b>লাইসেন্স   এর  তথ্য <span style="color: gray;"> ( বাংলায়  পূরণ করুন )</span></b></span>
                                </div>

                                <div class="card-body">

                                    <table width="100%" align="center" class="miller_inspect report_fontsize">

                                    <tbody>
                                    <tr>

                                        <td width="20%">লাইসেন্স নং</td>

                                        <td><strong>:</strong></td>

                                        <td width="20%">{{$miller->license_no}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="license_no_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="license_no_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="license_no_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>লাইসেন্সের কপি</td>

                                        <td><strong>:</strong></td>

                                        <td>
                                            @if($miller->license_file_of_miller != '')
                                            <a target="_blank" href="{{ asset('images/license_file/large/'.$miller->license_file_of_miller) }}">
                                                <img width="100" height="100" src="{{ asset('images/license_file/thumb/'.$miller->license_file_of_miller) }}" alt="{{$miller->mill_name}}"/>
                                            </a>
                                            @endif
                                        </td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="license_file_of_miller_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="license_file_of_miller_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="license_file_of_miller_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>লাইসেন্স প্রদানের তারিখ</td>

                                        <td><strong>:</strong></td>

                                        <td>{{$miller->date_license}}</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="date_license_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="date_license_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="date_license_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>মিল স্থাপনের বছর</td>

                                        <td><strong>:</strong></td>

                                        <td>@if($miller->autometic_miller){{$miller->autometic_miller->pro_flowdiagram}}@endif</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="pro_flowdiagram_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="pro_flowdiagram_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="pro_flowdiagram_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                    <tr>

                                        <td>কান্ট্রি অব অরিজিন </td>

                                        <td><strong>:</strong> </td>

                                        <td>@if($miller->autometic_miller){{$miller->autometic_miller->origin}}@endif</td>

                                        <td>ঠিক নাকি ভূল?</td>

                                        <td><strong>:</strong></td>

                                        <td><input type="radio" name="origin_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="origin_status" value="0">&nbsp;ভূল </td>

                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                        <td><strong>:</strong></td>

                                        <td><textarea maxlength="200" name="origin_comment" class="form-control" value=""></textarea></td>

                                    </tr>

                                <tr>

                                        <td>পরিদর্শনের তারিখ</td>

                                        <td><strong>:</strong> </td>

                                        <td>@if($miller->autometic_miller){{$miller->autometic_miller->visited_date}}@endif</td>

                                    </tr>



                                    </tbody></table>

                                    </div>
                                </div>
                            </fieldset>

                            <fieldset id="autometic_mechin_preview" style="display:block;">
                                <div class="card">

                                    <div class="card-header flex justify-between">
                                        <span class="text-xl"> <b>যন্ত্রপাতির বিবরণ </b></span>
                                    </div>

                                    <div class="card-body">

                                        <table width="100%" align="center" class="miller_inspect report_fontsize">

                                            <tbody><tr>

                                            <td>ক)</td>

                                            <td><strong>:</strong></td>

                                            <td width="35%">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_a}}@endif</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="machineries_a_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="machineries_a_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="machineries_a_comment" class="form-control" value=""></textarea></td>

                                            </tr>

                                        <tr> <td colspan="3" align="right" id="errorMsgMachi"></td></tr>

                                        <tr>

                                            <td>খ)</td>

                                            <td><strong>:</strong></td>

                                            <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_b}}@endif </td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="machineries_b_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="machineries_b_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="machineries_b_comment" class="form-control" value=""></textarea></td>

                                            </tr>

                                        <tr>

                                            <td>গ)</td>

                                            <td><strong>:</strong></td>

                                            <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_c}}@endif </td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="machineries_c_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="machineries_c_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="machineries_c_comment" class="form-control" value=""></textarea></td>

                                            </tr>

                                        <tr>

                                            <td>ঘ)</td>

                                            <td><strong>:</strong></td>

                                            <td> @if($miller->autometic_miller){{$miller->autometic_miller->machineries_d}}@endif</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="machineries_d_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="machineries_d_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="machineries_d_comment" class="form-control" value=""></textarea></td>

                                            </tr>

                                        <tr>

                                            <td>ঙ)</td>

                                            <td><strong>:</strong></td>

                                            <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_e}}@endif</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="machineries_e_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="machineries_e_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="machineries_e_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>চ)</td>

                                            <td><strong>:</strong></td>

                                            <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_f}}@endif </td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="machineries_f_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="machineries_f_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="machineries_f_comment" class="form-control" value=""></textarea></td>

                                        </tr>



                                    </tbody></table>

                                </div>
                                </div>
                            </fieldset>

                            <fieldset id="auto_para_preview" style="display:block;">
                                <div class="card">

                                    <div class="card-header flex justify-between">
                                        <span class="text-xl"> <b>যন্ত্রপাতির বিবরণ </b></span>
                                    </div>

                                    <div class="card-body">
                                        <table width="100%" align="center" id="param_table" class="miller_inspect report_fontsize">

                                                <tbody><tr>

                                                    <td width="5%">ক্রঃ নং</td>

                                                    <td width="20%" align="center">প্যারামিটার এর নাম</td>

                                                    <td width="5%" align="center">সংখ্যা</td>

                                                    <td width="5%" align="center">একক ক্ষমতা</td>

                                                    <td width="5%" align="center">মোট ক্ষমতা</td>

                                                    <td colspan="6"></td>
                                                    </tr>

                                                    <tr>

                                                    <td width="5%">০১.</td>

                                                    <td> {{$miller->autometic_miller->parameter1_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter1_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter1_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter1_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter1_name_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter1_name_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter1_name_comment" class="form-control" value=""></textarea></td>

                                                </tr>


                                                <tr>

                                                    <td width="5%">০২.</td>

                                                    <td> {{$miller->autometic_miller->parameter2_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter2_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter2_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter2_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter2_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter2_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter2_num_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>



                                                    <tr>

                                                    <td width="5%">০৩.</td>

                                                    <td> {{$miller->autometic_miller->parameter3_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter3_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter3_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter3_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter3_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter3_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter3_num_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>



                                                    <tr>

                                                    <td width="5%">০৪.</td>

                                                    <td> {{$miller->autometic_miller->parameter4_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter4_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter4_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter4_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter4_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter4_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter4_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">০৫.</td>

                                                    <td> {{$miller->autometic_miller->parameter5_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter5_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter5_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter5_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter5_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter5_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter5_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">০৬.</td>

                                                    <td> {{$miller->autometic_miller->parameter6_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter6_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter6_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter6_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter6_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter6_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter6_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                        <td width="5%">০৭.</td>

                                                        <td> {{$miller->autometic_miller->parameter7_name}}</td>

                                                        <td align="center">{{$miller->autometic_miller->parameter7_num}}</td>

                                                        <td align="center">{{$miller->autometic_miller->parameter7_power}}</td>

                                                        <td align="center">{{$miller->autometic_miller->parameter7_topower}}</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="parameter7_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter7_num_status" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="parameter7_num_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>



                                                    <tr>

                                                    <td width="5%">০৮.</td>

                                                    <td> {{$miller->autometic_miller->parameter8_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter8_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter8_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter8_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter8_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter8_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter8_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">০৯.</td>

                                                    <td> {{$miller->autometic_miller->parameter9_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter9_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter9_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter9_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter9_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter9_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter9_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১০.</td>

                                                    <td> {{$miller->autometic_miller->parameter10_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter10_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter10_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter10_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter10_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter10_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter10_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>





                                                    <tr>

                                                    <td width="5%">১১.</td>

                                                    <td> {{$miller->autometic_miller->parameter11_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter11_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter11_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter11_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter11_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter11_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter11_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১২.</td>

                                                    <td> {{$miller->autometic_miller->parameter12_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter12_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter12_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter12_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter12_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter12_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter12_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১৩.</td>

                                                    <td> {{$miller->autometic_miller->parameter13_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter13_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter13_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter13_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter13_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter13_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter13_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১৪.</td>

                                                    <td> {{$miller->autometic_miller->parameter14_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter14_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter14_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter14_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter14_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter14_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter14_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১৫.</td>

                                                    <td> {{$miller->autometic_miller->parameter15_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter15_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter15_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter15_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter15_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter15_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter15_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১৬.</td>

                                                    <td> {{$miller->autometic_miller->parameter16_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter16_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter16_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter16_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter16_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter16_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter16_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১৭.</td>

                                                    <td> {{$miller->autometic_miller->parameter17_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter17_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter17_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter17_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter17_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter17_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter17_num_comment" class="form-control" value=""></textarea></td>

                                                                </tr>



                                                    <tr>

                                                    <td width="5%">১৮.</td>

                                                    <td> {{$miller->autometic_miller->parameter18_name}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter18_num}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter18_power}}</td>

                                                    <td align="center">{{$miller->autometic_miller->parameter18_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter18_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter18_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter18_num_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>

                                                    <tr>

                                                    <td width="5%">১৯.</td>

                                                    <td> {{$miller->autometic_miller->parameter19_name}}</td>

                                                    <td colspan="3" align="center">{{$miller->autometic_miller->parameter19_topower}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="parameter19_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="parameter19_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="parameter19_num_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>



                                                    </tbody></table>

                                            </div>
                                </div>
                            </fieldset>

                            <fieldset id="auto_p_power_preview" style="display:block;">
                                <div class="card">

                                    <div class="card-header flex justify-between">
                                        <span class="text-xl"> <b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></span>
                                    </div>

                                    <div class="card-body">

                                    <table width="100%" align="center" class="miller_inspect report_fontsize">

                                    <tbody><tr>

                                    <td width="20%"><b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></td>

                                    <td>: </td>

                                    <td width="20%"><b> {{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}}  মেট্টিক টন চাল</b></td>

                                    <td>ঠিক নাকি ভূল?</td>

                                    <td><strong>:</strong></td>

                                    <td><input type="radio" name="millar_p_power_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="millar_p_power_status" value="0">&nbsp;ভূল </td>

                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                    <td><strong>:</strong></td>

                                    <td><textarea maxlength="200" name="millar_p_power_comment" class="form-control" value=""></textarea></td>

                                </tr>
                                    <tr>
                                        <td><br /><br /></td>
                                    </tr>

                                    </tbody></table>

                                    </div>
                                </div>
                            </fieldset>

                        @else

                            <fieldset id="license_preview" style="display:block;">
                                <div class="card">

                                    <div class="card-header flex justify-between">
                                        <span class="text-xl"> <b>লাইসেন্স  ও বিদ্যুৎ এর  তথ্য </b></span>
                                    </div>

                                    <div class="card-body">

                                    <table width="100%" align="center" class="miller_inspect report_fontsize">

                                        <tbody>
                                        <tr>

                                            <td width="20%">লাইসেন্স নং</td>

                                            <td><strong>:</strong></td>

                                            <td width="20%">{{$miller->license_no}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="license_no_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="license_no_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="license_no_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>লাইসেন্সের কপি</td>

                                            <td><strong>:</strong></td>

                                            <td>
                                                @if($miller->license_file_of_miller != '')
                                                <a target="_blank" href="{{ asset('images/license_file/large/'.$miller->license_file_of_miller) }}">
                                                    <img width="100" height="100" src="{{ asset('images/license_file/thumb/'.$miller->license_file_of_miller) }}" alt="{{$miller->mill_name}}"/>
                                                </a>
                                                @endif
                                            </td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="license_file_of_miller_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="license_file_of_miller_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="license_file_of_miller_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>লাইসেন্স প্রদানের তারিখ</td>

                                            <td><strong>:</strong></td>

                                            <td><font>{{$miller->date_license}}</font></td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="date_license_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="date_license_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="date_license_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত </td>

                                            <td><strong>:</strong> </td>

                                            <td>{{$miller->date_renewal}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="date_renewal_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="date_renewal_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="date_renewal_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>লাইসেন্স সর্বশেষ নবায়ণের তারিখ </td>

                                            <td><strong>:</strong> </td>

                                            <td>{{$miller->date_last_renewal}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="date_last_renewal_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="date_last_renewal_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট</td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="date_last_renewal_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>বিদ্যুৎ সংযোগ আছে কিনা </td>

                                            <td><strong>:</strong> </td>

                                            <td>{{$miller->is_electricity}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="is_electricity_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="is_electricity_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="is_electricity_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>মিটার নং	</td>

                                            <td><strong>:</strong> </td>

                                            <td>{{$miller->meter_no}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="meter_no_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="meter_no_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="meter_no_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>বিদ্যুৎ সংযোগ এর ডকুমেন্ট</td>

                                            <td><strong>:</strong></td>

                                            <td>
                                                @if($miller->electricity_file_of_miller != '')
                                                <a target="_blank" href="{{ asset('images/electricity_file/large/'.$miller->electricity_file_of_miller) }}">
                                                    <img width="100" height="100" src="{{ asset('images/electricity_file/thumb/'.$miller->electricity_file_of_miller) }}" alt="{{$miller->mill_name}}"/>
                                                </a>
                                                @endif
                                            </td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="electricity_file_of_miller_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="electricity_file_of_miller_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="electricity_file_of_miller_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>সর্বশেষ যে মাস পর্যন্ত বিদ্যুৎ বিল পরিশোধ করা হয়েছে</td>

                                            <td><strong>:</strong></td>

                                            <td>{{$miller->last_billing_month}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="last_billing_month_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="last_billing_month_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="last_billing_month_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>বিদ্যুৎ সংযোগের অনুমতিপত্র অনুযায়ী সর্ব নিন্ম বৈদ্যুতিক লোডিং ক্ষমতা</td>

                                            <td><strong>:</strong></td>

                                            <td>{{$miller->min_load_capacity}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="min_load_capacity_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="min_load_capacity_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="min_load_capacity_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>বিদ্যুৎ সংযোগের অনুমতিপত্র অনুযায়ী  সর্ব উচ্চ বৈদ্যুতিক লোডিং ক্ষমতা</td>

                                            <td><strong>:</strong></td>

                                            <td>{{$miller->max_load_capacity}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="max_load_capacity_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="max_load_capacity_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="max_load_capacity_comment" class="form-control" value=""></textarea></td>

                                        </tr>

                                        <tr>

                                            <td>পরিশোধিত মাসিক গড় বিলের পরিমাণ  (টাকা)</td>

                                            <td><strong>:</strong></td>

                                            <td>{{$miller->paid_avg_bill}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="paid_avg_bill_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="paid_avg_bill_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="paid_avg_bill_comment" class="form-control" value=""></textarea></td>

                                        </tr>



                                        </tbody>

                                        </table>
                                    </div>
                                </div>

                            </fieldset>

                            @if($miller->mill_type_id!=1 && $miller->mill_type_id!=5)

                                <fieldset id="boiller_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"><b>বয়লারের তথ্য </b> </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center" class="miller_inspect report_fontsize">

                                                <tbody>
                                                    <tr>

                                                        <td width="20%">বয়লারের সংখ্যা </td>

                                                        <td>:</td>

                                                        <td width="20%">{{$miller->boiller_num}}</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="boiller_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="boiller_num_status" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="boiller_num_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>

                                                    <tr>

                                                        <td>বয়লারে স্বয়ংক্রিয় সেফটি ভালভ আছে কিনা ?</td>

                                                        <td>:</td>

                                                        <td>{{$miller->is_safty_vulve}}</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="is_safty_vulve_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="is_safty_vulve_status" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="is_safty_vulve_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>

                                                    <tr>

                                                        <td>বয়লারে চাপমাপক যন্ত্র আছে কিনা ?</td>

                                                        <td>:</td>

                                                        <td>{{$miller->is_presser_machine}}</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="is_presser_machine_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="is_presser_machine_status" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="is_presser_machine_comment" class="form-control" value=""></textarea></td>

                                                                    </tr>



                                                </tbody>
                                            </table>

                                    </div>
                                    </div>
                                </fieldset>

                                <fieldset id="chimni_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"><b>চিমনীর তথ্য</b> </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center" class="miller_inspect report_fontsize">

                                                    <tbody><tr>

                                                        <td width="20%">চিমনীর উচ্চতা (মিটার) </td>

                                                        <td>:</td>

                                                        <td width="20%">{{$miller->chimney_height}} মিটার</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="chimney_height_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="chimney_height_status" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="chimney_height_comment" class="form-control" value=""></textarea></td>

                                                                        </tr>



                                                    </tbody>

                                                </table>

                                        </div>
                                    </div>
                                </fieldset>

                            @endif

                            @if($miller->mill_type_id==5)

                                <fieldset id="milling_unit_machineries_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"> <b>মিলিং ইউনিটের যন্ত্রপাতির বিবরণ</b></span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center">
                                                <tbody>

                                                <tr>

                                                    <td><b> যন্ত্রাংশের নাম</b></td>

                                                    <td><b> ব্রান্ডের নাম</b></td>

                                                    <td><b> প্রস্তুতকারী দেশ</b></td>

                                                    <td><b> আমদানির তারিখ</b></td>

                                                    <td><b> সংযোগের প্রকৃতি (সমান্তরাল/অনুক্রম)</b></td>

                                                    <td><b>সংখ্যা</b></td>

                                                    <td><b>একক ক্ষমতা</b></td>

                                                    <td><b>মোট ক্ষমতা</b></td>

                                                    <td><b>ব্যবহৃত মোটরের মোট অশ্ব ক্ষমতা</b></td>

                                                    <td width="5%"><b>ঠিক নাকি ভূল?</b></td>

                                                    <td><b>কমেন্ট</b><span style="color: red;"> * </span></td>

                                                </tr>
                                                <?php $count = 1; ?>

                                                    @foreach($miller->mill_milling_unit_machineries as $mill_milling_unit_machinery)

                                                    <tr>
                                                    <input type="hidden" name="mill_milling_unit_machinery_id{{$count}}" value="{{$mill_milling_unit_machinery->mill_milling_unit_machinery_id}}" />

                                                    <td>{{$mill_milling_unit_machinery->name}}</td>
                                                    <td>{{$mill_milling_unit_machinery->brand}}</td>
                                                    <td>{{$mill_milling_unit_machinery->manufacturer_country}}</td>
                                                    <td>{{$mill_milling_unit_machinery->import_date}}</td>
                                                    <td>{{$mill_milling_unit_machinery->join_type}}</td>
                                                    <td>{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery['num'])}}</td>
                                                    <td>{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery['power'])}}</td>
                                                    <td>{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery['topower'])}}</td>
                                                    <td>{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery['horse_power'])}}</td>

                                                    <td width="5%"><input type="radio" name="mill_milling_unit_machinery_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="mill_milling_unit_machinery_status{{$count}}" value="0">&nbsp;ভূল </td>

                                                    <td><textarea maxlength="200" name="mill_milling_unit_machinery_comment{{$count}}" class="form-control" value=""></textarea></td>
                                                    </tr>

                                                    <tr><td colspan="15"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                                                <?php $count++;?>
                                                @endforeach

                                                </tbody></table>

                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="boiler_machineries_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"> <b>বয়লার এর যন্ত্রপাতির বিবরণ</b></span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center">

                                            <tbody><tr>

                                                <td><b> যন্ত্রাংশের নাম</b></td>

                                                <td><b> ব্রান্ডের নাম</b></td>

                                                <td><b> প্রস্তুতকারী দেশ</b></td>

                                                <td><b> আমদানির তারিখ</b></td>

                                                <td><b>সংখ্যা</b></td>

                                                <td><b>একক ক্ষমতা</b></td>

                                                <td><b>যৌথ ক্ষমতা</b></td>

                                                <td><b> চাপ (প্রতি বর্গ সে.মি.) তে</b></td>

                                                <td width="5%"><b>ঠিক নাকি ভূল?</b></td>

                                                <td><b>কমেন্ট</b><span style="color: red;"> * </span></td>

                                                </tr>

                                                <?php $count = 1; ?>
                                                @foreach($miller->mill_boiler_machineries as $boiler_machinery)

                                                    <tr>
                                                    <input type="hidden" name="mill_boiler_machinery_id{{$count}}" value="{{$boiler_machinery->mill_boiler_machinery_id}}" />

                                                    <td>{{$boiler_machinery['name']}}</td>
                                                    <td>{{$boiler_machinery['brand']}}</td>
                                                    <td>{{$boiler_machinery['manufacturer_country']}}</td>
                                                    <td>{{$boiler_machinery['import_date']}}</td>
                                                    <td>{{App\BanglaConverter::en2bn(2, $boiler_machinery['num'])}}</td>
                                                    <td>{{$boiler_machinery['power']}}</td>
                                                    <td>{{$boiler_machinery['topower']}}</td>
                                                    <td>{{$boiler_machinery['pressure']}}</td>
                                                    <td width="5%"><input type="radio" name="mill_boiler_machinery_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="mill_boiler_machinery_status{{$count}}" value="0">&nbsp;ভূল </td>
                                                    <td><textarea maxlength="200" name="mill_boiler_machinery_comment{{$count}}" class="form-control" value=""></textarea></td>
                                                    </tr>

                                                    <tr><td colspan="15"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                                                <?php $count++;?>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                            @endif


                            <fieldset id="godown_preview" style="display:block;">
                                <div class="card">

                                    <div class="card-header flex justify-between">
                                        <span class="text-xl"> <b>চালকলের গুদামের তথ্য</b></span>
                                    </div>

                                    <div class="card-body">

                                        <table width="100%" align="center" class="miller_inspect report_fontsize">

                                                <tbody><tr>

                                                <td width="20%">চালকলের গুদামের সংখ্যা </td>

                                                <td>:</td>

                                                <td width="20%">{{$miller->godown_num}}</td>

                                                <td>ঠিক নাকি ভূল?</td>

                                                <td><strong>:</strong></td>

                                                <td><input type="radio" name="godown_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="godown_num_status" value="0">&nbsp;ভূল </td>

                                                <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                <td><strong>:</strong></td>

                                                <td><textarea maxlength="200" name="godown_num_comment" class="form-control" value=""></textarea></td>

                                                </tr>

                                                </tbody></table>

                                            <table width="100%" align="center">

                                            <tbody>
                                            <?php $count = 1; ?>

                                            @foreach($miller->godown_details as $godown_detail)
                                            <tr>
                                            <input type="hidden" name="godown_id{{$count}}" value="{{$godown_detail->godown_id}}" />

                                            <td><span>{{App\BanglaConverter::en2bn(0, $count)}}| দৈর্ঘ্য-   </span></td><td>:</td><td>{{$godown_detail->godown_long}}<span style="color: gray;"> (মিটার) </span></td>

                                            <td><span>প্রস্থ-     </span></td><td>:</td><td>{{$godown_detail->godown_wide}}<span style="color: gray;"> (মিটার) </span></td>

                                            <td><span> উচ্চতা-   </span></td><td>:</td><td>{{$godown_detail->godown_height}}<span style="color: gray;"> (মিটার) </span></td>

                                            <td><span> আয়তন-     </span></td><td>:</td><td>{{$godown_detail->godown_valume}}<span style="color: gray;"> (ঘন  মিটার) </span></td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="godown_long_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="godown_long_status{{$count}}" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="godown_long_comment{{$count}}" class="form-control" value=""></textarea></td>

                                            </tr>

                                            <tr><td colspan="12"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>

                                            <?php $count++;?>
                                            @endforeach

                                            </tbody></table>

                                                <table width="100%" align="center">

                                                    <tbody>
                                                        <tr>
                                                        <td width="50%">গুদামের মোট  আয়তন</td>

                                                        <td>:</td>

                                                        <td>@if($miller->areas_and_power){{$miller->areas_and_power->godown_area_total}}@endif<span style="color: gray;"> (ঘন  মিটার) </span></td>

                                                    </tr>

                                                    <tr>   <td>গুদামের ধারণ ক্ষমতা (আয়তন/৪.০৭৭) </td>

                                                        <td>:</td>

                                                        <td>@if($miller->areas_and_power){{$miller->areas_and_power->godown_power}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                                                    </tr>



                                                </tbody>
                                        </table>

                                    </div>
                                </div>

                            </fieldset>

                            @if($miller->mill_type_id!=5)

                                <fieldset id="chatal_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"><b>চাতালের তথ্য</b> </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center" class="miller_inspect report_fontsize">

                                                    <tbody><tr>

                                                        <td width="20%">চাতালের সংখ্যা </td>

                                                        <td>:</td>

                                                        <td width="20%">{{$miller->chatal_num}}</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="chatal_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="chatal_num_status" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="chatal_num_comment" class="form-control" value=""></textarea></td>

                                                    </tr>

                                                    </tbody>
                                                </table>

                                                <table width="100%" align="center">

                                                    <tbody>

                                                    <?php $count = 1; ?>
                                                    @foreach($miller->chatal_details as $chatal_detail)

                                                    <tr>
                                                        <input type="hidden" name="chatal_id{{$count}}" value="{{$chatal_detail->chatal_id}}" />

                                                        <td><span>{{App\BanglaConverter::en2bn(0, $count)}}  | দৈর্ঘ্য</span></td><td>:</td><td>{{$chatal_detail->chatal_long}}<span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span> প্রস্থ-     </span></td><td>:</td><td>{{$chatal_detail->chatal_wide}}<span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span> ক্ষেত্রফল- </span></td><td>:</td><td>{{$chatal_detail->chatal_area}}<span style="color: gray;"> (বর্গ  মিটার) </span></td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="chatal_long_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="chatal_long_status{{$count}}" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="chatal_long_comment{{$count}}" class="form-control" value=""></textarea></td>

                                                    </tr>

                                                    <tr><td colspan="9"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                                                    <?php $count++;?>
                                                    @endforeach

                                                    </tbody></table>

                                                    <table width="100%" align="center">

                                                        <tbody>
                                                        <tr>
                                                            <td>চাতালের মোট ক্ষেত্রফল</td>

                                                            <td>:</td>

                                                            <td>@if($miller->areas_and_power){{$miller->areas_and_power->chatal_area_total}}@endif<span style="color: gray;"> (বর্গ  মিটার) </span></td>

                                                        </tr>

                                                        <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (ক্ষেত্রফল/১২৫) * ৭ </td>

                                                            <td>:</td>

                                                            <td>@if($miller->areas_and_power){{$miller->areas_and_power->chatal_power}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                                                        </tr>


                                                    </tbody></table>

                                                </div>
                                    </div>
                                </fieldset>

                                @if($miller->mill_type_id!=1)

                                    <fieldset id="steping_preview" style="display:block;">
                                        <div class="card">

                                            <div class="card-header flex justify-between">
                                                <span class="text-xl"> <b>স্টীপিং হাউসের  তথ্য</b></span>
                                            </div>

                                            <div class="card-body">

                                                <table width="100%" align="center" class="miller_inspect report_fontsize">

                                                    <tbody><tr>

                                                    <td width="20%">স্টীপিং হাউসের সংখ্যা</td>

                                                    <td>:</td>

                                                    <td width="20%">{{$miller->steeping_house_num}}</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="steeping_house_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="steeping_house_num_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="steeping_house_num_comment" class="form-control" value=""></textarea></td>

                                                    </tr>

                                                    </tbody></table>

                                                    <table width="100%" align="center">

                                                        <tbody>

                                                        <?php $count = 1; ?>
                                                        @foreach($miller->steeping_house_details as $steeping_house_detail)

                                                        <tr>
                                                        <input type="hidden" name="steeping_house_id{{$count}}" value="{{$steeping_house_detail->steeping_house_id}}" />

                                                        <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | দৈর্ঘ্য -   </span></td><td>:</td><td>{{$steeping_house_detail->steeping_house_long}} <span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span>প্রস্থ -     </span></td><td>:</td><td>{{$steeping_house_detail->steeping_house_wide}} <span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span> উচ্চতা -   </span></td><td>:</td><td>{{$steeping_house_detail->steeping_house_height}} <span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span> আয়তন -     </span></td><td>:</td><td>{{$steeping_house_detail->steeping_house_volume}} <span style="color: gray;"> (ঘন  মিটার) </span></td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="steeping_house_long_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="steeping_house_long_status{{$count}}" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="steeping_house_long_comment{{$count}}" class="form-control" value=""></textarea></td>

                                                        </tr>

                                                        <tr><td colspan="12"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                                                        <?php $count++;?>
                                                        @endforeach

                                                    </tbody></table>

                                                    <table width="100%"  align="center">

                                                        <tbody>
                                                        <tr>
                                                            <td width="50%">স্টীপিং হাউসের মোট  আয়তন</td>

                                                            <td>:</td>

                                                            <td>@if($miller->areas_and_power){{$miller->areas_and_power->steping_area_total}}@endif<span style="color: gray;"> (ঘন  মিটার)  </span></td>

                                                        </tr>

                                                        <tr>
                                                            <td>পাক্ষিক ধান ভেজানোর ক্ষমতা (আয়তন/১.৭৫) * ৭ </td>

                                                            <td>:</td>

                                                            <td>@if($miller->areas_and_power){{$miller->areas_and_power->steping_power}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                                                        </tr>
                                                    </tbody></table>
                                            </div>
                                        </div>
                                    </fieldset>

                                @endif

                                <fieldset id="motor_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"><b>মটরের তথ্য</b> </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center" class="miller_inspect report_fontsize">

                                            <tbody><tr>

                                            <td width="20%">মটরের সংখ্যা</td>

                                            <td>:</td>

                                            <td width="20%">{{$miller->motor_num}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="motor_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="motor_num_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="motor_num_comment" class="form-control" value=""></textarea></td>

                                            </tr>

                                            </tbody>
                                            </table>


                                            <table width="100%" align="center">

                                            <tbody>
                                            <?php $count = 1; ?>
                                            @foreach($miller->motor_details as $motor_detail)
                                            <tr>
                                            <input type="hidden" name="motor_id{{$count}}" value="{{$motor_detail->motor_id}}" />

                                            <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | অশ্বশক্তি-   </span></td><td>:</td><td>{{$motor_detail->motor_horse_power}}<span style="color: gray;"> </span></td>

                                            <td><span>হলার সংখ্যা-     </span></td><td>:</td><td>{{$motor_detail->motor_holar_num}}<span style="color: gray;"> </span></td>

                                            <td><span> ছাঁটাই ক্ষমতা-     </span></td><td>:</td><td>{{$motor_detail->motor_filter_power/1000}}<span style="color: gray;"> (মেঃ টন) ধান</span></td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="motor_holar_num_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="motor_holar_num_status{{$count}}" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="motor_holar_num_comment{{$count}}" class="form-control" value=""></textarea></td>

                                            </tr>

                                            <tr><td colspan="9"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                                            <?php $count++;?>
                                            @endforeach

                                        </tbody>
                                        </table>

                                        <table width="100%" align="center">

                                            <tbody>
                                                    <tr>
                                                        <td width="50%">মোট ছাটাই ক্ষমতা</td>

                                                        <td>:</td>

                                                        <td>@if($miller->areas_and_power){{$miller->areas_and_power->motor_area_total}}@endif<span style="color: gray;"> (মেঃ টন) ধান</span></td>

                                                    </tr>

                                                    <tr>   <td>পাক্ষিক ছাটাই ক্ষমতা (মোট ছাটাই ক্ষমতা x ৮ x ১১ ) </td>

                                                        <td>:</td>

                                                        <td>@if($miller->areas_and_power){{$miller->areas_and_power->motor_power}}@endif<span style="color: gray;"> (মেঃ টন) ধান</span></td>

                                                    </tr>
                                                </tbody></table>
                                            </div>
                                    </div>
                                </fieldset>

                            @else

                                @if($miller->chal_type_id!=1)

                                    <fieldset id="boiler_preview" style="display:block;">
                                        <div class="card">

                                            <div class="card-header flex justify-between">
                                                <span class="text-xl"> <b>পারবয়েলিং ইউনিটের বড় হাড়ি সমূহের তথ্য</b></span>
                                            </div>

                                            <div class="card-body">

                                                <table width="100%" align="center" class="miller_inspect report_fontsize">

                                                    <tbody>
                                                    <tr>

                                                        <td width="20%">বড় হাড়ি সমূহের মোট সেট সংখ্যা</td>

                                                        <td> : </td>

                                                        <td width="20%">{{App\BanglaConverter::en2bn(0, $miller->boiler_num)}}</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="boiler_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="boiler_num_status" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="boiler_num_comment" class="form-control" value=""></textarea></td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                                <table width="100%" align="center">

                                                    <tbody>

                                                    <?php $count = 1; ?>
                                                    @foreach($miller->boiler_details as $boiler_detail)

                                                        <tr>
                                                        <input type="hidden" name="boiler_id{{$count}}" value="{{$boiler_detail->boiler_id}}" />

                                                        <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | সিলিন্ডারের ব্যসার্ধ -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->boiler_radius)}} <span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span> সিলিন্ডারের উচ্চতা -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->cylinder_height)}} <span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span> কনিক অংশের উচ্চতা -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->cone_height)}} <span style="color: gray;"> (মিটার) </span></td>

                                                        <td><span> আয়তন -     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->boiler_volume)}} <span style="color: gray;"> (ঘন  মিটার) </span></td>

                                                        <td><span> সংখ্যা -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(0, $boiler_detail->qty)}}</td>

                                                        <td>ঠিক নাকি ভূল?</td>

                                                        <td><strong>:</strong></td>

                                                        <td><input type="radio" name="boiler_detail_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="boiler_detail_status{{$count}}" value="0">&nbsp;ভূল </td>

                                                        <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                        <td><strong>:</strong></td>

                                                        <td><textarea maxlength="200" name="boiler_detail_comment{{$count}}" class="form-control" value=""></textarea></td>
                                                        </tr>

                                                        <tr><td colspan="12"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                                                    <?php $count++;?>
                                                    @endforeach

                                                    </tbody></table>

                                                    <table width="100%" align="center">

                                                        <tbody>
                                                        <tr>
                                                            <td width="50%">বড় হাড়ি সমূহের মোট সংখ্যা</td>

                                                            <td>:</td>

                                                            <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->boiler_number_total)}}@endif<span style="color: gray;"> টি </span></td>

                                                        </tr>

                                                        <tr>
                                                            <td width="50%">বড় হাড়ি সমূহের মোট আয়তন</td>

                                                            <td>:</td>

                                                            <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->boiler_volume_total)}}@endif<span style="color: gray;"> (ঘন  মিটার)  </span></td>

                                                        </tr>

                                                        <tr>   <td>পাক্ষিক ধান ভেজানো ও ভাঁপানোর ক্ষমতা (আয়তন/১.৭৫) * ১৩ </td>

                                                            <td>:</td>

                                                            <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->boiler_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                                                        </tr>
                                                    </tbody></table>
                                            </div>
                                        </div>
                                    </fieldset>

                                @endif

                                <fieldset id="dryer_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"> <b>পারবয়েলিং ইউনিটের ড্রায়ার সমূহের তথ্য</b></span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center" class="miller_inspect report_fontsize">

                                                <tbody><tr>

                                                <td width="20%">ড্রায়ার সমূহের সংখ্যা</td>

                                                <td> : </td>

                                                <td width="20%">{{App\BanglaConverter::en2bn(0, $miller->dryer_num)}}</td>

                                                <td>ঠিক নাকি ভূল?</td>

                                                <td><strong>:</strong></td>

                                                <td><input type="radio" name="dryer_num_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="dryer_num_status" value="0">&nbsp;ভূল </td>

                                                <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                <td><strong>:</strong></td>

                                                <td><textarea maxlength="200" name="dryer_num_comment" class="form-control" value=""></textarea></td>
                                                </tr>

                                                </tbody>
                                            </table>

                                            <table width="100%" align="center">

                                                <tbody>

                                                <?php $count = 1; ?>
                                                @foreach($miller->dryer_details as $dryer_detail)

                                                    <tr>
                                                    <input type="hidden" name="dryer_id{{$count}}" value="{{$dryer_detail->dryer_id}}" />

                                                    <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | দৈর্ঘ্য - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->dryer_length)}} <span style="color: gray;"> (মিটার) </span></td>

                                                    <td><span>প্রস্থ - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->dryer_width)}} <span style="color: gray;"> (মিটার) </span></td>

                                                    <td><span> ঘনকের উচ্চতা - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->cube_height)}} <span style="color: gray;"> (মিটার) </span></td>

                                                    <td><span> পিরামিড অংশের উচ্চতা - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->pyramid_height)}} <span style="color: gray;"> (মিটার) </span></td>

                                                    <td><span> আয়তন - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->dryer_volume)}} <span style="color: gray;"> (ঘন  মিটার) </span></td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="dryer_detail_status{{$count}}" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="dryer_detail_status{{$count}}" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="dryer_detail_comment{{$count}}" class="form-control" value=""></textarea></td>

                                                    </tr>

                                                    <tr><td colspan="15"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                                                <?php $count++;?>
                                                @endforeach

                                                </tbody></table>

                                                <table width="100%" align="center">

                                                    <tbody><tr>
                                                        <td width="50%">ড্রায়ার সমূহের মোট আয়তন</td>

                                                        <td>:</td>

                                                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->dryer_volume_total)}}@endif<span style="color: gray;"> (ঘন  মিটার)  </span></td>

                                                    </tr>

                                                    <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (আয়তন * ৬৫% / ১.৭৫) * ১৩ </td>

                                                        <td>:</td>

                                                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->dryer_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                                                    </tr>
                                                </tbody></table>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="milling_unit_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"><b>মিলিং ইউনিটের তথ্য </b> </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center" class="report_fontsize">

                                                <tbody>
                                                <tr>

                                                    <td width="50%">ধান থেকে চাল বের করা অংশের শেষ ধাপ পেডি সেপারেটর এর প্রতি মিনিটে আউটপুট কেজিতে </td>

                                                    <td width="10"> : </td>

                                                    <td>{{App\BanglaConverter::en2bn(2, $miller->sheller_paddy_seperator_output)}} কেজি</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="sheller_paddy_seperator_output_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="sheller_paddy_seperator_output_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="sheller_paddy_seperator_output_comment" class="form-control" value=""></textarea></td>

                                                    </tr>

                                                    <tr>

                                                    <td width="50%">চালের সৌন্দর্য বর্ধন অংশের শেষ ধাপ গ্রেডার এর প্রতি মিনিটে আউটপুট কেজিতে </td>

                                                    <td width="10"> : </td>

                                                    <td>{{App\BanglaConverter::en2bn(2, $miller->whitener_grader_output)}} কেজি</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="whitener_grader_output_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="whitener_grader_output_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="whitener_grader_output_comment" class="form-control" value=""></textarea></td>

                                                    </tr>

                                                    <tr>

                                                    <td width="50%">বাছাই ও প্যাকিং অংশের ধাপ কালার শর্টার এর প্রতি মিনিটে আউটপুট কেজিতে </td>

                                                    <td width="10"> : </td>

                                                    <td>{{App\BanglaConverter::en2bn(2, $miller->colour_sorter_output)}} কেজি</td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="colour_sorter_output_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="colour_sorter_output_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="colour_sorter_output_comment" class="form-control" value=""></textarea></td>

                                                    </tr>

                                                    <tr><td colspan="3"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>

                                                    <tr>
                                                        <td width="50%">প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা (সবচেয়ে কম যেটি)	</td>

                                                        <td width="10"> : </td>

                                                        <td>{{App\BanglaConverter::en2bn(2, $miller->areas_and_power->milling_unit_output)}} কেজি</td>

                                                    </tr>

                                                    <tr>

                                                        <td>পাক্ষিক ধান ছাটাই ক্ষমতা (প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা x ৬০ x ৮ x ১৩ / ১০০০ / ০.৬৫ ) </td>

                                                        <td width="10"> : </td>

                                                        <td>{{App\BanglaConverter::en2bn(2, $miller->areas_and_power->milling_unit_power)}} মেঃ টন</td>

                                                    </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                            @endif

                            @if($miller->mill_type_id==4)
                                <fieldset id="rsolar_preview" style="display:block;">
                                    <div class="card">

                                        <div class="card-header flex justify-between">
                                            <span class="text-xl"><b>রাবার শেলার ও রাবার পলিশারের তথ্য</b> </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" align="center" class="miller_inspect report_fontsize">

                                            <tbody><tr>

                                            <td width="20%">রাবার শেলার ও রাবার পলিশার আছে কিনা?</td>

                                            <td>:</td>

                                            <td width="20%">{{$miller->is_rubber_solar}}</td>

                                            <td>ঠিক নাকি ভূল?</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="radio" name="is_rubber_solar_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="is_rubber_solar_status" value="0">&nbsp;ভূল </td>

                                            <td>কমেন্ট<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><textarea maxlength="200" name="is_rubber_solar_comment" class="form-control" value=""></textarea></td>

                                            </tr>

                                        </tbody></table>
                                        </div>
                                    </div>
                                </fieldset>
                            @endif

                            <fieldset id="p_power_preview" style="display:block;">
                                <div class="card">

                                    <div class="card-header flex justify-between">
                                        <span class="text-xl"> <b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></span>
                                    </div>

                                    <div class="card-body">

                                        <table width="100%" align="center" class="miller_inspect report_fontsize">

                                            <tbody>
                                                <tr>

                                                    <td width="20%"><b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা<b></td>

                                                    <td>:</td>


                                                    <td width="20%">{{App\BanglaConverter::en2bn(0, $miller->millar_p_power)}} মেট্টিক টন ধান, <b>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}} মেট্টিক টন চাল</b></td>

                                                    <td>ঠিক নাকি ভূল?</td>

                                                    <td><strong>:</strong></td>

                                                    <td><input type="radio" name="chatal_power_status" value="1" checked>&nbsp;ঠিক&nbsp;&nbsp;<input type="radio" name="chatal_power_status" value="0">&nbsp;ভূল </td>

                                                    <td>কমেন্ট<span style="color: red;"> * </span></td>

                                                    <td><strong>:</strong></td>

                                                    <td><textarea maxlength="200" name="chatal_power_comment" class="form-control" value=""></textarea></td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>

                        @endif
                        <br/>
                        <fieldset>
                            <div class="card card-body">
                                @if($miller->license_no != null && $miller->date_license != null && $miller->date_renewal != null && $miller->meter_no != null )
                                    <table class="mt-4" cellpadding="3px">
                                        <tbody>
                                            <tr>
                                                <td>পিরিয়ড</td>
                                                <td>:</td>
                                                <td>
                                                    {{$inspection_period_name}}
                                                    <input type="hidden" name="inspection_period_id" value="{{$inspection_period_id}}" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>স্ট্যাটাস<span style="color: red;"> * </span></td>
                                                <td>:</td>
                                                <td>
                                                    <input required type="radio" name="inspection_status" id="inspection_status_active" value="যোগ্য" checked>&nbsp;যোগ্য&nbsp;&nbsp;
                                                    <input required type="radio" name="inspection_status" id="inspection_status_inactive" value="অযোগ্য">&nbsp;অযোগ্য&nbsp;&nbsp;
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>অযোগ্যতার কারন</td>
                                                <td>:</td>
                                                <td>
                                                    <select name="inactive_reason" id="inactive_reason" class="form-control" size="1"
                                                    title="অনুগ্রহ করে অযোগ্যতার কারন বাছাই করুন">
                                                        <option value=""> অযোগ্যতার কারন</option>
                                                        @foreach($inactive_reasons as $inactivereason)
                                                        <option value="{{ $inactivereason->reason_name}}">{{ $inactivereason->reason_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>কালো তালিকাভুক্ত সময় (বছর)</td>
                                                <td><strong>:</strong> </td>
                                                <td>
                                                    <input type="number" style="width: 200px;" min="0" name="blacklisted_period" class="form-control" placeholder="কালো তালিকাভুক্ত সময়">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>ইন্সপেকশন রিপোর্ট আপলোড</td>
                                                <td><strong>:</strong> </td>
                                                <td><input class="upload" type="file" name="inspection_document_file"></td>
                                            </tr>

                                            <tr>
                                                <td>কমেন্ট<span style="color: red;"> * </span></td>
                                                <td><strong>:</strong></td>

                                                <td><textarea maxlength="200" name="inspection_comment" class="form-control" value=""></textarea></td>
                                            </tr>

                                            @if(DGFAuth::check2(1,  1))
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td id="chal_btn_hide" style="padding-top: 15px">
                                                    <input type="submit" id="chalkol_submit" class="btn btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="   সম্পূর্ণ সাবমিট   ">
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                @else
                                    <h2 style="color: red; font-weight:bold; text-align:center;"> Please complete license information first.</h2>
                                @endif
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#inspectionform").on('submit', function() {
        if(!$("#inactive_reason").val() && $("input[name='inspection_status']:checked").val() == "অযোগ্য"){
            alert("দয়া করে অযোগ্যতার কারন নির্বাচন করুন।");
            $("#inactive_reason").focus();
            return false;
        }
    });
</script>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="form_margin" class="form_page">
                <h2 align="center">@if($option == 'form1') সেমি-অটোমেটিক @elseif($option=='form2') অটোমেটিক @elseif($option == 'form5') হালনাগাদকৃত অটোমেটিক @elseif($option == 'form3') রাবার শেলার বিহীন (হাস্কিং) @else রাবার শেলার যুক্ত (মেজর) @endif
                চালকলের মিলিং ক্ষমতা নির্ণয় ফরম</h2>
                <p style="text-align:center; color: #e53e3e; font-weight: 700; font-size:16px;">চালকলের তথ্য এফ পি এস সিস্টেমে পাঠাতে 'Send to FPS' বাটন  চাপুন |</p>
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

                    <form id="millerform" action="{{ route('millers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <fieldset id="chalkol_form">
                            <div class="card">
                            <div class="card-header flex justify-between">
                                <span class="text-xl">
                                চালকলের ও মিল মালিকের তথ্য  <span style="color: gray;"> ( বাংলায়  পূরণ করুন )</span>
                                </span>
                                <span>
                                    <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                </span>
                            </div>

                            <div class="card-body">
                                <table width="100%" class="mx-2">
                                    <tbody>
                                    <tr>
                                        <td style="color: red;">চালকলের অবস্থা<span style="color: red;"> * </span></td>
                                        <td>:</td>
                                        <td>
                                            <input required type="radio" name="miller_status" id="miller_status_active" value="active" checked>&nbsp;সচল চালকল&nbsp;&nbsp;
                                            <input required type="radio" name="miller_status" id="miller_status_inactive" value="inactive">&nbsp;বন্ধ চালকল&nbsp;&nbsp;
                                        </td>
                                    </tr>

                                    <tr id="tr_last_inactive_reason" style="width:100%; display: none;">
                                        <td style="color: red;">বন্ধের কারন</td>
                                        <td>:</td>
                                        <td>
                                            <select name="last_inactive_reason" id="last_inactive_reason" class="form-control" size="1"
                                            title="অনুগ্রহ করে বন্ধের কারন বাছাই করুন">
                                                <option value=""> বন্ধের কারন</option>
                                                @foreach($inactive_reasons as $inactivereason)
                                                <option value="{{ $inactivereason->reason_name}}">{{ $inactivereason->reason_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">মালিকানার ধরন<span style="color: red;"> * </span></td>
                                        <td>:</td>
                                        <td>
                                            <input required type="radio" name="owner_type" id="owner_type_single" value="single" checked>&nbsp;একক&nbsp;&nbsp;
                                            <input required type="radio" name="owner_type" id="owner_type_multi" value="multi">&nbsp;যৌথ&nbsp;&nbsp;
                                            <input required type="radio" name="owner_type" id="owner_type_corporate" value="corporate">&nbsp;কর্পোরেট&nbsp;&nbsp;
                                        </td>
                                    </tr>



                                    <tr id="tr_corporate" style="width:100%; display: none;">
                                        <td width="50%" style="color: red;">কর্পোরেট প্রতিষ্ঠান<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong> </td>
                                        <td>
                                            <select  name="corporate_institute_id" id="corporate_institute_id" class="form-control" size="1" title="অনুগ্রহ করে কর্পোরেট প্রতিষ্ঠান বাছাই করুন">
                                                    <option value="">কর্পোরেট প্রতিষ্ঠান</option>
                                                    @foreach($corporate_institutes as $corporate_institute)
                                                    <option value="{{ $corporate_institute->id}}">{{ $corporate_institute->name}}</option>
                                                    @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">মিল মালিকের এনআইডি<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td>
                                            <input required minlength="10" maxlength="17" placeholder="মিল মালিকের এনআইডি লিখুন" style="float: left;width: 60%;"type="number" name="nid_no" id="nid_no" class="form-control" value="{{ old('nid_no') }}" title="মিল মালিকের এনআইডি">
                                            <input type="button" class="btn btn-primary" value="পূর্বের তথ্য আনুন" style="float: left;margin-left: 10px;" onclick="loadMillerInfoByNID()">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">জন্ম তারিখ <span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input style="float: left;width: 60%;" type="text" required name="birth_date" id="birth_date" class="form-control date" value="{{ old('birth_date') }}" placeholder="একটি তারিখ বাছাই করুন" title="জন্ম তারিখ">
                                        <input type="button" class="btn btn-primary" value="মিল মালিকের এনআইডি যাচাই" style="float: left;margin-left: 10px;" onclick="verifyNID()">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="50%" style="color: red;">বিভাগ<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong> </td>
                                        <td>
                                            <select required name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                                                    <option value="">বিভাগ</option>
                                                    @foreach($divisions as $division)
                                                    <option value="{{ $division->divid}}" {{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">জেলা<span style="color: red;"> * </span> </td>
                                        <td><strong>:</strong></td>
                                        <td>
                                            <select required name="district_id" id="district_id" class="form-control" size="1" title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                                <option value="">জেলা</option>
                                                @foreach($districts as $district)
                                                <option value="{{ $district->distid}}"
                                                {{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                                                @endforeach
                                        </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">উপজেলা<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td>
                                            <select required name="mill_upazila_id" id="mill_upazila_id" class="form-control" title="অনুগ্রহ করে  উপজেলা বাছাই করুন">
                                                <option value="">উপজেলা</option>
                                                @foreach($upazillas as $upazilla)
                                                <option value="{{ $upazilla->upazillaid}}" {{ ( $upazilla->upazillaid == $upazila_id) ?
                                                'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">চালকলের নাম<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="99" placeholder="চালকলের নাম বাংলায় লিখুন" type="text" name="mill_name" id="mill_name" class="form-control" value="{{ old('mill_name') }}" title="চালকলের নাম"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">চালকলের ঠিকানা<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><textarea required maxlength="99" name="mill_address" id="mill_address" class="form-control" title="চালকলের ঠিকানা"></textarea> </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">মালিকের নাম<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="99" type="text" name="owner_name" id="owner_name" title="মালিকের নাম" value="{{ old('owner_name') }}" class="form-control" placeholder="মালিকের নাম বাংলায় লিখুন"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">মালিকের নাম(ইংরেজি)<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="99" type="text" name="owner_name_english" id="owner_name_english" value="{{old('owner_name_english')}}" title="মালিকের নাম" value="" class="form-control" placeholder="মালিকের নাম ইংরেজিতে লিখুন"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">লিঙ্গ<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td>
                                        <select required name="gender" id="gender" class="form-control" size="1"
                                                title="অনুগ্রহ করে লিঙ্গ টাইপ বাছাই করুন">
                                                <option value="">লিঙ্গ টাইপ</option>
                                                <option value="male"> পুরুষ</option>
                                                <option value="female"> মহিলা</option>
                                                <option value="3rdGender">তৃতীয় লিঙ্গ</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">পিতার নাম<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="99" type="text" name="father_name" id="father_name" title="পিতার নাম" value="{{ old('father_name') }}" class="form-control" placeholder="পিতার নাম বাংলায় লিখুন"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">মাতার নাম <span style="color: red;"> * </span> </td>
                                        <td><strong>:</strong></td>
                                        <td><input maxlength="99" required type="text" name="mother_name" id="mother_name" value="{{old('mother_name')}}" title=" মাতার নাম"  class="form-control" placeholder="মাতার নাম বাংলায় লিখুন"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">মালিকের ঠিকানা <span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><textarea maxlength="99" required name="owner_address" id="owner_address" class="form-control" title="মালিকের ঠিকানা"></textarea></td>
                                    </tr>

                                    <!--<tr>
                                        <td>মালিকের জন্মস্থান <span style="color: red;"> * </span> </td>
                                        <td><strong>:</strong></td>
                                        <td><input maxlength="50" required type="text" name="miller_birth_place" id="miller_birth_place" value="{{$miller->miller_birth_place}}" title=" মালিকের জন্মস্থান" value="" class="form-control" placeholder="মালিকের জন্মস্থান বাংলায় লিখুন"></td>
                                    </tr>-->
                                    <tr>
                                        <td style="color: red;">মালিকের জন্মস্থান<span style="color: red;"> * </span> </td>
                                        <td><strong>:</strong></td>
                                        <td>
                                            <select required name="miller_birth_place" id="miller_birth_place" class="form-control" size="1" title="অনুগ্রহ করে জন্মস্থান বাছাই করুন">
                                                <option value="">জেলা</option>
                                                @foreach($miller_birth_places as $district)
                                                <option value="{{ $district->distid}}"
                                                {{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                                                @endforeach
                                           </select>
                                        </td>
                                    </tr>

                                    <tr style="color: red;">
                                        <td>মালিকের জাতীয়তা <span style="color: red;"> * </span> </td>
                                        <td><strong>:</strong></td>
                                        <td><input maxlength="20" required type="text" name="miller_nationality" id="miller_nationality" value="{{ $miller->miller_nationality ?? 'বাংলাদেশী' }}" title=" মালিকের জাতীয়তা" value="" class="form-control" placeholder="মালিকের জাতীয়তা বাংলায় লিখুন"></td>
                                    </tr>

                                     <!--<tr>
                                        <td>মালিকের ধর্ম <span style="color: red;"> * </span> </td>
                                        <td><strong>:</strong></td>
                                        <td><input maxlength="20" required type="text" name="miller_religion" id="miller_religion" value="{{$miller->miller_religion}}" title=" মালিকের ধর্ম" value="" class="form-control" placeholder="মালিকের ধর্ম বাংলায় লিখুন"></td>
                                    </tr>-->

                                    <tr>
                                        <td style="color: red;">মালিকের ধর্ম<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td>
                                        <select required name="miller_religion" id="miller_religion" class="form-control" size="1"
                                                title="অনুগ্রহ করে লিঙ্গ টাইপ বাছাই করুন">
                                                <option value="">ধর্ম টাইপ</option>
                                                <option value="ইসলাম"> ইসলাম</option>
                                                <option value="হিন্দু"> হিন্দু</option>
                                                <option value="বৌদ্ধ"> বৌদ্ধ </option>
                                                <option value="খ্রিস্টধর্ম"> খ্রিস্টধর্ম</option>
                                                <option value="অন্যান্য"> অন্যান্য</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">মোবাইল নং<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required placeholder="মোবাইল নং লিখুন"
                                            type="text" name="mobile_no" id="mobile_no" class="form-control"
                                            value="{{ old('mobile_no') }}" title="মোবাইল নং"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">ব্যাংক একাউন্ট নং<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="20" placeholder="ব্যাংক একাউন্ট নং লিখুন"
                                        type="text" name="bank_account_no" id="bank_account_no" class="form-control"
                                            value="{{ old('bank_account_no') }}" title="ব্যাংক একাউন্ট নং"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">ব্যাংক একাউন্ট নাম<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="64" placeholder="ব্যাংক একাউন্ট নাম লিখুন"
                                        type="text" name="bank_account_name" id="bank_account_name" class="form-control"
                                        value="{{ old('bank_account_name') }}" title="ব্যাংক একাউন্ট নাম"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">ব্যাংকের নাম<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="64" placeholder="ব্যাংকের নাম লিখুন"
                                        type="text" name="bank_name" id="bank_name" class="form-control"
                                        value="{{ old('bank_name') }}" title="ব্যাংক একাউন্ট"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">ব্যাংকের শাখার নাম<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td><input required maxlength="64" placeholder="ব্যাংকের শাখার নাম লিখুন"
                                        type="text" name="bank_branch_name" id="bank_branch_name" class="form-control"
                                        value="{{ old('bank_branch_name') }}" title="ব্যাংকের শাখার নাম"></td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">চালের ধরন<span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td>
                                            <select required name="chal_type_id" id="chal_type_id" class="form-control" title="অনুগ্রহ করে  চালের ধরন বাছাই করুন">
                                                <option value="">চালের ধরন</option>
                                                @foreach($chalTypes as $chalType)
                                                <option value="{{ $chalType->chal_type_id}}">{{ $chalType->chal_type_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color: red;">চালকলের ধরন <span style="color: red;"> * </span></td>
                                        <td><strong>:</strong></td>
                                        <td>
                                            @if($option=='form1')
                                                সেমি-অটোমেটিক
                                                <input type="hidden" name="mill_type_id" id="mill_type_id" value="1" />
                                            @elseif($option=='form2')
                                                অটোমেটিক
                                                <input type="hidden" name="mill_type_id" id="mill_type_id" value="2" />
                                            @elseif($option=='form5')
                                                হালনাগাদকৃত অটোমেটিক
                                                <input type="hidden" name="mill_type_id" id="mill_type_id" value="5" />
                                            @elseif($option=='form3')
                                                রাবার শেলার ও পলিশার বিহীন হাস্কিং মিল
                                                <input type="hidden" name="mill_type_id" id="mill_type_id" value="3" />
                                            @elseif($option=='form4')
                                                রাবার শেলার ও পলিশার যুক্ত হাস্কিং মিল
                                                <input type="hidden" name="mill_type_id" id="mill_type_id" value="4" />
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>চালকল মালিকের ছবি</td>
                                        <td><strong>:</strong> </td>
                                        <td><input class="upload" type="file" name="photo_file"></td>
                                        <td style="text-align: right;">** 300x300 এবং JPG/JPEG/PNG</td>
                                    </tr>

                                    <tr>
                                        <td>ইনকাম ট্যাক্স এর ডকুমেন্ট</td>
                                        <td><strong>:</strong> </td>
                                        <td><input class="upload" type="file" name="tax_file"></td>
                                        <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                    </tr>

                                </tbody>
                                </table>
                            </div>
                            </div>
                        </fieldset>

                        <fieldset id="license_form">
                            <div class="card">
                                <div class="card-header flex justify-between">
                                    <span class="text-xl">
                                        লাইসেন্স  ও বিদ্যুৎ এর  তথ্য <span style="color: gray;"> ( বাংলায়  পূরণ করুন )</span>
                                    </span>
                                    <span>
                                        <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                    </span>
                                </div>

                                <div class="card-body">

                                    <table width="100%" class="mx-2">

                                        <tbody>
                                            <tr>

                                                <td width="50%">লাইসেন্সের ধরন ও ফি</td>

                                                <td><strong>:</strong></td>

                                                <td>
                                                    <select name="license_fee_id" id="license_fee_id" class="form-control" size="1" title="অনুগ্রহ করে লাইসেন্স টাইপ বাছাই করুন">
                                                        <option value="">লাইসেন্সের ধরন ও ফি</option>
                                                        @foreach($licenseFees as $licenseFee)
                                                            <option value="{{ $licenseFee->id}}" {{ ( $licenseFee->id == $miller->license_fee_id) ? 'selected' : '' }}>{{ $licenseFee->license_fee}} / {{ $licenseFee->name}}</option>
                                                            @endforeach
                                                    </select>
                                                    <input type="hidden" name="license_deposit_amount" id="license_deposit_amount" value="{{$miller->license_deposit_amount}}" class="form-control">

                                                </td>

                                            </tr>

                                            <tr>

                                                <td>ফি জমার তারিখ</td>

                                                <td><strong>:</strong></td>

                                                <td><input type="text" name="license_deposit_date" id="license_deposit_date" class="form-control date" value="{{$miller->license_deposit_date}}" placeholder="একটি তারিখ বাছাই করুন" title="ফি জমার তারিখ"></td>

                                            </tr>

                                            <tr>

                                                <td>ফি জমাকৃত ব্যাংক</td>

                                                <td><strong>:</strong> </td>

                                                <td><input type="text" maxlength="64" name="license_deposit_bank" id="license_deposit_bank" value="{{$miller->license_deposit_bank}}" class="form-control"></td>

                                            </tr>

                                            <tr>

                                                <td>ফি জমাকৃত ব্যাংকের শাখা</td>

                                                <td><strong>:</strong> </td>

                                                <td><input type="text" maxlength="64" name="license_deposit_branch" id="license_deposit_branch" value="{{$miller->license_deposit_branch}}" class="form-control"></td>

                                            </tr>

                                            <tr>

                                                <td>চালান নং</td>

                                                <td><strong>:</strong> </td>

                                                <td><input type="text" maxlength="20" name="license_deposit_chalan_no" id="license_deposit_chalan_no" value="{{$miller->license_deposit_chalan_no}}" class="form-control"></td>

                                            </tr>

                                            <tr>
                                                <td>লাইসেন্স ফি জমার চালানের কপি</td>
                                                <td><strong>:</strong> </td>
                                                <td>
                                                    <input class="upload" type="file" name="license_deposit_chalan_file">
                                                    <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>ভ্যাট জমার চালানের কপি</td>
                                                <td><strong>:</strong> </td>
                                                <td>
                                                    <input class="upload" type="file" name="vat_file">
                                                    <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                                </td>
                                            </tr>

                                            <tr>

                                                <td width="50%" style="color: red;">লাইসেন্স নং <span style="color: red;"> * </span></td>

                                                <td><strong>:</strong></td>

                                                <td><input required type="text" maxlength="99" name="license_no" id="license_no" class="form-control" value="{{$miller->license_no}}" placeholder="লাইসেন্স নং বাংলায় লিখুন" title="লাইসেন্স নম্বর "></td>

                                            </tr>

                                            <tr>
                                                <td>লাইসেন্সের কপি</td>
                                                <td><strong>:</strong> </td>
                                                <td><input class="upload" type="file" name="license_file"></td>
                                                <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                            </tr>

                                            <tr>

                                                <td style="color: red;">লাইসেন্স প্রদানের তারিখ <span style="color: red;"> * </span></td>

                                                <td><strong>:</strong></td>

                                                <td><input type="text" required name="date_license" id="date_license" class="form-control date" value="{{$miller->date_license}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স প্রদানের তারিখ"></td>

                                            </tr>

                                            <tr>

                                                <td style="color: red;">লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত <span style="color: red;"> * </span></td>

                                                <td><strong>:</strong> </td>

                                                <td><input type="text" required name="date_renewal" id="date_renewal" class="form-control date" value="{{$miller->date_renewal}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত"></td>

                                            </tr>

                                            <tr>

                                                <td>লাইসেন্স সর্বশেষ নবায়ণের তারিখ </td>

                                                <td><strong>:</strong> </td>

                                                <td><input type="text" name="date_last_renewal" id="date_last_renewal" class="form-control date" value="{{$miller->date_last_renewal}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স সর্বশেষ নবায়ণের তারিখ"></td>

                                            </tr>

                                            <tr>
                                                <td>লাইসেন্স প্রদানকারী অফিসারের স্বাক্ষর</td>
                                                <td><strong>:</strong> </td>
                                                <td><input class="upload" type="file" name="signature_file"></td>
                                                <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                            </tr>

                                            @if($option=='form2')

                                                <tr>

                                                    <td>মিল স্থাপনের বছর </td>

                                                    <td><strong>:</strong> </td>

                                                    <td><input type="text" name="pro_flowdiagram" id="pro_flowdiagram" value="@if($miller->autometic_miller){{$miller->autometic_miller->pro_flowdiagram}} @endif" class="form-control"></td>

                                                </tr>

                                                <tr>

                                                    <td>কান্ট্রি অব অরিজিন (লিখুন)</td>

                                                    <td><strong>:</strong> </td>

                                                    <td><input type="text" name="origin" id="origin" value="@if($miller->autometic_miller){{$miller->autometic_miller->origin}} @endif" class="form-control"></td>

                                                </tr>


                                                <tr>

                                                    <td>পরিদর্শনের তারিখ</td>

                                                    <td><strong>:</strong> </td>

                                                    <td><input type="text" name="visited_date" id="visited_date" class="form-control date" value="@if($miller->autometic_miller){{$miller->autometic_miller->visited_date}} @endif" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত"></td>

                                                </tr>

                                            @endif

                                            @if($option=='form5')

                                                <tr>

                                                    <td>মিল স্থাপনের বছর </td>

                                                    <td><strong>:</strong> </td>

                                                    <td><input type="text" name="pro_flowdiagram" id="pro_flowdiagram" value="@if($miller->autometic_miller_new){{$miller->autometic_miller_new->pro_flowdiagram}} @endif" class="form-control"></td>

                                                </tr>

                                                <tr>

                                                    <td>কান্ট্রি অব অরিজিন (লিখুন)</td>

                                                    <td><strong>:</strong> </td>

                                                    <td><input type="text" name="origin" id="origin" value="@if($miller->autometic_miller_new){{$miller->autometic_miller_new->origin}} @endif" class="form-control"></td>

                                                </tr>

                                                <tr>

                                                    <td>মিলিং যন্ত্রাংশ প্রস্তুতকারী কোম্পানীর নাম (লিখুন)</td>

                                                    <td><strong>:</strong> </td>

                                                    <td><input type="text" name="milling_parts_manufacturer" id="milling_parts_manufacturer" class="form-control" value="@if($miller->autometic_miller_new){{$miller->autometic_miller_new->milling_parts_manufacturer}} @endif"></td>

                                                </tr>

                                                <tr>

                                                    <td>যন্ত্রাংশের প্রকৃতি</td>

                                                    <td><strong>:</strong> </td>

                                                    <td>
                                                        <select id="milling_parts_manufacturer_type" name="milling_parts_manufacturer_type" class="form-control" title="অনুগ্রহ করে একটি  বাছাই করুন">
                                                            <option value="একক কোম্পানী" {{ ( $miller->autometic_miller_new && "একক কোম্পানী" == $miller->autometic_miller_new->milling_parts_manufacturer_type) ? 'selected' : '' }}>একক কোম্পানী</option>
                                                            <option value="মিশ্র কোম্পানী" {{ ( $miller->autometic_miller_new && "মিশ্র কোম্পানী" == $miller->autometic_miller_new->milling_parts_manufacturer_type) ? 'selected' : '' }}>মিশ্র কোম্পানী</option>
                                                            <option value="ক্লোন" {{ ( $miller->autometic_miller_new && "ক্লোন" == $miller->autometic_miller_new->milling_parts_manufacturer_type) ? 'selected' : '' }}>ক্লোন</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            @endif

                                            <tr>

                                                <td>বিদ্যুৎ সংযোগ আছে কিনা ? </td>

                                                <td><strong>:</strong> </td>

                                                <td>

                                                    <select id="is_electricity" name="is_electricity" class="form-control" title="অনুগ্রহ করে  একটি  বাছাই করুন">
                                                        <option value="হ্যাঁ" {{ ( "হ্যাঁ" == $miller->is_electricity) ? 'selected' : '' }}>হ্যাঁ</option>
                                                        <option value="না" {{ ( "না" == $miller->is_electricity) ? 'selected' : '' }}>না</option>
                                                    </select>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td style="color: red;">মিটার নং <span style="color: red;"> * </span></td>

                                                <td><strong>:</strong> </td>

                                                <td><input type="number" required name="meter_no" id="meter_no" value="{{$miller->meter_no}}" placeholder="মিটার নং ইংরাজীতে লিখুন" class="form-control" title="মিটার নং"></td>

                                            </tr>


                                            <tr>

                                                <td style="font-size: 13px;">বিদ্যুৎ সংযোগের অনুমতিপত্র অনুযায়ী সর্ব নিন্ম বৈদ্যুতিক লোডিং ক্ষমতা</td>

                                                <td><strong>:</strong></td>

                                                <td><input type="text" name="min_load_capacity" id="min_load_capacity" value="{{$miller->min_load_capacity}}" class="form-control" placeholder="সর্ব নিন্ম বৈদ্যুতিক লোডিং ক্ষমতা" title="সর্ব নিন্ম বৈদ্যুতিক লোডিং ক্ষমতা"></td>

                                            </tr>

                                            <tr>

                                                <td style="font-size: 13px;">বিদ্যুৎ সংযোগের অনুমতিপত্র অনুযায়ী  সর্ব উচ্চ বৈদ্যুতিক লোডিং ক্ষমতা</td>

                                                <td><strong>:</strong></td>

                                                <td><input type="text" name="max_load_capacity" id="max_load_capacity" value="{{$miller->max_load_capacity}}" class="form-control" placeholder="সর্ব উচ্চ বৈদ্যুতিক লোডিং ক্ষমতা" title="সর্ব উচ্চ বৈদ্যুতিক লোডিং ক্ষমতা"></td>

                                            </tr>

                                            <tr>
                                                <td>বিদ্যুৎ সংযোগ এর ডকুমেন্ট</td>
                                                <td><strong>:</strong> </td>
                                                <td><input class="upload" type="file" name="electricity_file"></td>
                                                <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                            </tr>

                                            <tr>

                                                <td>সর্বশেষ যে মাস পর্যন্ত বিদ্যুৎ বিল পরিশোধ করা হয়েছে</td>

                                                <td><strong>:</strong></td>

                                                <td><input type="text" name="last_billing_month" value="{{$miller->last_billing_month}}" id="last_billing_month" class="form-control date" placeholder="একটি তারিখ বাছাই করুন" title="বিদ্যুৎ বিল পরিশোধ করার তারিখ"></td>

                                            </tr>

                                            <tr>

                                                <td>পরিশোধিত মাসিক গড় বিলের পরিমাণ  (টাকা)</td>

                                                <td><strong>:</strong></td>

                                                <td><input type="text" name="paid_avg_bill" id="paid_avg_bill" value="{{$miller->paid_avg_bill}}" placeholder="গড় বিলের পরিমাণ বাংলায় লিখুন" class="form-control" title="পরিশোধিত মাসিক গড় বিলের পরিমাণ"></td>

                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </fieldset>

                        @if($option=='form2')

                            <fieldset id="autometic_mechin_form">
                                <div class="card">
                                    <div class="card-header flex justify-between">
                                        <span class="text-xl">
                                            যন্ত্রপাতির বিবরণ
                                        </span>
                                        <span>
                                            <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                        </span>
                                    </div>

                                    <div class="card-body">
                                        <table width="100%" class="mx-2">

                                            <tr>

                                                <td width="5%">ক)</td>

                                                {{-- <td><strong>:</strong></td> --}}

                                                <td>
                                                    <textarea maxlength="255" class="form-control" name="machineries_a"  id="machineries_a">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_a}}@endif</textarea>
                                                </td>

                                            </tr>

                                            <tr> <td colspan="3" align="right" id="errorMsgMachi"></td></tr>

                                                <tr>

                                                <td >খ)</td>

                                                {{-- <td><strong>:</strong></td> --}}

                                                <td> <textarea maxlength="255" class="form-control" name="machineries_b" id="machineries_b" >@if($miller->autometic_miller){{$miller->autometic_miller->machineries_b}}@endif</textarea>

                                                </td>

                                            </tr>

                                                <tr>

                                                <td>গ)</td>

                                                {{-- <td><strong>:</strong></td> --}}

                                                <td> <textarea maxlength="255" class="form-control" name="machineries_c" id="machineries_c">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_c}}@endif</textarea>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td>ঘ)</td>

                                                {{-- <td><strong>:</strong></td> --}}

                                                <td> <textarea maxlength="255" class="form-control" name="machineries_d" id="machineries_d">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_d}}@endif</textarea>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td>ঙ)</td>

                                                {{-- <td><strong>:</strong></td> --}}

                                                <td> <textarea maxlength="255" class="form-control" name="machineries_e" id="machineries_e" >@if($miller->autometic_miller){{$miller->autometic_miller->machineries_e}}@endif</textarea>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td>চ)</td>

                                                {{-- <td><strong>:</strong></td> --}}

                                                <td> <textarea maxlength="255" class="form-control" name="machineries_f" id="machineries_f">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_f}}@endif</textarea>

                                                </td>

                                            </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset id="auto_para_form">
                                <div class="card">
                                    <div class="card-header flex justify-between">
                                        <span class="text-xl">
                                            যন্ত্রপাতির বিবরণ
                                        </span>
                                        <span>
                                            <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                        </span>
                                    </div>

                                    <div class="card-body mx-2">

                                        <table width="100%" id="param_table">

                                            <tbody><tr>

                                            <td width="5%"><b>ক্রঃ নং</b></td>

                                            <td align="left" width="45%"><b> প্যারামিটার এর নাম</b></td>

                                            <td align="center" width="5%"><b>সংখ্যা</b></td>

                                            <td align="center" width="15%"><b>একক ক্ষমতা</b></td>

                                            <td align="center" width="15%"><b>মোট ক্ষমতা</b></td>

                                            </tr>


                                            <tr>

                                            <td width="5%">০১.</td>

                                            <td><input size="45%" type="text" name="parameter1_name" id="parameter1_name" class="form-control" value=" ট্রান্সফরমার ক্যাপাসিটি"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter1_num" id="parameter1_num" size="3" class="form-control" value="{{ old('parameter1_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter1_power" id="parameter1_power" class="form-control" value="{{ old('parameter1_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter1_topower" id="parameter1_topower" class="form-control" value="{{ old('parameter1_topower') }}"></td>

                                            </tr>


                                            <tr>

                                            <td width="5%">০২.</td>

                                            <td><input size="45%" type="text" name="parameter2_name" id="parameter2_name" class="form-control" value=" সেকশন লোড/ মটরের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter2_num" id="parameter2_num" size="3" class="form-control" value="{{ old('parameter2_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter2_power" id="parameter2_power" class="form-control" value="{{ old('parameter2_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter2_topower" id="parameter2_topower" class="form-control" value="{{ old('parameter2_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">০৩.</td>

                                            <td><input size="45%" type="text" name="parameter3_name" id="parameter3_name" class="form-control" value=" বয়লারের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter3_num" id="parameter3_num" size="3" class="form-control" value="{{ old('parameter3_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter3_power" id="parameter3_power" class="form-control" value="{{ old('parameter3_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter3_topower" id="parameter3_topower" class="form-control" value="{{ old('parameter3_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">০৪.</td>

                                            <td><input size="45%" type="text" name="parameter4_name" id="parameter4_name" class="form-control" value=" ধান চাল সংরক্ষনে গুদাম ঘরের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter4_num" id="parameter4_num" size="3" class="form-control" value="{{ old('parameter4_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter4_power" id="parameter4_power" class="form-control" value="{{ old('parameter4_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter4_topower" id="parameter4_topower" class="form-control" value="{{ old('parameter4_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">০৫.</td>

                                            <td><input size="45%" type="text" name="parameter5_name" id="parameter5_name" class="form-control" value=" ধান সংগ্রাহক বিনের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter5_num" id="parameter5_num" size="3" class="form-control" value="{{ old('parameter5_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter5_power" id="parameter5_power" class="form-control" value="{{ old('parameter5_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter5_topower" id="parameter5_topower" class="form-control" value="{{ old('parameter5_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">০৬.</td>

                                            <td><input size="45%" type="text" name="parameter6_name" id="parameter6_name" class="form-control" value=" পারবয়েলিং ইউনিট"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter6_num" id="parameter6_num" size="3" class="form-control" value="{{ old('parameter6_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter6_power" id="parameter6_power" class="form-control" value="{{ old('parameter6_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter6_topower" id="parameter6_topower" class="form-control" value="{{ old('parameter6_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">০৭.</td>

                                            <td><input size="45%" type="text" name="parameter7_name" id="parameter7_name" class="form-control" value=" ড্রায়ার"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter7_num" id="parameter7_num" size="3" class="form-control" value="{{ old('parameter7_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter7_power" id="parameter7_power" class="form-control" value="{{ old('parameter7_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter7_topower" id="parameter7_topower" class="form-control" value="{{ old('parameter7_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">০৮.</td>

                                            <td><input size="45%" type="text" name="parameter8_name" id="parameter8_name" class="form-control" value=" শেলার"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter8_num" id="parameter8_num" size="3" class="form-control" value="{{ old('parameter8_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter8_power" id="parameter8_power" class="form-control" value="{{ old('parameter8_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter8_topower" id="parameter8_topower" class="form-control" value="{{ old('parameter8_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">০৯.</td>

                                            <td><input size="45%" type="text" name="parameter9_name" id="parameter9_name" class="form-control" value=" ক্লিনার"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter9_num" id="parameter9_num" size="3" class="form-control" value="{{ old('parameter9_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter9_power" id="parameter9_power" class="form-control" value="{{ old('parameter9_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter9_topower" id="parameter9_topower" class="form-control" value="{{ old('parameter9_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১০.</td>

                                            <td><input size="45%" type="text" name="parameter10_name" id="parameter10_name" class="form-control" value=" পাথর পৃথকীকরণ (Destoner) ইউনিটের ক্ষমতা "></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter10_num" id="parameter10_num" size="3" class="form-control" value="{{ old('parameter10_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter10_power" id="parameter10_power" class="form-control" value="{{ old('parameter10_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter10_topower" id="parameter10_topower" class="form-control" value="{{ old('parameter10_topower') }}"></td>

                                            </tr>





                                            <tr>

                                            <td width="5%">১১.</td>

                                            <td><input size="45%" type="text" name="parameter11_name" id="parameter11_name" class="form-control" value=" ধান পৃথকীকরন (Paddy Seperator) ইউনিটের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter11_num" id="parameter11_num" size="3" class="form-control" value="{{ old('parameter11_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter11_power" id="parameter11_power" class="form-control" value="{{ old('parameter11_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter11_topower" id="parameter11_topower" class="form-control" value="{{ old('parameter11_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১২.</td>

                                            <td><input size="45%" type="text" name="parameter12_name" id="parameter12_name" class="form-control" value=" খুদকুড়া পৃথকীকরণ (Thickness grader)ইউনিটের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter12_num" id="parameter12_num" size="3" class="form-control" value="{{ old('parameter12_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter12_power" id="parameter12_power" class="form-control" value="{{ old('parameter12_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter12_topower" id="parameter12_topower" class="form-control" value="{{ old('parameter12_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১৩.</td>

                                            <td><input size="45%" type="text" name="parameter13_name" id="parameter13_name" class="form-control" value=" চাল উজ্জ্বল (Silky) ইউনিটের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter13_num" id="parameter13_num" size="3" class="form-control" value="{{ old('parameter13_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter13_power" id="parameter13_power" class="form-control" value="{{ old('parameter13_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter13_topower" id="parameter13_topower" class="form-control" value="{{ old('parameter13_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১৪.</td>

                                            <td><input size="45%" type="text" name="parameter14_name" id="parameter14_name" class="form-control" value=" চাল গ্রেডিং (Length Grader) ইউনিটের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter14_num" id="parameter14_num" size="3" class="form-control" value="{{ old('parameter14_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter14_power" id="parameter14_power" class="form-control" value="{{ old('parameter14_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter14_topower" id="parameter14_topower" class="form-control" value="{{ old('parameter14_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১৫.</td>

                                            <td><input size="45%" type="text" name="parameter15_name" id="parameter15_name" class="form-control" value=" পৃথকীকরণ (Rotary Shifter) ইউনিটের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter15_num" id="parameter15_num" size="3" class="form-control" value="{{ old('parameter15_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter15_power" id="parameter15_power" class="form-control" value="{{ old('parameter15_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter15_topower" id="parameter15_topower" class="form-control" value="{{ old('parameter15_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১৬.</td>

                                            <td><input size="45%" type="text" name="parameter16_name" id="parameter16_name" class="form-control" value=" চাল মসৃনকরণ (polisher) ইউনিটের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter16_num" id="parameter16_num" size="3" class="form-control" value="{{ old('parameter16_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter16_power" id="parameter16_power" class="form-control" value="{{ old('parameter16_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter16_topower" id="parameter16_topower" class="form-control" value="{{ old('parameter16_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১৭.</td>

                                            <td><input  size="45%" type="text" name="parameter17_name" id="parameter17_name" class="form-control" value=" কালার সর্টার ইউনিটের ক্ষমতা"></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter17_num" id="parameter17_num" size="3" class="form-control" value="{{ old('parameter17_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter17_power" id="parameter17_power" class="form-control" value="{{ old('parameter17_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter17_topower" id="parameter17_topower" class="form-control" value="{{ old('parameter17_topower') }}"></td>

                                            </tr>



                                            <tr>

                                            <td width="5%">১৮.</td>

                                            <td><input maxlength="99" class="form-control" type="text" name="parameter18_name" id="parameter18_name" class="form-control" value=" "></td>

                                            <td><input maxlength="4" class="form-control" type="text" name="parameter18_num" id="parameter18_num" size="3" class="form-control" value="{{ old('parameter18_num') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter18_power" id="parameter18_power" class="form-control" value="{{ old('parameter18_power') }}"></td>

                                            <td><input maxlength="30" class="form-control" type="text" name="parameter18_topower" id="parameter18_topower" class="form-control" value="{{ old('parameter18_topower') }}"></td>

                                            </tr>

                                            <tr>

                                            <td width="5%">১৯.</td>

                                            <td><input size="45%" type="text" name="parameter19_name" id="parameter19_name" class="form-control" value=" বস্তাবন্দি করনের ক্ষমতা"></td>

                                            <td colspan="3" align="center"><input maxlength="30" type="text" name="parameter19_topower" id="parameter19_topower" class="form-control" value="{{ old('parameter19_topower') }}"></td>

                                            </tr>


                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset id="auto_p_power_form">
                                <div class="card">
                                    <div class="card-header flex justify-between">
                                        <span class="text-xl">
                                            চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা
                                        </span>
                                        <span>
                                            <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                        </span>
                                    </div>

                                    <table class="card-body mx-4 my-2">

                                    <tbody><tr>

                                        <td width="50%"><b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></td>

                                        <td>: </td>

                                            <td><b><input maxlength="30" type="text" name="millar_p_power_chal" id="millar_p_power_chal" onkeydown="checkbanglainput(event)" placeholder="বাংলায় পুরন করুন" class="form-control" value="{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}}"> মেট্টিক টন চাল</b></td>

                                        </tr>

                                        <tr>
                                            <td><b>চালকলের পাক্ষিক ছাঁটাই ক্ষমতা অনুমোদন ফাইল</b></td>
                                            <td><strong>:</strong> </td>
                                            <td><input class="upload" type="file" name="miller_p_power_approval_file"></td>
                                            <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>

                        @else

                            @if($option!='form1' && $option!='form5')

                                <fieldset id="boiller_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                                বয়লারের তথ্য
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" class="mx-2">

                                                <tbody><tr>

                                                    <td width="50%">বয়লারের সংখ্যা </td>

                                                    <td width="10"> : </td>

                                                    <td><input type="text" name="boiller_num" id="boiller_num" class="form-control" value="{{App\BanglaConverter::en2bn(0, $miller->boiller_num)}}" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>

                                                </tr>

                                                <tr>

                                                    <td>বয়লারে স্বয়ংক্রিয় সেফটি ভালভ আছে কিনা ?</td>

                                                    <td width="10"> : </td>

                                                    <td>

                                                        <select id="is_safty_vulve" name="is_safty_vulve" class="form-control">
                                                            <option value="হ্যা" {{ ( $miller->is_safty_vulve == "হ্যা") ? 'selected' : '' }}>হ্যা</option>
                                                            <option value="না" {{ ( $miller->is_safty_vulve == "না") ? 'selected' : '' }}>না</option>
                                                        </select>

                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td>বয়লারে চাপমাপক যন্ত্র আছে কিনা ?</td>

                                                    <td width="10"> : </td>

                                                    <td>
                                                        <select id="is_presser_machine" name="is_presser_machine" class="form-control">
                                                            <option value="হ্যা" {{ ( $miller->is_presser_machine == "হ্যা") ? 'selected' : '' }}>হ্যা</option>
                                                            <option value="না" {{ ( $miller->is_presser_machine == "না") ? 'selected' : '' }}>না</option>
                                                        </select>
                                                    </td>

                                                </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="chimni_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                                চিমনীর তথ্য
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" class="mx-2">

                                                    <tbody><tr>

                                                    <td width="50%">চিমনীর উচ্চতা (মিটার) </td>

                                                    <td width="10"> : </td>

                                                    <td><input type="text" name="chimney_height" id="chimney_height" class="bangla_input" value="{{App\BanglaConverter::en2bn(2, $miller->chimney_height)}}" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>

                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                            @endif

                            @if($option=='form5')

                                <fieldset id="milling_unit_machineries_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                                মিলিং ইউনিটের যন্ত্রপাতির বিবরণ
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body mx-2">

                                            <table width="100%" id="param_table">

                                                <tbody><tr>

                                                <!-- <td width="5%"><b>ক্রঃ নং</b></td> -->

                                                <td align="left" width="15%"><b> যন্ত্রাংশের নাম</b></td>

                                                <td align="left" width="10%"><b> ব্রান্ডের নাম</b></td>

                                                <td align="left" width="10%"><b> প্রস্তুতকারী দেশ</b></td>

                                                <td align="left" width="15%"><b> আমদানির তারিখ</b></td>

                                                <td align="left" width="10%"><b> সংযোগের প্রকৃতি</b></td>

                                                <td align="center" width="5%"><b>সংখ্যা</b></td>

                                                <td align="center" width="10%"><b>একক ক্ষমতা</b></td>

                                                <td align="center" width="10%"><b>মোট ক্ষমতা</b></td>

                                                <td align="center" width="10%"><b>ব্যবহৃত মোটরের মোট অশ্ব ক্ষমতা</b></td>

                                                </tr>

                                                <?php $count = 0; ?>
                                                @foreach($milling_unit_machinery as $machinery)
                                                    <tr>

                                                    <!-- <td width="5%">০১.</td> -->

                                                    <td><input type="text" name="milling_unit_machinery_name[]" id="milling_unit_machinery_name{{$count}}" class="form-control" value="{{ $machinery->name}}">
                                                        <input type="hidden" name="milling_unit_machinery_machinery_id[]" value="{{ $machinery->machinery_id}}" /></td>
                                                    <td><input type="text" name="milling_unit_machinery_brand[]" id="milling_unit_machinery_brand{{$count}}" class="form-control" value=""></td>
                                                    <td><input type="text" name="milling_unit_machinery_manufacturer_country[]" id="milling_unit_machinery_manufacturer_country{{$count}}" class="form-control" value=""></td>
                                                    <td><input type="text" name="milling_unit_machinery_import_date[]" id="milling_unit_machinery_import_date{{$count}}" class="form-control date" value="" placeholder="একটি তারিখ বাছাই করুন" title="আমদানির তারিখ"></td>
                                                    <td>
                                                        <select required name="milling_unit_machinery_join_type[]" id="milling_unit_machinery_join_type{{$count}}" class="form-control" size="1"
                                                            title="অনুগ্রহ করে সংযোগের প্রকৃতি বাছাই করুন" onchange="millUnitMachineriesCalculate({{$count}})">
                                                            <option value="সমান্তরাল"> সমান্তরাল</option>
                                                            <option value="অনুক্রম"> অনুক্রম</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="milling_unit_machinery_num[]" id="milling_unit_machinery_num{{$count}}" maxlength="4" class="form-control" size="3" class="form-control" value="" onchange="millUnitMachineriesCalculate({{$count}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
                                                    <td><input type="text" name="milling_unit_machinery_power[]" id="milling_unit_machinery_power{{$count}}" maxlength="30" class="form-control" value="" onchange="millUnitMachineriesCalculate({{$count}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
                                                    <td><input type="text" name="milling_unit_machinery_topower[]" id="milling_unit_machinery_topower{{$count}}" readonly maxlength="30" class="form-control" value=""></td>
                                                    <td><input type="text" name="milling_unit_machinery_horse_power[]" id="milling_unit_machinery_horse_power{{$count}}" maxlength="30" class="form-control" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>

                                                    </tr>

                                                    <?php $count++;?>
                                                @endforeach

                                                <tr>
                                                    <td>মন্তব্য</td>
                                                    <td colspan="8"><textarea maxlength="99" name="milling_unit_comment" id="milling_unit_comment" class="form-control">{{ old('milling_unit_comment') }}</textarea></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="boiler_machineries_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                            বয়লার এর যন্ত্রপাতির বিবরণ
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">
                                            <br />
                                            <table>
                                                <tr>
                                                    <td>বয়লার সার্টিফিকেট </td>
                                                    <td><strong>:</strong> </td>
                                                    <td><input class="upload" type="file" name="boiler_certificate_file"></td>
                                                    <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন। আপলোড করুন।</td>
                                                </tr>

                                            </table>
                                            <br />
                                            <br />

                                            @livewire('edit-mill-boiler-machineries',['mill_boiler_machineries' => $miller->mill_boiler_machineries])

                                            <table style="width:100%">
                                                <tbody>
                                                <tr>
                                                <td width="62%">বয়লার এর যন্ত্রপাতির সর্বমোট ক্ষমতা</td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="boiler_machineries_steampower" id="boiler_machineries_steampower" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_machineries_steampower}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;"> (মেঃ টন) </span></td>

                                                </tr>

                                                <tr>
                                                    <td>পাক্ষিক ধান ভাঁপানো ও ড্রায়ারে ধান শুকানোর ক্ষমতা (সর্বমোট ক্ষমতা) x ১২ x ১৩ মেঃ টন  </td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="boiler_machineries_power" id="boiler_machineries_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_machineries_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                </tr>

                                                <!--<tr>
                                                    <td colspan="3" id="chal_btn_hide">
                                                        <p align="center" style="margin-top: 20px">
                                                            <input type="submit" id="boiler_machineries_submit" class="btn2 btn-primary" title="অনুগ্রহ করে সংরক্ষন করুন" value="সাবমিট ">
                                                            <input type="button" id="boiler_machineries" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                                                        </p>
                                                    </td>
                                                </tr>-->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                            @endif

                            <fieldset id="godown_form">
                                <div class="card">
                                    <div class="card-header flex justify-between">
                                        <span class="text-xl">
                                            চালকলের গুদামের তথ্য
                                        </span>
                                        <span>
                                            <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                        </span>
                                    </div>

                                    <div class="card-body">

                                        @livewire('edit-miller-godown',['godown_details' => $miller->godown_details])
                                        <br/>
                                        <table width="100%" class="mx-2">

                                                <tbody>
                                                <tr>
                                                    <td width="50%">গুদামের মোট আয়তন</td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="godown_area_total" id="godown_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->godown_area_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                                                </tr>

                                                <tr>
                                                    <td>গুদামের ধারণ ক্ষমতা (আয়তন/৪.০৭৭) </td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="godown_power" id="godown_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->godown_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>

                                    <br/>

                                @if($option=='form5')
                                    <div class="card-body">

                                        @livewire('edit-miller-silo',['silo_details' => $miller->silo_details])
                                        <br/>
                                        <table width="100%" class="mx-2">

                                            <tbody>
                                                <tr>
                                                    <td width="50%">সাইলোর মোট  আয়তন</td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="silo_area_total" id="silo_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->silo_area_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                                                </tr>

                                                <tr>
                                                    <td>সাইলোর ধারণ ক্ষমতা (আয়তন/১.৭৫) </td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="silo_power" id="silo_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->silo_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                </tr>
                                                <tr>
                                                    <td> মিলের সর্বমোট ধান সংরক্ষণ ক্ষমতা (সাইলোর ধারণ ক্ষমতা + গুদামের ধারণ ক্ষমতা)</td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="final_godown_silo_power" id="final_godown_silo_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->final_godown_silo_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                                </div>
                            </fieldset>

                            @if($option!='form5')

                                <fieldset id="chatal_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                                চাতালের তথ্য
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">

                                            @livewire('edit-miller-chatal',['chatal_details' => $miller->chatal_details])

                                            <br />
                                            <table width="100%" class="mx-2">

                                                <tbody>
                                                    <tr>   <td width="50%">চাতালের   মোট ক্ষেত্রফল<!-- <span style="color: red;"> * </span> --></td>

                                                            <td>:</td>

                                                            <td><input readonly type="text" name="chatal_area_total" id="chatal_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->chatal_area_total}}@endif" class="disableinput" title="অনুগ্রহ করে বাংলায় লিখুন"> <span style="font-size: 12px;">(বর্গ  মিটার) </span></td>

                                                    </tr>

                                                    <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (ক্ষেত্রফল/১২৫) * ৭ </td>

                                                            <td>:</td>

                                                            <td><input readonly type="text" name="chatal_power" id="chatal_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->chatal_power}}@endif" class="disableinput" title="অনুগ্রহ করে বাংলায় লিখুন"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                                @if($option!='form1')

                                    <fieldset id="steping_form">
                                        <div class="card">
                                            <div class="card-header flex justify-between">
                                                <span class="text-xl">
                                                    স্টীপিং হাউসের তথ্য
                                                </span>
                                                <span>
                                                    <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                                </span>
                                            </div>

                                            <div class="card-body">
                                                @livewire('edit-miller-steeping',['steeping_house_details' => $miller->steeping_house_details])
                                                <br/>
                                                <table width="100%" class="mx-2">

                                                    <tbody><tr>   <td width="50%">স্টীপিং হাউসের মোট  আয়তন</td>

                                                            <td>:</td>

                                                    <td><input readonly type="text" name="steping_area_total" id="steping_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->steping_area_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                                                    </tr>

                                                    <tr>   <td>পাক্ষিক ধান ভেজানোর ক্ষমতা (আয়তন/১.৭৫) * ৭ </td>

                                                            <td>:</td>

                                                    <td><input readonly type="text" name="steping_power" id="steping_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->steping_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                    </tr>


                                                    </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </fieldset>

                                @endif

                                <fieldset id="motor_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                                মটরের তথ্য
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">
                                            @livewire('edit-miller-motor',['motor_details' => $miller->motor_details, 'motor_powers' => $motor_powers])
                                            <br />
                                            <table width="100%" class="mx-2">

                                                <tbody>
                                                    <tr>
                                                        <td width="50%">মোট ছাটাই ক্ষমতা</td>

                                                        <td width="10"> : </td>

                                                        <td><input readonly type="text" name="motor_area_total" id="motor_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->motor_area_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                                                    </tr>

                                                    <tr>
                                                        <td>পাক্ষিক ছাটাই ক্ষমতা (মোট ছাটাই ক্ষমতা x ৮ x ১১ ) </td>

                                                        <td width="10"> : </td>

                                                        <td><input readonly type="text" name="motor_power" id="motor_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->motor_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                            @else

                                <fieldset id="boiler_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                            পারবয়েলিং ইউনিটের বড় হাড়ি সমূহের তথ্য
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">
                                            @livewire('edit-miller-boiler',['boiler_details' => $miller->boiler_details])
                                            <br/>
                                            <table width="100%" class="mx-2">

                                                <tbody>
                                                <tr>
                                                    <td width="50%">বড় হাড়ি সমূহের মোট সংখ্যা</td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="boiler_number_total" id="boiler_number_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_number_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;"> টি </span></td>

                                                </tr>

                                                <tr>
                                                    <td width="50%">বড় হাড়ি সমূহের মোট আয়তন</td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="boiler_volume_total" id="boiler_volume_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_volume_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                                                </tr>

                                                <tr>
                                                    <td>পাক্ষিক ধান ভেজানো ও ভাঁপানোর ক্ষমতা (আয়তন/১.৭৫) * ১৩ </td>

                                                    <td>:</td>

                                                    <td><input readonly type="text" name="boiler_power" id="boiler_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                </tr>


                                                </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="dryer_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                            পারবয়েলিং ইউনিটের ড্রায়ার সমূহের তথ্য
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">

                                            @livewire('edit-miller-dryer',['dryer_details' => $miller->dryer_details])

                                            <br />
                                            <table width="100%" class="mx-2">

                                                <tbody>
                                                    <tr>   <td width="50%">ড্রায়ার সমূহের মোট আয়তন<span style="color: red;"> * </span></td>

                                                            <td>:</td>

                                                            <td><input readonly type="text" name="dryer_volume_total" id="dryer_volume_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->dryer_volume_total}}@endif" class="disableinput" title="অনুগ্রহ করে বাংলায় লিখুন"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                                                    </tr>

                                                    <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (আয়তন * ৬৫% / ১.৭৫) * ১৩ </td>

                                                            <td>:</td>

                                                            <td><input readonly type="text" name="dryer_power" id="dryer_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->dryer_power}}@endif" class="disableinput" title="অনুগ্রহ করে বাংলায় লিখুন"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="milling_unit_form">
                                    <div class="card">
                                        <div class="card-header flex justify-between">
                                            <span class="text-xl">
                                                মিলিং ইউনিটের তথ্য ( সরেজমিনে পরিদর্শনে প্রাপ্ত )
                                            </span>
                                            <span>
                                                <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                            </span>
                                        </div>

                                        <div class="card-body">

                                            <table width="100%" class="mx-2">

                                                <tbody>
                                                <tr>
                                                    <td width="30%"></td>
                                                    <td width="10"> : </td>
                                                    <td width="10%">প্রতি মিনিটে</td>
                                                    <td width="10%">প্রতি ঘন্টায় </td>
                                                    <td width="20%">মিলিং ইউনিটের যন্ত্রপাতির ক্ষমতা</td>
                                                </tr>

                                                <tr>
                                                    <td width="30%"  style="color: red;">হাস্কার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                                                    <td width="10"> : </td>
                                                    <td width="10%"><input required type="text" onchange="millingUnitCalculate()" name="sheller_paddy_seperator_output" id="sheller_paddy_seperator_output" class="form-control" value="" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>
                                                    <td width="10%"><span id="sheller_paddy_seperator_output_hour"></span></td>
                                                    <td width="20%"> হাস্কার: <span id="mill_milling_unit_machineries_output_2"></span></td>
                                                </tr>

                                                <tr>

                                                    <td width="30%" style="color: red;">গ্রেডার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                                                    <td width="10"> : </td>
                                                    <td width="10%"><input required type="text" onchange="millingUnitCalculate()" name="whitener_grader_output" id="whitener_grader_output" class="form-control" value="" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>
                                                    <td width="10%"><span id="whitener_grader_output_hour"></span></td>
                                                    <td width="20%"> সিল্কি পলিশার: <span id="mill_milling_unit_machineries_output_6"></span></td>
                                                </tr>

                                                <tr>
                                                    <td width="30%" style="color: red;">কালার শর্টার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                                                    <td width="10"> : </td>
                                                    <td width="10%"><input required type="text" onchange="millingUnitCalculate()" name="colour_sorter_output" id="colour_sorter_output" class="form-control" value="" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>
                                                    <td width="10%"><span id="colour_sorter_output_hour"></span></td>
                                                    <td width="20%"> কালার সর্টার: <span id="mill_milling_unit_machineries_output_9"></span></td>
                                                </tr>

                                                <tr><td colspan="5"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>

                                                <tr>
                                                    <td width="50%">প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা (সবচেয়ে কম যেটি)	</td>

                                                    <td width="10"> : </td>

                                                    <td><input readonly type="text" name="milling_unit_output" id="milling_unit_output" value="@if($miller->areas_and_power){{$miller->areas_and_power->milling_unit_output}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(কেজি) </span></td>

                                                </tr>

                                                <tr>

                                                    <td>পাক্ষিক ধান ছাটাই ক্ষমতা (প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা x ৬০ x ৮ x ১৩ / ১০০০ / ০.৬৫ ) </td>

                                                    <td width="10"> : </td>

                                                    <td><input readonly type="text" name="milling_unit_power" id="milling_unit_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->milling_unit_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>

                            @endif

                            @if($option == 'form4')

                                <fieldset id="rsolar_form">
                                    <div class="card">
                                    <div class="card-header flex justify-between">
                                        <span class="text-xl">
                                            রাবার শেলার ও রাবার পলিশারের তথ্য
                                        </span>
                                        <span>
                                            <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                        </span>
                                    </div>

                                    <table class="card-body mx-4">

                                        <tbody>
                                            <tr>

                                                <td width="80%">রাবার শেলার ও রাবার পলিশার আছে কিনা?</td>

                                                <td width="10"> : </td>

                                                <td><select id="is_rubber_solar" name="is_rubber_solar"  class="form-control">

                                                    <option value="হ্যা" {{ ( $miller->is_rubber_solar == "হ্যা") ? 'selected' : '' }}>হ্যা</option>
                                                    <option value="না" {{ ( $miller->is_rubber_solar == "না") ? 'selected' : '' }}>না</option>

                                                </select></td>

                                            </tr>


                                        </tbody>
                                    </table>
                                    </div>
                                </fieldset>

                            @endif

                            <fieldset id="p_power_form">
                                <div class="card">
                                <div class="card-header flex justify-between">
                                    <span class="text-xl">
                                        চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা
                                    </span>
                                    <span>
                                        <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে
                                    </span>
                                </div>

                                <div class="card-body">
                                <table width="100%" class="mx-2">

                                    <tbody><tr>

                                        <td width="50%"><b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></td>

                                        <td>: </td>

                                        <!--<td><input readonly maxlength="30" type="text" name="millar_p_power" id="millar_p_power" placeholder="" class="form-control" value="{{ old('millar_p_power') }}"> মেট্টিক টন ধান</td>-->
                                        <td><b><input readonly maxlength="30" type="text" name="millar_p_power_chal" id="millar_p_power_chal" placeholder="" class="form-control" value="{{ old('millar_p_power_chal') }}"> মেট্টিক টন চাল</b></td>

                                        </tr>

                                        <tr>
                                            <td><b>চালকলের পাক্ষিক ছাঁটাই ক্ষমতা অনুমোদন ফাইল</b></td>
                                            <td><strong>:</strong> </td>
                                            <td><input class="upload" type="file" name="miller_p_power_approval_file"></td>
                                            <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                </div>
                            </fieldset>

                        @endif

                        <fieldset>
                            <table class="mt-4">
                                <tbody>
                                <tr>
                                    <td colspan="3" id="chal_btn_hide"><p align="right">
                                        <input type="hidden" id="cmp_status" name="cmp_status" value="1">
                                        <input type="hidden" id="u_id" name="u_id" value="{{ Auth::user()->id }}">
                                        <input type="submit" id="chalkol_submit" class="btn btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                                    </p></td>
                                </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $("#millerform").on('submit', function() {
        if($("#nid_no").val().length != 10 && $("#nid_no").val().length != 13 && $("#nid_no").val().length != 17){
            alert("এনাইডি ১০, ১৩ অথবা ১৭ সংখ্যার দিতে হবে।");
            $("#nid_no").focus();
            return false;
        }

        var reg = /^(01[3-9]\d{8})$/;
        if (!reg.test($("#mobile_no").val())){
            alert("মোবাইল নম্বর সঠিক নয়। মোবাইল নম্বর ইংরেজিতে ১১ সংখ্যার দিতে হবে, (-) দেওয়া যাবে না এবং 01[3-9] দিয়ে শুরু হবে।");
            $("#mobile_no").focus();
            return false;
        }

        if(!$("#last_inactive_reason").val() && $("input[name='miller_status']:checked").val() == "inactive"){
            alert("দয়া করে বন্ধের কারন নির্বাচন করুন।");
            $("#last_inactive_reason").focus();
            return false;
        }

        if(!$("#corporate_institute_id").val() && $("input[name='owner_type']:checked").val() == "corporate"){
            alert("দয়া করে কর্পোরেট প্রতিষ্ঠান নির্বাচন করুন।");
            $("#corporate_institute_id").focus();
            return false;
        }

        // var topwers = document.getElementsByName('milling_unit_machinery_topower[]');
        // var prev = 9999999999.99;
        // for (var i = 0; i <topwers.length; i++) {
        //     if(parseFloat(topwers[i].value) > prev){
        //         alert("দয়া করে আগের ধাপ থেকে ছোট সংখ্যা দিন।");
        //         $("#milling_unit_machinery_topower"+(i+1)).focus();
        //         return false;
        //     }

        //     if(parseFloat(topwers[i].value))
        //         prev = parseFloat(topwers[i].value);
        // }

        // var machineries_topowers = document.getElementsByName('boiler_machineries_topower[]');
        // var bp = 0;
        // for (var i = 0; i <machineries_topowers.length; i++) {
        //     if(parseFloat(machineries_topowers[i].value))
        //         bp += parseFloat(machineries_topowers[i].value);
        // }

        // dp = $("#dryer_power").val();

        // if(bp && 12*bp < dp/13){
        //     alert("ড্রায়ার এর পাক্ষিক ক্ষমতা ("+ dp +") বয়লারের যৌথ ক্ষমতা ("+ bp +") X 12 X 13  থেকে কম হতে হবে।");
        //     $("#dryer_power").focus();

        //     return false;
        // }

        return confirm("লাইসেন্স নং ঠিক দিয়েছেন কিনা দয়া করে নিশ্চিত করুন।");
    });

    $(function () {
        $(".upload").bind("change", function () {
            let file = this.files[0];
            let allowedExtensions = ["jpeg", "jpg", "png"];
            let fileSizeLimit = 1024 * 1024 * 2; // 2MB
            let fileName = file.name.toLowerCase();
            let fileExtension = fileName.split('.').pop();

            // Check file type
            if (!allowedExtensions.includes(fileExtension)) {
                alert("শুধুমাত্র JPEG, JPG এবং PNG ফাইল আপলোড করা যাবে।");
                this.value = "";
                return;
            }

            // Check file size
            if (file.size > fileSizeLimit) {
                alert("ফাইলটির সাইজ ২ মেগাবাইট এর বেশি, দয়া করে কম সাইজের ফাইল সিলেক্ট করুন।");
                this.value = "";
            }
        });

        $("input[name='photo_file']").bind("change", function () {
        let file = this.files[0];

        if (file) { // Check if a file is selected

            // Check image dimensions **ONLY for photo_file field**
            let img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = () => {
                if (img.width !== 300 || img.height !== 300) {
                    alert("ছবির সাইজ 300x300 পিক্সেল হতে হবে।");
                    $(this).val(""); // Clear only this input field
                }
            };
        }
    });
    });

    $('input[type=radio][name=miller_status]').change(function() {
        if (this.value == 'inactive') {
            $("#tr_last_inactive_reason").show();
        }
        else if (this.value == 'active') {
            $("#tr_last_inactive_reason").hide();
        }
    });

    $('input[type=radio][name=owner_type]').change(function() {
        if (this.value == 'corporate') {
            $("#tr_corporate").show();
        }
        else {
            $("#tr_corporate").hide();
        }
    });
</script>

@endsection

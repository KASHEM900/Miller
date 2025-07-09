@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div style="float:right">
                <input type="checkbox" checked style="display: none" name="selected_id" value="{{$miller->miller_id}}">
                <input type="button" class="btn btn-primary" value="প্রিন্ট ফরম" onclick="printForms()">
                <input type="button" class="btn btn-primary" value="প্রিন্ট লাইসেন্স" onclick="printLicenseForms()">
            </div>
            <div id="report_print" class="report_page">
                <div id="overlay">
					<div id="blanket"></div>
				</div>
                <h2 align="center">@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif
                চালকলের লাইসেন্স নবায়ন/ডুপ্লিকেট/নতুন করণের ফরম</h2>

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

                <fieldset id="chalkol_preview" style="display:block;">
                    <div class="card">

                    <div class="card-header flex justify-between">
                        <span class="text-xl"> <b>চালকলের তথ্য  </b> ফরম নম্বর : {{App\BanglaConverter::en2bt($miller->form_no)}} </span>
                        <span style="color: green" class="text-xl print_hide">
                            <span><b>{{$miller->miller_stage}}</b></span>
                        </span>
                    </div>
                    <div class="card-body">

                        <table width="100%" align="center" class="report_fontsize">
                            <tbody>
                            <tr>

                                <td width="20%">বিভাগ</td>

                                <td><strong>:</strong> </td>

                                <td>

                                    {{$miller->division->divname}}

                                </td>

                                <td width="20%">জেলা</td>

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

                                <td>চালকলের নাম</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->mill_name}}</td>

                            </tr>

                            <tr>

                                <td>মালিকের নাম</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->owner_name}}</td>

                                <td>পিতার নাম</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->father_name}}</td>

                            </tr>

                            <tr>

                                <td>মালিকের নাম(ইংরেজি)</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->owner_name_english}}</td>

                                <td>লিঙ্গ</td>

                                <td><strong>:</strong></td>

                                <td>
                                    @if($miller->gender == "male") পুরুষ 
                                    @elseif($miller->gender == "female")মহিলা 
                                    @elseif($miller->gender == "3rdGender") তৃতীয় লিঙ্গ
                                    @endif</span></td>
                                </td>

                                </tr>

                            <tr>

                                <td>জন্ম তারিখ</td>

                                <td><strong>:</strong></td>

                                <td>@if($miller->birth_date){{App\BanglaConverter::en2bt(\Carbon\Carbon::parse($miller->birth_date)->format('d/m/Y'))}}@endif</td>

                                <td>মিল মালিকের এনআইডি</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->nid_no}}</td>

                            </tr>

                            <tr>

                                <td>চালকলের ঠিকানা</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->mill_address}}</td>

                                <td>মালিকের ঠিকানা</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->owner_address}}</td>

                            </tr>

                            <tr>
                                <td>মালিকের জন্মস্থান</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->miller_birth_place}}</td>

                                <td>মালিকের জাতীয়তা</td>

                                <td><strong>:</strong></td>

                                <td>{{$miller->miller_nationality}}</td>

                            </tr>

                            <tr>

                                <td>চালের ধরন</td>

                                <td><strong>:</strong></td>

                                <td>@if($miller->chaltype) {{$miller->chaltype->chal_type_name}} @endif</td>

                                <td>চালকলের ধরন</td>

                                <td><strong>:</strong></td>

                                <td>@if($miller->milltype) {{$miller->milltype->mill_type_name}} @endif</td>

                            </tr>

                            <tr>
                                <td width="20%">চালকলের অবস্থা</td>
                                <td>:</td>
                                <td>
                                    @if($miller->miller_status == "new_register") নতুন নিবন্ধন @elseif($miller->miller_status == "active") সচল চালকল @else বন্ধ চালকল @endif
                                </td>

                                <td>চালকল মালিকের ছবি</td>

                                <td><strong>:</strong></td>

                                <td>
                                    @if($miller->photo_of_miller != '')
                                    <a target="_blank" href="{{ asset('images/photo_file/large/'.$miller->photo_of_miller) }}">
                                        <img width="100" height="100" src="{{ asset('images/photo_file/large/'.$miller->photo_of_miller) }}" alt="{{$miller->photo_of_miller}}"/>
                                    </a>
                                    @endif
                                </td>

                            </tr>

                            </tbody>
                        </table>

                    </div>
                    </div>
                </fieldset>

                <fieldset id="license_form">
                    <div class="card">

                        <div class="card-header flex justify-between">
                            <span class="text-xl"> <b>লাইসেন্স এর  তথ্য <span style="color: gray;"> ( বাংলায়  পূরণ করুন )</span></b></span>
                            <input type="button" class="btn2 btn-primary edit-button" value="লাইসেন্স হিস্টোরি" onclick="printLicenseHistory()" />
                            <span> <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে</span>
                        </div>

                        <div class="card-body">

                            <form id="licenseform" action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <table>

                                    <tbody>
                                        <tr>

                                            <td width="20%">লাইসেন্সের ধরন ও ফি</td>

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
                                                @if($miller->license_deposit_chalan_image != '')
                                                <a target="_blank" href="{{ asset('images/license_deposit_chalan_file/large/'.$miller->license_deposit_chalan_image) }}">
                                                    <img width="100" height="100" src="{{ asset('images/license_deposit_chalan_file/large/'.$miller->license_deposit_chalan_image) }}" alt="{{$miller->license_deposit_chalan_image}}"/>
                                                </a>
                                                @endif

                                                <input class="upload" type="file" name="license_deposit_chalan_file">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>ভ্যাট জমার চালানের কপি</td>
                                            <td><strong>:</strong> </td>
                                            <td>
                                                @if($miller->vat_file != '')
                                                <a target="_blank" href="{{ asset('images/vat_file/large/'.$miller->vat_file) }}">
                                                    <img width="100" height="100" src="{{ asset('images/vat_file/large/'.$miller->vat_file) }}" alt="{{$miller->vat_file}}"/>
                                                </a>
                                                @endif

                                                <input class="upload" type="file" name="vat_file">
                                            </td>
                                        </tr>

                                        <tr>

                                            <td width="63%">লাইসেন্স নং<span style="color: red;"> * </span></td>

                                            <td><strong>:</strong></td>

                                            <td><input required type="text" maxlength="99" name="license_no" id="license_no" class="form-control" value="{{$miller->license_no}}" placeholder="লাইসেন্স নং বাংলায় লিখুন" title="লাইসেন্স নম্বর "></td>

                                        </tr>

                                        <tr>
                                            <td>লাইসেন্সের কপি</td>
                                            <td><strong>:</strong> </td>
                                            <td>
                                                @if($miller->license_file_of_miller != '')
                                                <a target="_blank" href="{{ asset('images/license_file/large/'.$miller->license_file_of_miller) }}">
                                                    <img width="100" height="100" src="{{ asset('images/license_file/large/'.$miller->license_file_of_miller) }}" alt="{{$miller->license_file_of_miller}}"/>
                                                </a>
                                                @endif

                                                <input class="upload" type="file" name="license_file">
                                            </td>
                                        </tr>

                                        <tr>

                                            <td>লাইসেন্স প্রদানের তারিখ</td>

                                            <td><strong>:</strong></td>

                                            <td><input type="text" name="date_license" id="date_license" class="form-control date" value="{{$miller->date_license}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স প্রদানের তারিখ"></td>

                                        </tr>

                                        <tr>

                                            <td>লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত <span style="color: red;"> * </span></td>

                                            <td><strong>:</strong> </td>

                                            <td><input required type="text" name="date_renewal" id="date_renewal" class="form-control date" value="{{$miller->date_renewal}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত"></td>

                                        </tr>


                                            <td>লাইসেন্স সর্বশেষ নবায়ণের তারিখ </td>

                                            <td><strong>:</strong> </td>

                                            <td><input type="text" name="date_last_renewal" id="date_last_renewal" class="form-control date" value="{{$miller->date_last_renewal}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স সর্বশেষ নবায়ণের তারিখ"></td>

                                       </tr>

                                        <tr>
                                            <td>লাইসেন্স প্রদানকারী অফিসারের স্বাক্ষর</td>
                                            <td><strong>:</strong> </td>
                                            <td>
                                                @if($miller->signature_file != '')
                                                <a target="_blank" href="{{ asset('images/signature_file/large/'.$miller->signature_file) }}">
                                                    <img width="100" height="100" src="{{ asset('images/signature_file/large/'.$miller->signature_file) }}" alt="{{$miller->signature_file}}"/>
                                                </a>
                                                @endif

                                                <input class="upload" type="file" name="signature_file">
                                            </td>
                                        </tr>

                                        <tr>

                                            <td colspan="3" id="license_btn_hide">
                                                <p align="right" style="margin-top: 20px">
                                                    <input type="hidden" name="option" value="licenseonly">
                                                    <input type="submit" id="license_submit" class="btn2 btn-primary" title="অনুগ্রহ করে সংরক্ষন করুন" value="সাবমিট ">
                                                </p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </div>
</div>

<script>

    $("#licenseform").on('submit', function() {
        @if($miller->miller_status == "inactive")
            var d = new Date();
            var n = d.getFullYear();

            <?php
                echo 'var nobayon_types = [' . implode(',', $nobayonTypes) . '];';
            ?>

            if($("#license_deposit_date").val() && nobayon_types.includes(parseInt($("#license_fee_id").val())) && new Date($("#license_deposit_date").val()) <= new Date(n, 6, 30))
                alert("ফি জমার তারিখ ("+ $("#license_deposit_date").val() +") টি সঠিক দিয়েছেন কিনা দয়া করে নিশ্চিত করুন।");
        @endif

        return confirm("লাইসেন্স নং ঠিক দিয়েছেন কিনা দয়া করে নিশ্চিত করুন।");
    });

    $(document).ready(function(){
        @if($miller->cmp_status || $miller->miller_status != 'new_register')
        $(".edit-button").click(function () {
                //takes the ID of appropriate dialogue
                var id = $(this).attr('id');
               //open dialogue
               $("#"+id+"_preview").hide();
               $("#"+id+"_form").show();
            });

            $(".close-button").click(function () {
                //takes the ID of appropriate dialogue
                var id = $(this).attr('id');
               //open dialogue
               $("#"+id+"_preview").show();
               $("#"+id+"_form").hide();
            });
        @else
        $(".edit-button").hide();
        @endif
    });

    $(function () {
        $(".upload").bind("change", function () {
            if(this.files[0].size > 1024*1024*2){
                alert("ফাইলটির সাইজ ২ মেগাবাইট এর বেশি, দয়া করে কম সাইজের ফাইল সিলেক্ট করুন।");
                this.value = "";
            };
        });
    });

</script>

@endsection

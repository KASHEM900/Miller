<fieldset id="chalkol_form" style="display:none;">
    <div class="card">


    <div class="card-header flex justify-between">
        <span class="text-xl"><b>চালকলের ও মিল মালিকের তথ্য  <span style="color: gray;"> ( বাংলায়  পূরণ করুন )</span></b></span>
        @if($miller->user != null)
           <b style="color: red;">সর্বশেষ সংষ্করণ : {{$miller->user->name}} </b>
        @endif
        <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
    </div>

    <div class="card-body">

    <form id="chalkolform" action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table width="100%" class="mx-2">

            <tbody>

            <tr>
                <td style="color: red;">চালকলের অবস্থা<span style="color: red;"> * </span></td>
                <td>:</td>
                <td>
                    @if($miller->miller_status == "new_register")
                        <input type="hidden" name="miller_status" value="new_register">&nbsp;নতুন নিবন্ধন&nbsp;&nbsp;
                    @else
                        <input required type="radio" name="miller_status" id="miller_status_active" value="active" {{ ( $miller->miller_status == "active") ? 'checked' : '' }}>&nbsp;সচল চালকল&nbsp;&nbsp;
                        <input required type="radio" name="miller_status" id="miller_status_inactive" value="inactive" {{ ( $miller->miller_status == "inactive") ? 'checked' : '' }}>&nbsp;বন্ধ চালকল&nbsp;&nbsp;
                    @endif
                </td>
            </tr>

            <?php
                if($miller->miller_status == "inactive")
                    $display = "";
                else
                    $display = "display: none";
            ?>
            <tr id="tr_last_inactive_reason" style="width:100%; {{$display}}">
                <td style="color: red;">বন্ধের কারন</td>
                <td>:</td>
                <td>
                    <select name="last_inactive_reason" id="last_inactive_reason" class="form-control" size="1"
                    title="অনুগ্রহ করে বন্ধের কারন বাছাই করুন">
                        <option value=""> বন্ধের কারন</option>
                        @foreach($inactive_reasons as $inactivereason)
                        <option value="{{ $inactivereason->reason_name}}"
                                {{ ( $inactivereason->reason_name == $miller->last_inactive_reason) ? 'selected' : '' }}>
                                {{ $inactivereason->reason_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td style="color: red;">মালিকানার ধরন<span style="color: red;"> * </span></td>
                <td>:</td>
                <td>
                    <input required type="radio" name="owner_type" id="owner_type_single" value="single" {{ ( $miller->owner_type == "single") ? 'checked' : '' }}>&nbsp;একক&nbsp;&nbsp;
                    <input required type="radio" name="owner_type" id="owner_type_multi" value="multi" {{ ( $miller->owner_type == "multi") ? 'checked' : '' }}>&nbsp;যৌথ&nbsp;&nbsp;
                    <input required type="radio" name="owner_type" id="owner_type_corporate" value="corporate" {{ ( $miller->owner_type == "corporate") ? 'checked' : '' }}>&nbsp;কর্পোরেট&nbsp;&nbsp;
                </td>
            </tr>
            

            <?php
                if($miller->owner_type == "corporate")
                    $display_corporate = "";
                else
                    $display_corporate = "display: none";
            ?>
            <tr id="tr_corporate" style="width:100%; {{$display_corporate}}">
                <td width="50%" style="color: red;">কর্পোরেট প্রতিষ্ঠান<span style="color: red;"> * </span></td>
                <td><strong>:</strong> </td>
                <td>
                    <select  name="corporate_institute_id" id="corporate_institute_id" class="form-control" size="1" title="অনুগ্রহ করে কর্পোরেট প্রতিষ্ঠান বাছাই করুন">
                            <option value="">কর্পোরেট প্রতিষ্ঠান</option>
                            @foreach($corporate_institutes as $corporate_institute)
                            <option value="{{ $corporate_institute->id}}" {{ ( $corporate_institute->id == $miller->corporate_institute_id) ? 'selected' : '' }}>{{ $corporate_institute->name}}</option>
                            @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td style="color: red;">মিল মালিকের এনআইডি <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td>
                    <input required minlength="10" maxlength="17" placeholder="মিল মালিকের এনআইডি লিখুন" style="float: left;width: 60%;"type="number" name="nid_no" id="nid_no" class="form-control" value="{{$miller->nid_no}}" title="মিল মালিকের এনআইডি">
                    <input type="button" class="btn btn-primary" value="পূর্বের তথ্য আনুন" style="float: left;margin-left: 10px;" onclick="loadMillerInfoByNID()">
                </td>
            </tr>

            <tr>
                <td style="color: red;">জন্ম তারিখ <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input style="float: left;width: 60%;" type="text" required name="birth_date" id="birth_date" class="form-control date" value="{{$miller->birth_date}}" placeholder="একটি তারিখ বাছাই করুন" title="জন্ম তারিখ">
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
                            <option value="{{ $division->divid}}" {{ ( $division->divid == $miller->division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
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
                        <option value="{{ $district->distid}}" {{ ( $district->distid == $miller->district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
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
                        <option value="{{ $upazilla->upazillaid}}" {{ ( $upazilla->upazillaid == $miller->mill_upazila_id) ? 'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td style="color: red;">চালকলের নাম<span style="color: red;"> * </span></td>
                <td><strong>:</strong></td>
                <td><input required maxlength="99" placeholder="চালকলের নাম বাংলায় লিখুন" type="text" name="mill_name" id="mill_name" value="{{$miller->mill_name}}" class="form-control" value="" title="চালকলের নাম"></td>
            </tr>

            <tr><td colspan="3" class="err_hide" align="right" id="errorChalname"></td></tr>

            <tr>
                <td style="color: red;">চালকলের ঠিকানা <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><textarea maxlength="99" required name="mill_address" id="mill_address" class="form-control" title="চালকলের ঠিকানা">{{$miller->mill_address}}</textarea> </td>
            </tr>

            <tr><td colspan="3" id="errorChaladd"></td></tr>

            <tr>
                <td style="color: red;">মালিকের নাম<span style="color: red;"> * </span></td>
                <td><strong>:</strong></td>
                <td><input required maxlength="99" type="text" name="owner_name" id="owner_name" value="{{$miller->owner_name}}" title="মালিকের নাম" value="" class="form-control" placeholder="মালিকের নাম বাংলায় লিখুন"></td>
            </tr>

            <tr>
                <td style="color: red;">মালিকের নাম(ইংরেজি)<span style="color: red;"> * </span></td>
                <td><strong>:</strong></td>
                <td><input required maxlength="99" type="text" name="owner_name_english" id="owner_name_english" value="{{$miller->owner_name_english}}" title="মালিকের নাম" value="" class="form-control" placeholder="মালিকের নাম ইংরেজিতে লিখুন"></td>
            </tr>

            <tr>
                <td style="color: red;">লিঙ্গ<span style="color: red;"> * </span></td>
                <td><strong>:</strong></td>
                <td>
                    <select required name="gender" id="gender" class="form-control" size="1"
                                                title="অনুগ্রহ করে লিঙ্গ টাইপ বাছাই করুন">
                        <option value="">লিঙ্গ টাইপ/option>
                        <option value="male" {{ ( $miller->gender == "male") ? 'selected' : '' }}> পুরুষ</option>
                        <option value="female" {{ ( $miller->gender == "female") ? 'selected' : '' }}> মহিলা</option>
                        <option value="3rdGender" {{ ( $miller->gender == "3rdGender") ? 'selected' : '' }}> তৃতীয় লিঙ্গ</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td style="color: red;">পিতার নাম <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input maxlength="99" required type="text" name="father_name" id="father_name" value="{{$miller->father_name}}" title="পিতার নাম" value="" class="form-control" placeholder="পিতার নাম বাংলায় লিখুন"></td>
            </tr>

            <tr style="color: red;">
                <td>মাতার নাম <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input maxlength="99" required type="text" name="mother_name" id="mother_name" value="{{$miller->mother_name}}" title=" মাতার নাম" value="" class="form-control" placeholder="মাতার নাম বাংলায় লিখুন"></td>
            </tr>

            <tr>
                <td style="color: red;">মালিকের ঠিকানা <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><textarea maxlength="99" required name="owner_address" id="owner_address" class="form-control" title="মালিকের ঠিকানা">{{$miller->owner_address}}</textarea></td>
            </tr>

            <tr>
                <td style="color: red;">মালিকের জন্মস্থান<span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td>
                    <select required name="miller_birth_place" id="miller_birth_place" class="form-control" size="1" title="অনুগ্রহ করে জন্মস্থান বাছাই করুন">
                        <option value="">জেলা</option>
                        @foreach($miller_birth_places as $district)
                        <option value="{{ $district->distid}}" {{ ( $district->distid == $miller->miller_birth_place) ? 'selected' : '' }}>{{ $district->distname}}</option>
                        @endforeach
                </select>
                </td>
            </tr>
            
            <tr>
                <td style="color: red;">মালিকের জাতীয়তা <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input maxlength="20" required type="text" name="miller_nationality" id="miller_nationality" value="{{$miller->miller_nationality}}" title=" মালিকের জাতীয়তা" value="" class="form-control" placeholder="মালিকের জাতীয়তা বাংলায় লিখুন"></td>
            </tr>
            <tr>
                <td style="color: red;">মালিকের ধর্ম<span style="color: red;"> * </span></td>
                <td><strong>:</strong></td>
                <td>
                <select required name="miller_religion" id="miller_religion" class="form-control" size="1"
                        title="অনুগ্রহ করে লিঙ্গ টাইপ বাছাই করুন">
                        <option value="">ধর্ম টাইপ</option>
                        <option value="ইসলাম" {{ ( $miller->miller_religion == "ইসলাম") ? 'selected' : '' }}> ইসলাম</option>
                        <option value="হিন্দু" {{ ( $miller->miller_religion == "হিন্দু") ? 'selected' : '' }}> হিন্দু</option>
                        <option value="বৌদ্ধ" {{ ( $miller->miller_religion == "বৌদ্ধ") ? 'selected' : '' }}> বৌদ্ধ</option>
                        <option value="খ্রিস্টধর্ম" {{ ( $miller->miller_religion == "খ্রিস্টধর্ম") ? 'selected' : '' }}> খ্রিস্টধর্ম</option>
                        <option value="অন্যান্য" {{ ( $miller->miller_religion == "অন্যান্য") ? 'selected' : '' }}> অন্যান্য</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td style="color: red;">মোবাইল নং <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input required placeholder="মোবাইল নং লিখুন"
                 type="text" name="mobile_no" id="mobile_no" class="form-control"
                  value="{{$miller->mobile_no}}" title="মোবাইল নং"></td>
            </tr>

            <tr>
               <td style="color: red;">ব্যাংক একাউন্ট নং <span style="color: red;"> * </span> </td>
               <td><strong>:</strong></td>
               <td><input maxlength="20" required placeholder="ব্যাংক একাউন্ট নং লিখুন"
                type="text" name="bank_account_no" id="bank_account_no" class="form-control"
                 value="{{$miller->bank_account_no}}" title="ব্যাংক একাউন্ট নং"></td>
           </tr>

           <tr>
                <td style="color: red;">ব্যাংক একাউন্ট নাম <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input required maxlength="64" placeholder="ব্যাংক একাউন্ট নাম লিখুন"
                type="text" name="bank_account_name" id="bank_account_name" class="form-control"
                value="{{$miller->bank_account_name}}" title="ব্যাংক একাউন্ট নাম"></td>
            </tr>

            <tr>
                <td style="color: red;">ব্যাংকের নাম <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input maxlength="64" placeholder="ব্যাংকের নাম লিখুন"
                type="text" required name="bank_name" id="bank_name" class="form-control"
                value="{{$miller->bank_name}}" title="ব্যাংক একাউন্ট"></td>
            </tr>

            <tr>
                <td style="color: red;">ব্যাংকের শাখার নাম <span style="color: red;"> * </span> </td>
                <td><strong>:</strong></td>
                <td><input maxlength="64" placeholder="ব্যাংকের শাখার নাম লিখুন"
                type="text" required name="bank_branch_name" id="bank_branch_name" class="form-control"
                value="{{$miller->bank_branch_name}}" title="ব্যাংকের শাখার নাম"></td>
            </tr>

           <tr>
                <td style="color: red;">চালের ধরন<span style="color: red;"> * </span></td>
                <td><strong>:</strong></td>
                <td>
                    <select required name="chal_type_id" id="chal_type_id" class="form-control" title="অনুগ্রহ করে  চালের ধরন বাছাই করুন">
                        <option value="">চালের ধরন</option>
                        @foreach($chalTypes as $chalType)
                        <option value="{{ $chalType->chal_type_id}}" {{ ( $chalType->chal_type_id == $miller->chal_type_id) ? 'selected' : '' }}>{{ $chalType->chal_type_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td style="color: red;">চালকলের ধরন<span style="color: red;"> * </span></td>
                <td><strong>:</strong></td>
                <td>
                    <select required name="mill_type_id" id="mill_type_id" class="form-control" title="অনুগ্রহ করে  চালকলের ধরন বাছাই করুন" onchange="">
                        <option value="">চালকলের ধরন</option>

                        @foreach($millTypes as $millType)
                        <option value="{{ $millType->mill_type_id}}" {{ ( $millType->mill_type_id == $miller->mill_type_id) ? 'selected' : '' }}>{{ $millType->mill_type_name}}</option>
                        @endforeach
                    </select>
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

            <tr>
                <td colspan="3" id="chal_btn_hide"><p align="right" style="margin-top: 20px">
                    <input type="submit" id="chalkol_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                    <input type="button" id="chalkol" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                </p></td>
            </tr>

            </tbody>
        </table>
    </form>
</div>
</div>
</fieldset>

<script>
    $("#chalkolform").on('submit', function() {
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

        if(!$("#corporate_institute_id").val() && $("input[name='owner_type']:checked").val() == "corporate"){
            alert("দয়া করে কর্পোরেট প্রতিষ্ঠান নির্বাচন করুন।");
            $("#corporate_institute_id").focus();
            return false;
        }

        if($("#division_id").val() != '{{$miller->division_id}}' || $("#district_id").val() != '{{$miller->district_id}}' || $("#mill_upazila_id").val() != '{{$miller->mill_upazila_id}}'){
            if(confirm('আপনার উপজেলা চেঞ্জ হয়েছে। উপজেলা চেঞ্জ হওয়ার কারণে ফর্ম নাম্বার চেঞ্জ হবে।')){
                if(confirm('আপনি কি পরিবর্তন করতে চান ?')){
					return true;
				}
            }
			else
			{
				return false;
            }
        }
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

</script>


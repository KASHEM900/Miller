<fieldset id="license_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>লাইসেন্স  ও বিদ্যুৎ এর  তথ্য <span style="color: gray;"> ( বাংলায়  পূরণ করুন )</span></b></span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">
            <form id="licenseform" action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <table>

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
                                @if($miller->license_deposit_chalan_image != '')
                                <a target="_blank" href="{{ asset('images/license_deposit_chalan_file/large/'.$miller->license_deposit_chalan_image) }}">
                                    <img width="100" height="100" src="{{ asset('images/license_deposit_chalan_file/thumb/'.$miller->license_deposit_chalan_image) }}" alt="{{$miller->license_deposit_chalan_image}}"/>
                                </a>
                                @endif

                                <input class="upload" type="file" name="license_deposit_chalan_file">
                                <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                                
                            </td>
                        </tr>

                        <tr>
                            <td>ভ্যাট জমার চালানের কপি</td>
                            <td><strong>:</strong> </td>
                            <td>
                                @if($miller->vat_file != '')
                                <a target="_blank" href="{{ asset('images/vat_file/large/'.$miller->vat_file) }}">
                                    <img width="100" height="100" src="{{ asset('images/vat_file/thumb/'.$miller->vat_file) }}" alt="{{$miller->vat_file}}"/>
                                </a>
                                @endif

                                <input class="upload" type="file" name="vat_file">
                                <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                            </td>
                        </tr>

                        <tr>

                            <td width="63%"  style="color: red;">লাইসেন্স নং<span style="color: red;"> * </span></td>

                            <td><strong>:</strong></td>

                            <td>
                                @if($miller->fps_mill_status && $miller->fps_mill_status != "insert_fail")
                                <input required readonly type="text" maxlength="99" name="license_no" id="license_no" class="form-control" value="{{$miller->license_no}}" placeholder="লাইসেন্স নং বাংলায় লিখুন" title="লাইসেন্স নম্বর ">
                                @else
                                <input required type="text" maxlength="99" name="license_no" id="license_no" class="form-control" value="{{$miller->license_no}}" placeholder="লাইসেন্স নং বাংলায় লিখুন" title="লাইসেন্স নম্বর ">
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <td>লাইসেন্সের কপি</td>
                            <td><strong>:</strong> </td>
                            <td>
                                @if($miller->license_file_of_miller != '')
                                <a target="_blank" href="{{ asset('images/license_file/large/'.$miller->license_file_of_miller) }}">
                                    <img width="100" height="100" src="{{ asset('images/license_file/thumb/'.$miller->license_file_of_miller) }}" alt="{{$miller->license_file_of_miller}}"/>
                                </a>
                                @endif

                                <input class="upload" type="file" name="license_file">
                                <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                            </td>
                        </tr>

                        <tr>

                            <td style="color: red;">লাইসেন্স প্রদানের তারিখ <span style="color: red;"> * </span></td>

                            <td><strong>:</strong></td>

                            <td><input required type="text" name="date_license" id="date_license" class="form-control date" value="{{$miller->date_license}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স প্রদানের তারিখ"></td>

                        </tr>

                        <tr>

                            <td style="color: red;">লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত <span style="color: red;"> * </span></td>

                            <td><strong>:</strong> </td>

                            <td><input required type="text" required name="date_renewal" id="date_renewal" class="form-control date" value="{{$miller->date_renewal}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত"></td>

                        </tr>

                        <tr>

                            <td>লাইসেন্স সর্বশেষ নবায়ণের তারিখ </td>

                            <td><strong>:</strong> </td>

                            <td><input type="text" name="date_last_renewal" id="date_last_renewal" class="form-control date" value="{{$miller->date_last_renewal}}" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স সর্বশেষ নবায়ণের তারিখ "></td>

                        </tr>

                        <tr>
                            <td>লাইসেন্স প্রদানকারী অফিসারের স্বাক্ষর</td>
                            <td><strong>:</strong> </td>
                            <td>
                                @if($miller->signature_file != '')
                                <a target="_blank" href="{{ asset('images/signature_file/large/'.$miller->signature_file) }}">
                                    <img width="100" height="100" src="{{ asset('images/signature_file/thumb/'.$miller->signature_file) }}" alt="{{$miller->signature_file}}"/>
                                </a>
                                @endif

                                <input class="upload" type="file" name="signature_file">
                                <td style="text-align: right;">** JPG/JPEG/PNG আপলোড করুন।</td>
                            </td>
                        </tr>

                        @if($miller->mill_type_id==2)

                            <tr>

                                <td>মিল স্থাপনের বছর </td>

                                <td><strong>:</strong> </td>

                                <td><input type="text" name="pro_flowdiagram" id="pro_flowdiagram" value="@if($miller->autometic_miller){{$miller->autometic_miller->pro_flowdiagram}} @endif" class="form-control"></td>

                            </tr>

                            <tr>

                                <td>কান্ট্রি অব অরিজিন</td>

                                <td><strong>:</strong> </td>

                                <td><input type="text" name="origin" id="origin" value="@if($miller->autometic_miller){{$miller->autometic_miller->origin}} @endif" class="form-control"></td>

                            </tr>

                            <tr>

                                <td>পরিদর্শনের তারিখ</td>

                                <td><strong>:</strong> </td>

                                <td><input type="text" name="visited_date" id="visited_date" class="form-control date" value="@if($miller->autometic_miller){{$miller->autometic_miller->visited_date}} @endif" placeholder="একটি তারিখ বাছাই করুন" title="লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত"></td>

                            </tr>

                        @endif

                        @if($miller->mill_type_id==5)

                            <tr>

                                <td>মিল স্থাপনের বছর </td>

                                <td><strong>:</strong> </td>

                                <td><input type="text" name="pro_flowdiagram" id="pro_flowdiagram" value="@if($miller->autometic_miller_new){{$miller->autometic_miller_new->pro_flowdiagram}} @endif" class="form-control"></td>

                            </tr>

                            <tr>

                                <td>কান্ট্রি অব অরিজিন</td>

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

                            <td>বিদ্যুৎ সংযোগ আছে কিনা ? <span style="color: red;"> * </span></td>

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

                        <tr>
                            <td colspan="3" id="license_btn_hide">
                                <p align="right" style="margin-top: 20px">
                                    <input type="hidden" id="license_section" name="license_section" value="form_submit">
                                    <input type="submit" id="license_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                                    <input type="button" id="license" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                                </p>
                            </td>
                        </tr>

                        <tr><td colspan="3" id="flash_autoli"></td></tr>

                        <tr><td colspan="3" align="right" id="autolicense_success" style="color: #DC2201;"></td></tr>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</fieldset>

<script>
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

</script>

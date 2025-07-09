<fieldset id="license_preview" style="display:block;">
    <div class="card">

    <div class="card-header flex justify-between">
        <span class="text-xl"> <b>লাইসেন্স এর তথ্য <span style="color: gray;"> ( বাংলায়  পূরণ করুন )</span></b></span>

        <span>
            <div align="right" class="print_hide">
                <input type="button" class="btn2 btn-primary edit-button" value="লাইসেন্স হিস্টোরি" onclick="printLicenseHistory()" />
                @if($edit_perm)
                <button id="license" class="btn2 btn-primary edit-button">এডিট</button>
                @endif
            </div>
        </span>
    </div>

    <div class="card-body">

        <table width="100%" align="center">

        <tbody>

            <tr>

                <td width="50%">লাইসেন্সের ধরন</td>

                <td><strong>:</strong></td>

                <td>@if($miller->license_fee != null){{$miller->license_fee->name}}@endif</td>

            </tr>

            <tr>

                <td>লাইসেন্স ডিপোজিট এমাউন্ট</td>

                <td><strong>:</strong> </td>

                <td>{{App\BanglaConverter::en2bn(2,$miller->license_deposit_amount)}}</td>
            </tr>

            <tr>

                <td>ফি জমার তারিখ</td>

                <td><strong>:</strong></td>

                <td>@if($miller->license_deposit_date){{App\BanglaConverter::en2bt($miller->license_deposit_date->format('d/m/Y'))}}@endif</td>

            </tr>

            <tr>

                <td>ফি জমাকৃত ব্যাংক</td>

                <td><strong>:</strong> </td>

                <td>{{$miller->license_deposit_bank}}</td>

            </tr>

            <tr>

                <td>ফি জমাকৃত ব্যাংকের শাখা</td>

                <td><strong>:</strong> </td>

                <td>{{$miller->license_deposit_branch}}</td>

            </tr>

            <tr>

                <td>চালান নং</td>

                <td><strong>:</strong> </td>

                <td>{{$miller->license_deposit_chalan_no}}</td>

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
                </td>
            </tr>

            <tr>

            <td width="50%">লাইসেন্স নং</td>

            <td><strong>:</strong></td>

            <td>{{$miller->license_no}}</td>

        </tr>

        <tr>

            <td>লাইসেন্সের কপি</td>

            <td><strong>:</strong></td>

            <td>
                @if($miller->license_file_of_miller != '')
                <a target="_blank" href="{{ asset('images/license_file/large/'.$miller->license_file_of_miller) }}">
                    <img width="100" height="100" src="{{ asset('images/license_file/thumb/'.$miller->license_file_of_miller) }}" alt="{{$miller->license_file_of_miller}}"/>
                </a>
                @endif
            </td>

        </tr>

        <tr>

            <td>লাইসেন্স প্রদানের তারিখ</td>

            <td><strong>:</strong></td>

            <td>@if($miller->date_license){{App\BanglaConverter::en2bt($miller->date_license->format('d/m/Y'))}}@endif</td>

        </tr>

        <tr>

            <td>লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত </td>

            <td><strong>:</strong> </td>

            <td>@if($miller->date_renewal){{App\BanglaConverter::en2bt($miller->date_renewal->format('d/m/Y'))}}@endif</td>

        </tr>
        <tr>

            <td>লাইসেন্স সর্বশেষ নবায়ণের তারিখ</td>

            <td><strong>:</strong> </td>

            <td>@if($miller->date_last_renewal){{App\BanglaConverter::en2bt($miller->date_last_renewal->format('d/m/Y'))}}@endif</td>

        </tr>

        <tr>

            <td>লাইসেন্স প্রদানকারী অফিসারের স্বাক্ষর</td>

            <td><strong>:</strong></td>

            <td>
                @if($miller->signature_file != '')
                <a target="_blank" href="{{ asset('images/signature_file/large/'.$miller->signature_file) }}">
                    <img width="100" height="100" src="{{ asset('images/signature_file/thumb/'.$miller->signature_file) }}" alt="{{$miller->signature_file}}"/>
                </a>
                @endif
            </td>

        </tr>

        @if($miller->mill_type_id==2)

         <tr>

            <td>মিল স্থাপনের বছর</td>

            <td><strong>:</strong></td>

            <td>@if($miller->autometic_miller){{$miller->autometic_miller->pro_flowdiagram}}@endif</td>

        </tr>

        <tr>

            <td>কান্ট্রি অব অরিজিন </td>

            <td><strong>:</strong> </td>

            <td>@if($miller->autometic_miller){{$miller->autometic_miller->origin}}@endif</td>

        </tr>

        <tr>

            <td>পরিদর্শনের তারিখ</td>

            <td><strong>:</strong> </td>

            <td>@if($miller->autometic_miller && $miller->autometic_miller->visited_date){{App\BanglaConverter::en2bt($miller->autometic_miller->visited_date->format('d/m/Y'))}}@endif</td>

        </tr>

        @endif

        @if($miller->mill_type_id==5)

            <tr>

                <td>মিল স্থাপনের বছর</td>

                <td><strong>:</strong></td>

                <td>@if($miller->autometic_miller_new){{$miller->autometic_miller_new->pro_flowdiagram}}@endif</td>

            </tr>

            <tr>

                <td>কান্ট্রি অব অরিজিন </td>

                <td><strong>:</strong> </td>

                <td>@if($miller->autometic_miller_new){{$miller->autometic_miller_new->origin}}@endif</td>

            </tr>

            <tr>

                <td>মিলিং যন্ত্রাংশ প্রস্তুতকারী কোম্পানীর নাম</td>

                <td><strong>:</strong> </td>

                <td>@if($miller->autometic_miller_new && $miller->autometic_miller_new->milling_parts_manufacturer){{$miller->autometic_miller_new->milling_parts_manufacturer}}@endif</td>

            </tr>

            <tr>

                <td>যন্ত্রাংশের প্রকৃতি</td>

                <td><strong>:</strong> </td>

                <td>@if($miller->autometic_miller_new && $miller->autometic_miller_new->milling_parts_manufacturer_type){{$miller->autometic_miller_new->milling_parts_manufacturer_type}}@endif</td>

            </tr>

        @endif

        <tr>

            <td>বিদ্যুৎ সংযোগ আছে কিনা </td>

            <td><strong>:</strong> </td>

            <td>{{$miller->is_electricity}}</td>

        </tr>



        <tr>

            <td>মিটার নং</td>

            <td><strong>:</strong> </td>

            <td>{{$miller->meter_no}}</td>

        </tr>

        <tr>

            <td>বিদ্যুৎ সংযোগের অনুমতিপত্র অনুযায়ী সর্ব নিন্ম বৈদ্যুতিক লোডিং ক্ষমতা</td>

            <td><strong>:</strong></td>

            <td>{{$miller->min_load_capacity}}</td>

        </tr>

        <tr>

            <td>বিদ্যুৎ সংযোগের অনুমতিপত্র অনুযায়ী  সর্ব উচ্চ বৈদ্যুতিক লোডিং ক্ষমতা</td>

            <td><strong>:</strong></td>

            <td>{{$miller->max_load_capacity}}</td>

        </tr>

        <tr>

            <td>বিদ্যুৎ সংযোগ এর ডকুমেন্ট</td>

            <td><strong>:</strong></td>

            <td>
                @if($miller->electricity_file_of_miller != '')
                <a target="_blank" href="{{ asset('images/electricity_file/large/'.$miller->electricity_file_of_miller) }}">
                    <img width="100" height="100" src="{{ asset('images/electricity_file/thumb/'.$miller->electricity_file_of_miller) }}" alt="{{$miller->electricity_file_of_miller}}"/>
                </a>
                @endif
            </td>
        </tr>

        <tr>

            <td>সর্বশেষ যে মাস পর্যন্ত বিদ্যুৎ বিল পরিশোধ করা হয়েছে</td>

            <td><strong>:</strong></td>

            <td>@if($miller->last_billing_month){{App\BanglaConverter::en2bt($miller->last_billing_month->format('d/m/Y'))}}@endif</td>

        </tr>

        <tr>

            <td>পরিশোধিত মাসিক গড় বিলের পরিমাণ  (টাকা)</td>

            <td><strong>:</strong></td>

            <td>{{$miller->paid_avg_bill}}</td>

        </tr>

        </tbody></table>

        </div>
    </div>
        </fieldset>

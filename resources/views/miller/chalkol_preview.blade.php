<fieldset id="chalkol_preview" style="display:block;">
    <div class="card">

    <div class="card-header flex justify-between">
        <span class="text-xl"> <b>চালকলের তথ্য  </b> ফরম নম্বর : {{App\BanglaConverter::en2bt($miller->form_no)}} </span>
        <span style="color: green" class="text-xl print_hide">
            <span><b>{{$miller->miller_stage}}</b></span>
        </span>
        @if($edit_perm)
        <div align="right" class="print_hide"><button id="chalkol" class="btn2 btn-primary edit-button">এডিট</button>  </div>
        @endif
    </div>
    <div class="card-body">

        <table width="100%" align="center" class="report_fontsize">
            <tbody>
            <tr>
                <td width="50%">চালকলের অবস্থা</td>
                <td>:</td>
                <td>
                    @if($miller->miller_status == "new_register") নতুন নিবন্ধন @elseif($miller->miller_status == "active") সচল চালকল @else বন্ধ চালকল @endif
                </td>
            </tr>
            <tr>
                <td width="50%">বন্ধের কারন</td>
                <td>:</td>
                <td>
                    {{$miller->last_inactive_reason}}
                </td>
            </tr>

            <tr>
                <td width="50%">মালিকানার ধরন</td>
                <td>:</td>
                <td>
                    @if($miller->owner_type == "corporate") কর্পোরেট @elseif($miller->owner_type == "multi") যৌথ @else একক @endif
                </td>
            </tr>
            <tr>
                <td width="50%">কর্পোরেট প্রতিষ্ঠান</td>
                <td>:</td>
                <td>
                    @if($miller->corporate_institute) {{$miller->corporate_institute->name}} @endif
                </td>
            </tr>
            
            <tr>

                <td>মিল মালিকের এনআইডি</td>

                <td><strong>:</strong></td>

                <td>{{$miller->nid_no}}</td>

            </tr>

            <tr>

                <td>জন্ম তারিখ</td>

                <td><strong>:</strong></td>

                <td>@if($miller->birth_date){{App\BanglaConverter::en2bt(\Carbon\Carbon::parse($miller->birth_date)->format('d/m/Y'))}}@endif</td>

            </tr>
            

            <tr>

                <td width="50%">বিভাগ</td>

                <td><strong>:</strong> </td>

                <td>

                    {{$miller->division->divname}}

                </td>

            </tr>
            <tr>

                <td width="50%">জেলা</td>

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

            </tr>

            <tr>

                <td>চালকলের ঠিকানা</td>

                <td><strong>:</strong></td>

                <td>{{$miller->mill_address}}</td>

            </tr>

            <tr>

                <td>মালিকের নাম</td>

                <td><strong>:</strong></td>

                <td>{{$miller->owner_name}}</td>

            </tr>
            <tr>

                <td>মালিকের নাম(ইংরেজি)</td>

                <td><strong>:</strong></td>

                <td>{{$miller->owner_name_english}}</td>

           </tr>

           <tr>

                <td>লিঙ্গ</td>

                <td><strong>:</strong></td>

                <td>
                   @if($miller->gender == "male") পুরুষ                    
                   @elseif($miller->gender == "female")মহিলা 
                   @elseif($miller->gender == "3rdGender") তৃতীয় লিঙ্গ @endif</span></td>

                </td>

            </tr>


            <tr>

                <td>পিতার নাম</td>

                <td><strong>:</strong></td>

                <td>{{$miller->father_name}}</td>

            </tr>

            <tr>

                <td>মাতার নাম</td>

                <td><strong>:</strong></td>

                <td>{{$miller->mother_name}}</td>

            </tr>

            <tr>

                <td>মালিকের ঠিকানা</td>

                <td><strong>:</strong></td>

                <td>{{$miller->owner_address}}</td>

            </tr> 

            <tr>

                <td>মালিকের জন্মস্থান</td>

                <td><strong>:</strong></td>

                <td>

                    {{$miller->district_bplace->distname}}

                </td>

            </tr>

            <tr>

                <td>মালিকের জাতীয়তা</td>

                <td><strong>:</strong></td>

                <td>{{$miller->miller_nationality}}</td>

            </tr>

            <tr>

                <td>মালিকের ধর্ম</td>

                <td><strong>:</strong></td>
                

                <td>{{$miller->miller_religion}}</td>

            </tr>     
          

            <tr>

                <td>মোবাইল নং</td>

                <td><strong>:</strong></td>

                <td>{{$miller->mobile_no}}</td>

            </tr>

            <tr>

                <td>ব্যাংক একাউন্ট</td>

                <td><strong>:</strong></td>

                <td>একাউন্ট নংঃ {{$miller->bank_account_no}}, একাউন্ট নামঃ {{$miller->bank_account_name}}, ব্যাংকের নামঃ {{$miller->bank_name}} ব্যাংকের শাখার নামঃ {{$miller->bank_branch_name}}</td>

            </tr>


            <tr>

                <td>চালের ধরন</td>

                <td><strong>:</strong></td>

                <td>@if($miller->chaltype) {{$miller->chaltype->chal_type_name}} @endif</td>

            </tr>

            <tr>

                <td>চালকলের ধরন</td>

                <td><strong>:</strong></td>

                <td>@if($miller->milltype) {{$miller->milltype->mill_type_name}} @endif</td>

            </tr>
            <tr>
                <td>চালকল মালিকের ছবি</td>

                <td><strong>:</strong></td>

                <td>
                    @if($miller->photo_of_miller != '')
                        <a target="_blank" href="{{ asset('images/photo_file/large/'.$miller->photo_of_miller) }}">
                            <img width="100" height="100" src="{{ asset('images/photo_file/thumb/'.$miller->photo_of_miller) }}" alt="{{$miller->mill_name}}"/>
                        </a>
                    @endif
                </td>

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
            </tr>

            </tbody>
        </table>

    </div>
    </div>
</fieldset>

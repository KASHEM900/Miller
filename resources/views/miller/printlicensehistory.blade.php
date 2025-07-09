@foreach($millers as $key => $miller)
@php
    $clean_address = preg_replace('/[a-zA-Z0-9]+/', '', $miller->owner_address);
    $clean_address = preg_replace("/'[^']*':\s*/", '', $clean_address);
    $clean_address = preg_replace(["/''/", "/,+/", "/'+/", "/\s+/"], ['', ',', "'", ' '], $clean_address);
    $clean_address = trim($clean_address, ",' ");
@endphp
    <div style="margin-bottom: 40px; page-break-after: always;">
        <h2 align="center">@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif
            চালকলের লাইসেন্স হিস্টোরি</h2>

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
                                    <img width="100" height="100" src="{{ asset('images/photo_file/large/'.$miller->photo_of_miller) }}" alt="{{$miller->mill_name}}"/>
                                </a>
                                @endif
                            </td>
                        </tr>
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
                            
                            <td>চালকলের ঠিকানা</td>

                            <td><strong>:</strong></td>

                            <td>{{$miller->mill_address}}</td>

                            <td>মালিকের ঠিকানা</td>

                            <td><strong>:</strong></td>

                            <td>{{$clean_address}}</td>

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

                        </tbody>
                    </table>

                </div>
            </div>
        </fieldset>

		<fieldset id="license_preview" style="display:block;">
			<div class="card">

				<div class="card-header flex justify-between">
					<div class="card-header flex justify-between">
						<span class="text-xl"><b>লাইসেন্স হিস্টোরি</b></span>
					</div>
				</div>

				<div class="card-body">

					<table width="100%" align="center" border="1" class="report_fontsize">
						<thead>
							<tr>
								<th>লাইসেন্স টাইপ</th>
								<th>লাইসেন্স নং</th>
								<th>লাইসেন্স ডিপোজিট এমাউন্ট</th>
								<th>ফি জমার তারিখ</th>
								<th>ফি জমাকৃত ব্যাংক</th>
								<th>ফি জমাকৃত ব্যাংকের শাখা</th>
								<th>চালান নং</th>
								<th>লাইসেন্স প্রদানের তারিখ</th>
								<th>লাইসেন্স যে তারিখ পর্যন্ত বৈধ/নবায়িত </th>
                                <th>লাইসেন্স সর্বশেষ নবায়ণের তারিখ </th>
								<th>হিস্টোরি তারিখ</th>
							</tr>
						</thead>
						<tbody>
							<?php $count = 1; ?>

							@foreach($miller->license_histories as $license_history)
							<tr>

								<td>@if($license_history->license_fee != null){{$license_history->license_fee->name}}@endif</td>

								<td>{{$license_history->license_no}}</td>

								<td>{{App\BanglaConverter::en2bn(2,$license_history->license_deposit_amount)}}</td>

								<td>@if($license_history->license_deposit_date){{App\BanglaConverter::en2bt($license_history->license_deposit_date->format('d/m/Y'))}}@endif</td>

								<td>{{$license_history->license_deposit_bank}}</td>

								<td>{{$license_history->license_deposit_branch}}</td>

								<td>{{$license_history->license_deposit_chalan_no}}</td>

								<td>@if($license_history->date_license){{App\BanglaConverter::en2bt($license_history->date_license->format('d/m/Y'))}}@endif</td>

								<td>@if($license_history->date_renewal){{App\BanglaConverter::en2bt($license_history->date_renewal->format('d/m/Y'))}}@endif</td>

                                <td>@if($license_history->date_last_renewal){{App\BanglaConverter::en2bt($license_history->date_last_renewal->format('d/m/Y'))}}@endif</td>

								<td>@if($license_history->created_at){{App\BanglaConverter::en2bt($license_history->created_at)}}@endif</td>
							</tr>
							<?php $count++;?>
							@endforeach

						</tbody>

					</table>

				</div>
			</div>
		</fieldset>

    </div>
@endforeach

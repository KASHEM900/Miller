@foreach($millers as $key => $miller)
    <div style="font-size: 12px; page-break-after: always;">
        <div style="float: left;">
            <img width="80" height="80" src="{{ asset('images/logo_DGF.png') }}" alt="logo_DGF"/>
        </div>
        <div style="float: right;">
            <img width="80" height="80" src="{{ asset('images/govt_logo.png') }}" alt="govt_logo"/>
        </div>

        <table width="100%">
            <tbody>
                <tr>
                    <td width="30%">
                    </td>
                    <td width="40%" align="center">
                        <p align="center">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকার
                        </p>
                        <p align="center">
                            <strong>খাদ্য ও দুর্যোগ ব্যবস্থাপনা মন্ত্রণালয়</strong>
                        </p>
                        <p align="center">
                            ফরম-২
                        </p>
                        <p align="center">
                            [অনুচ্ছেদ ৫(২) দ্রষ্টব্য]
                        </p>
                    </td>
                    <td width="30%" style="font-size: 12px;">
                        <span>ফরম নম্বর: {{App\BanglaConverter::en2bt($miller->form_no)}}</span>
                        <div style="border:1px solid black; width:140px; height: 140px;">
                            @if($miller->photo_of_miller != '')
                                <img width="140" height="140" src="{{ asset('images/photo_file/large/'.$miller->photo_of_miller) }}" alt="{{$miller->photo_of_miller}}"/>
                            @endif
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <p align="center">
                চাউল সংগ্রহ ও নিয়ন্ত্রণ আদেশ, ২০০৮ এর বিধান মোতাবেক লাইসেন্স ফরম
            </p>
            <p>
                লাইসেন্স নং: …{{$miller->license_no}}… তারিখ: …@if($miller->date_license){{App\BanglaConverter::en2bt($miller->date_license->format('d/m/Y'))}}@endif…
                চাউল সংগ্রহ ও নিয়ন্ত্রণ আদেশ, ২০০৮. এর বিধানসমূহ এবং এই লাইসেন্সের শর্তাবলী সাপেক্ষে
                জনাব: …{{$miller->owner_name}}… পিতার নাম: …{{$miller->father_name}}…
                ঠিকানা: …{{$miller->owner_address}}… থানা: …{{$miller->upazilla->upazillaname}}…
                জেলা:…{{$miller->district->distname}}… জাতীয় পরিচয়পত্র নং:…{{$miller->nid_no}}…
                কে এতদ্বারা ধান ছাটাইকরণ ও তদসংক্রান্ত ব্যবসা পরিচালনার ক্ষমতা প্রদান করা হইল।
            </p>
            <p>
                ২। লাইসেধারী নিম্নলিখিত স্থানে ধান ছাটাইকরণ ও তদসংক্রাস্ত ব্যবসা
                পরিচালনা করিবেন ।
            </p>
            <p>
                (ঠিকানা)…{{$miller->mill_address}}…
            </p>
            <p>
                বিঃ দ্রঃ- যদি একই ব্যক্তি একাধিক স্থানে ধান ছাটাইকরণের ব্যবসা করেন,
                তাহা হলে এরুপ প্রত্যেকটি স্থানের জন্য পৃথক পৃথক লাইসেন্স গ্রহণ করিতে হইবে
                এবং এরূপ প্রত্যেকটি স্থানের জন্য ৩য় অনুচ্ছেদে বর্ণিত রিটার্ণ পৃথকভাবে
                দাখিল করিতে হইবে।
            </p>
            <p>
                ৩। লাইসেন্সধারী প্রতি পক্ষকালের মধ্যে (প্রত্যেক মাসের ১লা হইতে ১৫ই এবং
                ১৬ই হহুতে মাসের শেখ তারি পর্যন্ত) চাউল সংগ্রহ ও নিয়ন্ত্রণ আদেশ, ২০০৮ এর
                আদেশের তফসিলে বর্ণিত ৩নং ফরমে সরকারের নিকট রিটার্ণ দাখিল করিবেন যাহা
                পক্ষকাল শেষ হওয়ার পর পাঁচ দিনের মধ্যে ডেপুটি কমিশনারের নিকট উহা পৌছাইতে
                হবে।
            </p>
            <p>
                ৪। লাইসেন্সধারী লাইসেন্সে বর্ণিত এলাকা বহির্ভূত স্থান হইতে কোন পরিমাণ ধান
                ক্রয় করিলে তাহা এই আদেশের তফসিলে বর্নিত ফরম-৫ অনুযায়ী এই আদেশের অধীনে
                ডেপুটি কমিশনারের নিকট অবহিত করিবেন ।
            </p>
            <p>
                ৫। সাধারণ অথবা বিশেষ আদেশ দ্বারা বাংলাদেশ সরকারের নির্দেশ অনুসারে
                লাইসেন্সধারী, ছাটা চাউল অথবা ছাটা হইতেছে এমন ধান বিশেষ রীতি-নীতি এবং
                বিশেষ মাত্রায় প্রক্রিয়াজাত করিবেন ।
            </p>
            <p>
                ৬। কি পদ্ধতিতে লাইসেন্সধারী তাহার হিসাব ও রেজিস্টার সংরক্ষণ করিবেন এবং
                কোন ভাষায় তাহার হিসাব রেজিস্টার ও রিটার্ণসমুহ লিখিতে হইবে তৎসম্পর্কে
                সরকার কর্তৃক সময়ে সময়ে প্রদত্ত নির্দেশাবলী লাইসেন্সধারী মানিয়া
                চলিবেন।
            </p>
            <p>
                ৭। হিসাব ও মওজুদ ধান বা চাউল যেখানেই থাকুক না কেন, তাহা যুক্তিসঙ্গত সকল
                সময়ে পরিদর্শনের জন্য এবং পরীক্ষার উদ্দেশ্যে এবং এ ধান বা চাউলের নমুনা
                সংগ্রহের জন্য সরকারের ক্ষমতাপ্রাপ্ত যে কোন ব্যক্তিকে লাইসেন্সধারী সব
                রকমের সুবিধাদি প্রদান করিবেন।
            </p>
            <p>
                বিঃ দ্রঃ- এই লাইসেন্স …@if($miller->date_renewal){{App\BanglaConverter::en2bt($miller->date_renewal->format('d/m/Y'))}}@endif… তারিখ পর্যন্ত বলধৎ থাকিবে
                এবং লাইসেন্স এর মেয়াদ উত্তীর্ণ হইবার ৩০ দিন পূর্বে উক্ত লাইসেন্স
                নবায়ন করিতে হইবে ।
            </p>
        </div>
        <table cellspacing="0" cellpadding="0" width="90%" align="center" border="1" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td valign="top" width="596">
                        <p>
                            <b>চালকলের বিবরণঃ</b>
                            <br />
                            ০ <b>চালকলের ধরণ:</b> @if($miller->milltype) {{$miller->milltype->mill_type_name}} @endif।
                            <br />
                            ০ <b>দৈনিক/পাক্ষিক ছাটাই ক্ষমতা:</b> <!--{{App\BanglaConverter::en2bn(0, $miller->millar_p_power)}} মেট্টিক টন ধান, --><b>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}} মেট্টিক টন চাল।</b>
                            <br />
                            ০ <b>মোটর সংখ্যা ও ক্ষমতা:</b> {{App\BanglaConverter::en2bn(0, $miller->motor_num)}} / @if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->motor_area_total)}}@endif মেট্টিক টন ধান প্রতি ঘন্টায়।
                            <br />
                            ০ <b>চাতালের পরিমাণ:</b> @if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->chatal_area_total)}}@endif<span style="color: gray;"> (বর্গ  মিটার)।
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
        <table width="100%" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td align="center"></td>
                    <td width="30%"></td>
                    <td align="center">
                        <div style="width:263px; height: 70px;">
                            @if($miller->signature_file != '')
                                <img width="263" height="70" src="{{ asset('images/signature_file/large/'.$miller->signature_file) }}" alt="{{$miller->signature_file}}"/>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center">…………………………<br />লাইসেন্সধারীর স্বাক্ষর  </td>
                    <td width="30%"></td>
                    <td align="center">……………………………………………<br />লাইসেন্স প্রদানকারী অফিসারের স্বাক্ষর ও সীলমোহর</td>
                </tr>
            </tbody>
        </table>
    </div>
@endforeach

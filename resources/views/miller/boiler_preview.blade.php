<fieldset id="boiler_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>পারবয়েলিং ইউনিটের বড় হাড়ি সমূহের তথ্য</b></span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="boiler" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <table width="100%" align="center" class="report_fontsize">

                <tbody><tr>

                <td width="50%">বড় হাড়ি সমূহের মোট সেট সংখ্যা</td>

                <td width="10"> : </td>

                <td>{{App\BanglaConverter::en2bn(0, $miller->boiler_num)}}</td>

                </tr>

                </tbody>
            </table>

            <table width="100%" align="center">

                <tbody>

                <?php $count = 1; ?>
                @foreach($miller->boiler_details as $boiler_detail)

                    <tr>

                    <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | সিলিন্ডারের ব্যসার্ধ -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->boiler_radius)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> সিলিন্ডারের উচ্চতা -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->cylinder_height)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> কনিক অংশের উচ্চতা -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->cone_height)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> আয়তন -     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $boiler_detail->boiler_volume)}} <span style="color: gray;"> (ঘন  মিটার) </span></td>

                    <td><span> সংখ্যা -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(0, $boiler_detail->qty)}} <span style="color: gray;"> টি </span></td>

                    </tr>

                    <tr><td colspan="15"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                <?php $count++;?>
                @endforeach

                </tbody></table>

                <table width="100%" align="center">

                    <tbody>
                    <tr>
                        <td width="50%">বড় হাড়ি সমূহের মোট সংখ্যা</td>

                        <td>:</td>

                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(0, $miller->areas_and_power->boiler_number_total)}}@endif<span style="color: gray;"> টি  </span></td>

                    </tr>

                    <tr>
                        <td width="50%">বড় হাড়ি সমূহের মোট আয়তন</td>

                        <td>:</td>

                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->boiler_volume_total)}}@endif<span style="color: gray;"> (ঘন  মিটার)  </span></td>

                    </tr>

                    <tr>   
                        <td>পাক্ষিক ধান ভেজানো ও ভাঁপানোর ক্ষমতা (আয়তন/১.৭৫) * ১৩ </td>

                        <td>:</td>

                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->boiler_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                    </tr>

                </tbody></table>

        </div>
    </div>
</fieldset>

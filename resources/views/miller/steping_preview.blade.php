<fieldset id="steping_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>স্টীপিং হাউসের  তথ্য</b></span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="steping" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <table width="100%" align="center" class="report_fontsize">

                <tbody><tr>

                <td width="50%">স্টীপিং হাউসের সংখ্যা</td>

                <td width="10"> : </td>

                <td>{{App\BanglaConverter::en2bn(0, $miller->steeping_house_num)}}</td>

                </tr>

                </tbody>
            </table>

            <table width="100%" align="center">

                <tbody>

                <?php $count = 1; ?>
                @foreach($miller->steeping_house_details as $steeping_house_detail)

                    <tr>

                    <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | দৈর্ঘ্য -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $steeping_house_detail->steeping_house_long)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span>প্রস্থ -     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $steeping_house_detail->steeping_house_wide)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> উচ্চতা -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $steeping_house_detail->steeping_house_height)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> আয়তন -     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $steeping_house_detail->steeping_house_volume)}} <span style="color: gray;"> (ঘন  মিটার) </span></td>

                    </tr>

                    <tr><td colspan="12"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                <?php $count++;?>
                @endforeach

                </tbody></table>

                <table width="100%" align="center">

                    <tbody><tr>
                        <td width="50%">স্টীপিং হাউসের মোট  আয়তন</td>

                        <td>:</td>

                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->steping_area_total)}}@endif<span style="color: gray;"> (ঘন  মিটার)  </span></td>

                    </tr>

                    <tr>   <td>পাক্ষিক ধান ভেজানোর ক্ষমতা (আয়তন/১.৭৫) * ৭ </td>

                        <td>:</td>

                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->steping_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                    </tr>



                </tbody></table>

        </div>
    </div>
</fieldset>

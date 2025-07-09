<fieldset id="dryer_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>পারবয়েলিং ইউনিটের ড্রায়ার সমূহের তথ্য</b></span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="dryer" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <table width="100%" align="center" class="report_fontsize">

                <tbody><tr>

                <td width="50%">ড্রায়ার সমূহের সংখ্যা</td>

                <td width="10"> : </td>

                <td>{{App\BanglaConverter::en2bn(0, $miller->dryer_num)}}</td>

                </tr>

                </tbody>
            </table>

            <table width="100%" align="center">

                <tbody>

                <?php $count = 1; ?>
                @foreach($miller->dryer_details as $dryer_detail)

                    <tr>

                    <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | দৈর্ঘ্য - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->dryer_length)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span>প্রস্থ - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->dryer_width)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> ঘনকের উচ্চতা - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->cube_height)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> পিরামিড অংশের উচ্চতা - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->pyramid_height)}} <span style="color: gray;"> (মিটার) </span></td>

                    <td><span> আয়তন - </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $dryer_detail->dryer_volume)}} <span style="color: gray;"> (ঘন  মিটার) </span></td>

                    </tr>

                    <tr><td colspan="15"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                <?php $count++;?>
                @endforeach

                </tbody></table>

                <table width="100%" align="center">

                    <tbody><tr>
                        <td width="50%">ড্রায়ার সমূহের মোট আয়তন</td>

                        <td>:</td>

                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->dryer_volume_total)}}@endif<span style="color: gray;"> (ঘন  মিটার)  </span></td>

                    </tr>

                    <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (আয়তন * ৬৫% / ১.৭৫) * ১৩ </td>

                        <td>:</td>

                        <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->dryer_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                    </tr>

                </tbody></table>

        </div>
    </div>
</fieldset>

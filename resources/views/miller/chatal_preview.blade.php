<fieldset id="chatal_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>চাতালের তথ্য</b> </span>
            @if($edit_perm)
                <span> <div align="right" class="print_hide"><button id="chatal" class="btn2 btn-primary edit-button">এডিট</button>  </div>
                </span>
            @endif
        </div>

        <div class="card-body">

                <table width="100%" align="center" class="report_fontsize">

                    <tbody><tr>

                        <td width="50%">চাতালের সংখ্যা </td>

                        <td width="10"> : </td>

                        <td>{{App\BanglaConverter::en2bn(0, $miller->chatal_num)}}</td>

                        </tr>

                    </tbody>
                </table>

                <table width="100%" align="center">

                    <tbody>

                    <?php $count = 1; ?>
                    @foreach($miller->chatal_details as $chatal_detail)

                    <tr>

                    <td><span>{{App\BanglaConverter::en2bn(0, $count)}}  | দৈর্ঘ্য</span></td><td width="10"> : </td><td style="">{{App\BanglaConverter::en2bn(2, $chatal_detail->chatal_long)}}<span style="color: gray;"> (মিটার) </span></td>

                        <td><span> প্রস্থ-     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $chatal_detail->chatal_wide)}}<span style="color: gray;"> (মিটার) </span></td>

                        <td><span> ক্ষেত্রফল- </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $chatal_detail->chatal_area)}}<span style="color: gray;"> (বর্গ  মিটার) </span></td>

                    </tr>

                    <tr><td colspan="9"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                    <?php $count++;?>
                    @endforeach

                    </tbody></table>

                    <table width="100%" align="center">

                        <tbody><tr>
                            <td width="50%">চাতালের   মোট ক্ষেত্রফল</td>

                            <td>:</td>

                            <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->chatal_area_total)}}@endif<span style="color: gray;"> (বর্গ  মিটার) </span></td>

                        </tr>

                        <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (ক্ষেত্রফল/১২৫) * ৭ </td>

                            <td>:</td>

                            <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->chatal_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                        </tr>



                    </tbody></table>

                </div>
    </div>
    </fieldset>

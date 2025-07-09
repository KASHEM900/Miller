<fieldset id="milling_unit_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b> মিলিং ইউনিটের তথ্য ( সরেজমিনে পরিদর্শনে প্রাপ্ত ) </b> </span>
            @if($edit_perm)
            <span><div align="right" class="print_hide"><button id="milling_unit" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <table width="100%" align="center" class="report_fontsize">

                <tbody>
                <tr>
                <td width="30%"></td>
                <td width="10"> : </td>
                <td width="10%">প্রতি মিনিটে</td>
                <td width="10%">প্রতি ঘন্টায় </td>
                <td width="20%">মিলিং ইউনিটের যন্ত্রপাতির ক্ষমতা</td>
                </tr>
                <tr>
                    <td width="30%">হাস্কার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                    <td width="10"> : </td>
                    <td width="10%">{{App\BanglaConverter::en2bn(2, $miller->sheller_paddy_seperator_output)}} কেজি</td>
                    <td width="10%">{{App\BanglaConverter::en2bn(2, $miller->sheller_paddy_seperator_output*60)}} কেজি</span></td>
                    <td width="20%"> হাস্কার: @if($miller->mill_milling_unit_machineries && isset($miller->mill_milling_unit_machineries[2])) {{$miller->mill_milling_unit_machineries[2]->topower}} @endif </td>
                </tr>
                <tr>
                    <td width="30%">গ্রেডার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                    <td width="10"> : </td>
                    <td width="10%">{{App\BanglaConverter::en2bn(2, $miller->whitener_grader_output)}} কেজি</td>
                    <td width="10%">{{App\BanglaConverter::en2bn(2, $miller->whitener_grader_output*60)}} কেজি</td>
                    <td width="20%"> সিল্কি পলিশার: @if($miller->mill_milling_unit_machineries && isset($miller->mill_milling_unit_machineries[6])) {{$miller->mill_milling_unit_machineries[6]->topower}} @endif </td>
                </tr>
                <tr>
                    <td width="30%">কালার শর্টার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                    <td width="10"> : </td>
                    <td width="10%">{{App\BanglaConverter::en2bn(2, $miller->colour_sorter_output)}} কেজি</td>
                    <td width="10%">{{App\BanglaConverter::en2bn(2, $miller->colour_sorter_output*60)}} কেজি</td>
                    <td width="20%"> কালার সর্টার: @if($miller->mill_milling_unit_machineries && isset($miller->mill_milling_unit_machineries[9])) {{$miller->mill_milling_unit_machineries[9]->topower}} @endif </td>
                </tr>
                                                
                <tr>
                    <td colspan="5"><div style="width: 100%; background-color: silver; height: 1px;"></div></td>
                </tr>
                <tr>   
                    <td width="50%">প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা (সবচেয়ে কম যেটি)	</td>
                    <td width="10"> : </td>
                    <td>{{App\BanglaConverter::en2bn(2, $miller->areas_and_power->milling_unit_output)}} কেজি</td>
                </tr>
                <tr>                           
                    <td>পাক্ষিক ধান ছাটাই ক্ষমতা (প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা x ৬০ x ৮ x ১৩ / ১০০০ / ০.৬৫ ) </td>
                    <td width="10"> : </td>
                    <td>{{App\BanglaConverter::en2bn(2, $miller->areas_and_power->milling_unit_power)}} মেঃ টন</td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</fieldset>

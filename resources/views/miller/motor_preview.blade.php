<fieldset id="motor_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>মটরের তথ্য</b> </span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="motor" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <table width="100%" align="center" class="report_fontsize">

            <tbody><tr>

            <td width="50%">মটরের সংখ্যা</td>

            <td width="10"> : </td>

            <td>{{App\BanglaConverter::en2bn(0, $miller->motor_num)}}</td>

            </tr>

            </tbody></table>


            <table width="100%" align="center">


        <tbody>
        <?php $count = 1; ?>
        @foreach($miller->motor_details as $motor_detail)
        <tr>

        <td><span>{{App\BanglaConverter::en2bn(0, $count)}} | অশ্বশক্তি-   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(0, $motor_detail->motor_horse_power)}}<span style="color: gray;"> </span></td>

        <td><span>হলার সংখ্যা-     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(0, $motor_detail->motor_holar_num)}}<span style="color: gray;"> </span></td>

        <td><span> ছাঁটাই ক্ষমতা-     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $motor_detail->motor_filter_power/1000)}}<span style="color: gray;"> (মেঃ টন) ধান</span></td>

        </tr>

        <tr><td colspan="9"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
        <?php $count++;?>
        @endforeach


    </tbody></table>

    <table width="100%" align="center">

        <tbody>
                <tr>
                    <td width="50%">মোট ছাটাই ক্ষমতা</td>

                    <td>:</td>

                    <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->motor_area_total)}}@endif<span style="color: gray;"> (মেঃ টন) ধান</span></td>

                </tr>

                <tr>   <td>পাক্ষিক ছাটাই ক্ষমতা (মোট ছাটাই ক্ষমতা x ৮ x ১১ ) </td>

                    <td>:</td>

                    <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->motor_power)}}@endif<span style="color: gray;"> (মেঃ টন) ধান</span></td>

                </tr>



            </tbody></table>

        </div>
    </div>
</fieldset>

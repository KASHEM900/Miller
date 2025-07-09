    <fieldset id="godown_preview" style="display:block;">
        <div class="card">

            <div class="card-header flex justify-between">
                <span class="text-xl"> <b> চালকলের গুদামের তথ্য </b></span>
                @if($edit_perm)
                <span> <div align="right" class="print_hide"><button id="godown" class="btn2 btn-primary edit-button">এডিট</button>  </div>
                </span>
                @endif
            </div>

            <div class="card-body">

                    <table width="100%" align="center" class="report_fontsize">

                        <tbody><tr>

                        <td width="50%">চালকলের গুদামের সংখ্যা </td>

                        <td width="10"> : </td>

                        <td>{{App\BanglaConverter::en2bn(0, $miller->godown_num)}}</td>

                        </tr>

                        </tbody>
                    </table>

                    <table width="100%" align="center">


                    <tbody>
                    <?php $count = 1; ?>

                    @foreach($miller->godown_details as $godown_detail)
                    <tr>

                    <td><span>{{App\BanglaConverter::en2bn(0, $count)}}| দৈর্ঘ্য-   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $godown_detail->godown_long)}}<span style="color: gray;"> (মিটার) </span></td>

                    <td><span>প্রস্থ-     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $godown_detail->godown_wide)}}<span style="color: gray;"> (মিটার) </span></td>

                    <td><span> উচ্চতা-   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $godown_detail->godown_height)}}<span style="color: gray;"> (মিটার) </span></td>

                    <td><span> আয়তন-     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $godown_detail->godown_valume)}}<span style="color: gray;"> (ঘন  মিটার) </span></td>

                    </tr>

                    <tr><td colspan="12"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>

                    <?php $count++;?>
                    @endforeach

                    </tbody></table>

                        <table width="100%" align="center">

                        <tbody>
                        <tr>
                             <td width="50%">গুদামের মোট  আয়তন</td>

                                <td>:</td>

                                <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->godown_area_total)}}@endif<span style="color: gray;"> (ঘন  মিটার) </span></td>

                         </tr>

                         <tr>   <td> গুদামের ধারণ ক্ষমতা (আয়তন/৪.০৭৭) </td>

                                <td>:</td>

                                <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->godown_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                         </tr>



                        </tbody>
                </table>
            <br/>



                <table width="100%" align="center" class="report_fontsize">

                        <tbody><tr>

                        <td width="50%">চালকলের সাইলো সংখ্যা </td>

                        <td width="10"> : </td>

                        <td>{{App\BanglaConverter::en2bn(0, $miller->godown_num)}}</td>

                        </tr>

                        </tbody>
                    </table>

                    <table width="100%" align="center">


                    <tbody>
                    <?php $count = 1; ?>

                    @foreach($miller->silo_details as $silo_detail)
                    <tr>

                    <td><span>{{App\BanglaConverter::en2bn(0, $count)}}| ব্যাসার্ধ -   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $silo_detail->silo_radius)}}<span style="color: gray;"> (মিটার) </span></td>

                    <td><span> উচ্চতা-   </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $silo_detail->silo_height)}}<span style="color: gray;"> (মিটার) </span></td>

                    <td><span> আয়তন-     </span></td><td>:</td><td style="">{{App\BanglaConverter::en2bn(2, $silo_detail->silo_volume)}}<span style="color: gray;"> (ঘন  মিটার) </span></td>

                    </tr>

                    <tr><td colspan="12"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>

                    <?php $count++;?>
                    @endforeach

                    </tbody></table>

                        <table width="100%" align="center">

                        <tbody>
                        <tr>
                             <td width="50%">সাইলোর মোট আয়তন</td>

                                <td>:</td>

                                <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->silo_area_total)}}@endif<span style="color: gray;"> (ঘন  মিটার) </span></td>

                         </tr>

                         <tr>   <td>সাইলোর ধারণ ক্ষমতা (আয়তন/১.৭৫) </td>

                                <td>:</td>

                                <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->silo_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                         </tr>

                         <tr>
                            <td width="50%">মিলের সর্বমোট ধান সংরক্ষণ ক্ষমতা (সাইলোর ধারণ ক্ষমতা + গুদামের ধারণ ক্ষমতা)</td>

                               <td>:</td>

                               <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->final_godown_silo_power)}}@endif<span style="color: gray;"> (ঘন  মিটার) </span></td>

                        </tr>

                        </tbody>
                </table>




            </div>
        </div>

    </fieldset>

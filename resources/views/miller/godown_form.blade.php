<fieldset id="godown_form" style="display:none;">
    <div class="card">

    <div class="card-header flex justify-between">
        <span class="text-xl"> <b> চালকলের গুদামের তথ্য </b></span>
        <span> <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে</span>
    </div>

    <div class="card-body">

    <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @livewire('edit-miller-godown',['godown_details' => $miller->godown_details])

        <table>

                <tbody>

                <tr>
                    <td width="62%">গুদামের মোট  আয়তন</td>

                    <td>:</td>

                    <td><input readonly type="text" name="godown_area_total" id="godown_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->godown_area_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                </tr>

                <tr>
                    <td>গুদামের ধারণ ক্ষমতা (আয়তন/৪.০৭৭) </td>

                    <td>:</td>

                    <td><input readonly type="text" name="godown_power" id="godown_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->godown_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                </tr>


                <tr>
                    <td><br /><br /></td>
                </tr>
                </tbody>
            </table>




            @livewire('edit-miller-silo',['silo_details' => $miller->silo_details])

            <table>

                    <tbody>

                    <tr>
                        <td width="62%">সাইলোর মোট আয়তন</td>

                        <td>:</td>

                        <td><input readonly type="text" name="silo_area_total" id="silo_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->silo_area_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                    </tr>

                    <tr>
                        <td>সাইলোর ধারণ ক্ষমতা (আয়তন/১.৭৫) </td>

                        <td>:</td>

                        <td><input readonly type="text" name="silo_power" id="silo_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->silo_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                    </tr>

                    <tr>
                        <td>মিলের সর্বমোট ধান সংরক্ষণ ক্ষমতা (সাইলোর ধারণ ক্ষমতা + গুদামের ধারণ ক্ষমতা) </td>

                        <td>:</td>

                        <td><input readonly type="text" name="final_godown_silo_power" id="final_godown_silo_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->final_godown_silo_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                    </tr>

                    <tr>
                        <td colspan="3" id="chal_btn_hide"><p align="right" style="margin-top: 20px">
                            <input type="submit" id="godown_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                            <input type="button" id="godown" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                        </p></td>
                    </tr>
                    <tr>
                        <td><br /><br /></td>
                    </tr>
                    </tbody>
                </table>
    </form>
    </div>
    </div>
</fieldset>

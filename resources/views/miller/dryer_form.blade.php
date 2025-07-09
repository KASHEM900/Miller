<fieldset id="dryer_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>পারবয়েলিং ইউনিটের ড্রায়ার সমূহের তথ্য</b></span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">

            <form id="dryerform" action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @livewire('edit-miller-dryer',['dryer_details' => $miller->dryer_details])

                <table>

                    <tbody><tr>   <td width="62%">ড্রায়ার সমূহের মোট আয়তন</td>

                        <td>:</td>

                    <td><input readonly type="text" name="dryer_volume_total" id="dryer_volume_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->dryer_volume_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                    </tr>

                    <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (আয়তন * ৬৫% / ১.৭৫) * ১৩ </td>

                        <td>:</td>

                    <td><input readonly type="text" name="dryer_power" id="dryer_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->dryer_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                    </tr>

                    <tr>
                        <td colspan="3" id="chal_btn_hide"><p align="right" style="margin-top: 20px">

                            <input type="submit" id="dryer_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                            <input type="button" id="dryer" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                        </p></td>
                    </tr>
                    <tr><td colspan="3" align="right" id="flash5"></td></tr>

                    <tr><td colspan="3" align="right" id="dryer_success" style="color: #DC2201;"></td></tr>

                    </tbody>
                </table>
            </form>
        </div>

    </div>
</fieldset>

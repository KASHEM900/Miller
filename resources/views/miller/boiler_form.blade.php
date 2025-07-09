<fieldset id="boiler_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>পারবয়েলিং ইউনিটের বড় হাড়ি সমূহের তথ্য</b></span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">

    <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @livewire('edit-miller-boiler',['boiler_details' => $miller->boiler_details])

            <table>

                <tbody>
                <tr>   
                    <td width="62%">বড় হাড়ি সমূহের মোট সংখ্যা</td>

                    <td>:</td>

                    <td><input readonly type="text" name="boiler_number_total" id="boiler_number_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_number_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;"> টি </span></td>

                 </tr>

                 <tr>   
                    <td width="62%">বড় হাড়ি সমূহের মোট আয়তন</td>

                    <td>:</td>

                    <td><input readonly type="text" name="boiler_volume_total" id="boiler_volume_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_volume_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                 </tr>

                 <tr>   
                     <td>পাক্ষিক ধান ভেজানো ও ভাঁপানোর ক্ষমতা (আয়তন/১.৭৫) * ১৩ </td>

                    <td>:</td>

                    <td><input readonly type="text" name="boiler_power" id="boiler_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                 </tr>

                <tr>
                    <td colspan="3" id="chal_btn_hide"><p align="right" style="margin-top: 20px">
                        <input type="submit" id="boiler_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                        <input type="button" id="boiler" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                    </p></td>
                </tr>
                <tr><td colspan="3" align="right" id="flash5"></td></tr>

                <tr><td colspan="3" align="right" id="boiler_success" style="color: #DC2201;"></td></tr>

            </tbody>
        </table>
    </form>
        </div>
    </div>
</fieldset>

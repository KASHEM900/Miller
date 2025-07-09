<fieldset id="motor_form" style="display:none;">
    <div class="card">

    <div class="card-header flex justify-between">
        <span class="text-xl"><b>মটরের তথ্য</b> </span>
        <span> <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে</span>
    </div>

    <div class="card-body">

    <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            @livewire('edit-miller-motor',['motor_details' => $miller->motor_details, 'motor_powers' => $motor_powers])

            <table>

                 <tbody><tr>   <td width="62%">মোট ছাটাই ক্ষমতা</td>

                        <td width="10"> : </td>

                        <td><input readonly type="text" name="motor_area_total" id="motor_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->motor_area_total}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(ঘন  মিটার) </span></td>

                 </tr>

                 <tr>   <td>পাক্ষিক ছাটাই ক্ষমতা (মোট ছাটাই ক্ষমতা x ৮ x ১১ ) </td>

                        <td width="10"> : </td>

                        <td><input readonly type="text" name="motor_power" id="motor_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->motor_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                </tr>
                <tr><td colspan="3" id="chal_btn_hide"><p align="center" style="margin-top: 10px;">

                        <input type="submit" id="motor_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                        <input type="button" id="motor" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
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

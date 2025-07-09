<fieldset id="chatal_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>চাতালের তথ্য</b> </span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">

        <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                @livewire('edit-miller-chatal',['chatal_details' => $miller->chatal_details])

                <table>

                    <tbody>
                        <tr>   <td width="62%">চাতালের মোট ক্ষেত্রফল <!-- <span style="color: red;"> * </span> --> </td>

                                <td>:</td>

                                <td><input readonly type="text" name="chatal_area_total" id="chatal_area_total" value="@if($miller->areas_and_power){{$miller->areas_and_power->chatal_area_total}}@endif" class="disableinput" title="অনুগ্রহ করে বাংলায় লিখুন"> <span style="font-size: 12px;">(বর্গ  মিটার) </span></td>

                        </tr>

                        <tr>   <td>পাক্ষিক ধান শুকানোর ক্ষমতা (ক্ষেত্রফল/১২৫) * ৭  <!-- <span style="color: red;"> * </span> --></td>

                                <td>:</td>

                                <td><input readonly type="text" name="chatal_power" id="chatal_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->chatal_power}}@endif" class="disableinput" title="অনুগ্রহ করে বাংলায় লিখুন"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                        </tr>
                        <tr><td colspan="3" id="chatal_btn_hide"><p align="right" style="margin-top: 10px">

                                <input type="submit" id="chatal_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                                <input type="button" id="chatal" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
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

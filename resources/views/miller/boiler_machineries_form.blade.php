<fieldset id="boiler_machineries_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>বয়লার এর যন্ত্রপাতির বিবরণ</b></span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">

            <form id="boilermachineriesform" action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <br />
                <table>
                    <tr>
                        <td>বয়লার সার্টিফিকেট</td>
                        <td><strong>:</strong> </td>
                        <td><input class="upload" type="file" name="boiler_certificate_file"></td>
                        <td style="text-align: right;color: red;">** JPG/JPEG/PNG আপলোড করুন।</td>
                    </tr>

                </table>
                <br />
                <br />

                @livewire('edit-mill-boiler-machineries',['mill_boiler_machineries' => $miller->mill_boiler_machineries])

                <table style="width:100%">
                    <tbody>
                    <tr>   
                    <td width="62%">বয়লার এর যন্ত্রপাতির সর্বমোট ক্ষমতা</td>

                        <td>:</td>

                        <td><input readonly type="text" name="boiler_machineries_steampower" id="boiler_machineries_steampower" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_machineries_steampower}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;"> (মেঃ টন) </span></td>

                    </tr>

                    <tr>   
                        <td>পাক্ষিক ধান ভাঁপানো ও ড্রায়ারে ধান শুকানোর ক্ষমতা (সর্বমোট ক্ষমতা) x ১২ x ১৩ মেঃ টন  </td>

                        <td>:</td>

                        <td><input readonly type="text" name="boiler_machineries_power" id="boiler_machineries_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->boiler_machineries_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

                    </tr>

                    <tr>
                        <td colspan="3" id="chal_btn_hide">
                            <p align="center" style="margin-top: 20px">
                                <input type="submit" id="boiler_machineries_submit" class="btn2 btn-primary" title="অনুগ্রহ করে সংরক্ষন করুন" value="সাবমিট ">
                                <input type="button" id="boiler_machineries" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                            </p>
                        </td>
                    </tr>
                    
                    </tbody>
                </table>

            </form>
        </div>
        
    </div>
</fieldset>

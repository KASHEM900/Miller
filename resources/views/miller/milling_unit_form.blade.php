<fieldset id="milling_unit_form" style="display:none;">
    <div class="card">

    <div class="card-header flex justify-between">
        <span class="text-xl"><b> মিলিং ইউনিটের তথ্য ( সরেজমিনে পরিদর্শনে প্রাপ্ত ) </b></span>
        <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে</span>
    </div>

    <div class="card-body">

    <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table>

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
                <td width="10%"><input required type="text" onchange="millingUnitCalculate()" name="sheller_paddy_seperator_output" id="sheller_paddy_seperator_output" class="form-control" value="{{App\BanglaConverter::en2bn(2, $miller->sheller_paddy_seperator_output)}}" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>
                <td width="10%"><span id="sheller_paddy_seperator_output_hour">{{($miller->sheller_paddy_seperator_output*60)}}</span></td>
                <td width="20%"> হাস্কার: <span id="mill_milling_unit_machineries_output_2">@if($miller->mill_milling_unit_machineries && isset($miller->mill_milling_unit_machineries[2])) {{$miller->mill_milling_unit_machineries[2]->topower}} @endif</span></td>
            </tr>

            <tr>

                <td width="30%">গ্রেডার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                <td width="10"> : </td>
                <td width="10%"><input required type="text" onchange="millingUnitCalculate()" name="whitener_grader_output" id="whitener_grader_output" class="form-control" value="{{App\BanglaConverter::en2bn(2, $miller->whitener_grader_output)}}" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>
                <td width="10%"><span id="whitener_grader_output_hour">{{($miller->whitener_grader_output*60)}}</span></td>
                <td width="20%">সিল্কি পলিশার: <span id="mill_milling_unit_machineries_output_6">@if($miller->mill_milling_unit_machineries && isset($miller->mill_milling_unit_machineries[6])) {{$miller->mill_milling_unit_machineries[6]->topower}} @endif</span></td>
            </tr>

            <tr>
                <td width="30%">কালার শর্টার আউটপুট (কেজিতে) <span style="color: red;"> * </span></td>
                <td width="10"> : </td>
                <td width="10%"><input required type="text" onchange="millingUnitCalculate()" name="colour_sorter_output" id="colour_sorter_output" class="form-control" value="{{App\BanglaConverter::en2bn(2, $miller->colour_sorter_output)}}" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>
                <td width="10%"><span id="colour_sorter_output_hour">{{($miller->colour_sorter_output*60)}}</span></td>
                <td width="20%"> কালার সর্টার: <span id="mill_milling_unit_machineries_output_9">@if($miller->mill_milling_unit_machineries && isset($miller->mill_milling_unit_machineries[9])) {{$miller->mill_milling_unit_machineries[9]->topower}} @endif</span></td>
            </tr>
                                                    
            <tr><td colspan="5"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>

            <tr>   
                <td width="50%">প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা (সবচেয়ে কম যেটি)	</td>

                <td width="10"> : </td>

                <td colspan="3"><input readonly type="text" name="milling_unit_output" id="milling_unit_output" value="@if($miller->areas_and_power){{$miller->areas_and_power->milling_unit_output}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"> <span style="font-size: 12px;">(কেজি) </span></td>

            </tr>

            <tr>   
                
                <td>পাক্ষিক ধান ছাটাই ক্ষমতা (প্রতি মিনিটে মোট চাল ছাটাই ক্ষমতা x ৬০ x ৮ x ১৩ / ১০০০ / ০.৬৫ ) </td>

                <td width="10"> : </td>

                <td colspan="3"><input readonly type="text" name="milling_unit_power" id="milling_unit_power" value="@if($miller->areas_and_power){{$miller->areas_and_power->milling_unit_power}}@endif" title="অনুগ্রহ করে বাংলায় লিখুন" class="disableinput" disabled="disabled"><span style="font-size: 12px;"> (মেঃ টন)</span></td>

            </tr>

            <tr>
                <td colspan="5" id="milling_unit_btn_hide" style=""><p align="right" style="margin-top: 20px">

                    <input type="submit" id="milling_unit_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                    <input type="button" id="milling_unit" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                </p></td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</div>

</fieldset>

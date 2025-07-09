<fieldset id="auto_para_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>যন্ত্রপাতির বিবরণ </b></span>
            <span> <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে</span>
        </div>

        <div class="card-body">

        <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


        <table width="100%" id="param_table">

            <tbody><tr>

            <td width="5%">ক্রঃ নং</td>

            <td align="center" width="45%">প্যারামিটার এর নাম</td>

            <td align="center" width="5%">সংখ্যা</td>

            <td align="center" width="15%">একক ক্ষমতা</td>

            <td align="center" width="15%">মোট ক্ষমতা</td>

            </tr>


            <tr>

            <td width="5%">০১.</td>

            <td><input maxlength="99" type="text" name="parameter1_name" id="parameter1_name" class="form-control" value="{{$miller->autometic_miller->parameter1_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter1_num" id="parameter1_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter1_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter1_power" id="parameter1_power" class="form-control" value="{{$miller->autometic_miller->parameter1_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter1_topower" id="parameter1_topower" class="form-control" value="{{$miller->autometic_miller->parameter1_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">০২.</td>

            <td><input maxlength="99" type="text" name="parameter2_name" id="parameter2_name" class="form-control" value="{{$miller->autometic_miller->parameter2_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter2_num" id="parameter2_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter2_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter2_power" id="parameter2_power" class="form-control" value="{{$miller->autometic_miller->parameter2_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter2_topower" id="parameter2_topower" class="form-control" value="{{$miller->autometic_miller->parameter2_topower}}"></td>

            </tr>



            <tr>

            <td width="5%">০৩.</td>

            <td><input maxlength="99" type="text" name="parameter3_name" id="parameter3_name" class="form-control" value="{{$miller->autometic_miller->parameter3_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter3_num" id="parameter3_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter3_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter3_power" id="parameter3_power" class="form-control" value="{{$miller->autometic_miller->parameter3_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter3_topower" id="parameter3_topower" class="form-control" value="{{$miller->autometic_miller->parameter3_topower}}"></td>

            </tr>



            <tr>

            <td width="5%">০৪.</td>

            <td><input maxlength="99" type="text" name="parameter4_name" id="parameter4_name" class="form-control" value="{{$miller->autometic_miller->parameter4_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter4_num" id="parameter4_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter4_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter4_power" id="parameter4_power" class="form-control" value="{{$miller->autometic_miller->parameter4_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter4_topower" id="parameter4_topower" class="form-control" value="{{$miller->autometic_miller->parameter4_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">০৫.</td>

            <td><input maxlength="99" type="text" name="parameter5_name" id="parameter5_name" class="form-control" value="{{$miller->autometic_miller->parameter5_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter5_num" id="parameter5_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter5_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter5_power" id="parameter5_power" class="form-control" value="{{$miller->autometic_miller->parameter5_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter5_topower" id="parameter5_topower" class="form-control" value="{{$miller->autometic_miller->parameter5_topower}}"></td>

            </tr>



            <tr>

            <td width="5%">০৬.</td>

            <td><input maxlength="99" type="text" name="parameter6_name" id="parameter6_name" class="form-control" value="{{$miller->autometic_miller->parameter6_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter6_num" id="parameter6_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter6_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter6_power" id="parameter6_power" class="form-control" value="{{$miller->autometic_miller->parameter6_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter6_topower" id="parameter6_topower" class="form-control" value="{{$miller->autometic_miller->parameter6_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">০৭.</td>

            <td><input maxlength="99" type="text" name="parameter7_name" id="parameter7_name" class="form-control" value="{{$miller->autometic_miller->parameter7_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter7_num" id="parameter7_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter7_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter7_power" id="parameter7_power" class="form-control" value="{{$miller->autometic_miller->parameter7_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter7_topower" id="parameter7_topower" class="form-control" value="{{$miller->autometic_miller->parameter7_topower}}"></td>

            </tr>



            <tr>

            <td width="5%">০৮.</td>

            <td><input maxlength="99" type="text" name="parameter8_name" id="parameter8_name" class="form-control" value="{{$miller->autometic_miller->parameter8_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter8_num" id="parameter8_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter8_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter8_power" id="parameter8_power" class="form-control" value="{{$miller->autometic_miller->parameter8_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter8_topower" id="parameter8_topower" class="form-control" value="{{$miller->autometic_miller->parameter8_topower}}"></td>

            </tr>



            <tr>

            <td width="5%">০৯.</td>

            <td><input maxlength="99" type="text" name="parameter9_name" id="parameter9_name" class="form-control" value="{{$miller->autometic_miller->parameter9_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter9_num" id="parameter9_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter9_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter9_power" id="parameter9_power" class="form-control" value="{{$miller->autometic_miller->parameter9_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter9_topower" id="parameter9_topower" class="form-control" value="{{$miller->autometic_miller->parameter9_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১০.</td>

            <td><input maxlength="99" type="text" name="parameter10_name" id="parameter10_name" class="form-control" value="{{$miller->autometic_miller->parameter10_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter10_num" id="parameter10_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter10_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter10_power" id="parameter10_power" class="form-control" value="{{$miller->autometic_miller->parameter10_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter10_topower" id="parameter10_topower" class="form-control" value="{{$miller->autometic_miller->parameter10_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১১.</td>

            <td><input maxlength="99" type="text" name="parameter11_name" id="parameter11_name" class="form-control" value="{{$miller->autometic_miller->parameter11_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter11_num" id="parameter11_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter11_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter11_power" id="parameter11_power" class="form-control" value="{{$miller->autometic_miller->parameter11_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter11_topower" id="parameter11_topower" class="form-control" value="{{$miller->autometic_miller->parameter11_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১২.</td>

            <td><input maxlength="99" type="text" name="parameter12_name" id="parameter12_name" class="form-control" value="{{$miller->autometic_miller->parameter12_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter12_num" id="parameter12_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter12_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter12_power" id="parameter12_power" class="form-control" value="{{$miller->autometic_miller->parameter12_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter12_topower" id="parameter12_topower" class="form-control" value="{{$miller->autometic_miller->parameter12_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১৩.</td>

            <td><input maxlength="99" type="text" name="parameter13_name" id="parameter13_name" class="form-control" value="{{$miller->autometic_miller->parameter13_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter13_num" id="parameter13_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter13_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter13_power" id="parameter13_power" class="form-control" value="{{$miller->autometic_miller->parameter13_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter13_topower" id="parameter13_topower" class="form-control" value="{{$miller->autometic_miller->parameter13_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১৪.</td>

            <td><input maxlength="99" type="text" name="parameter14_name" id="parameter14_name" class="form-control" value="{{$miller->autometic_miller->parameter14_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter14_num" id="parameter14_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter14_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter14_power" id="parameter14_power" class="form-control" value="{{$miller->autometic_miller->parameter14_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter14_topower" id="parameter14_topower" class="form-control" value="{{$miller->autometic_miller->parameter14_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১৫.</td>

            <td><input maxlength="99" type="text" name="parameter15_name" id="parameter15_name" class="form-control" value="{{$miller->autometic_miller->parameter15_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter15_num" id="parameter15_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter15_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter15_power" id="parameter15_power" class="form-control" value="{{$miller->autometic_miller->parameter15_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter15_topower" id="parameter15_topower" class="form-control" value="{{$miller->autometic_miller->parameter15_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১৬.</td>

            <td><input maxlength="99" type="text" name="parameter16_name" id="parameter16_name" class="form-control" value="{{$miller->autometic_miller->parameter16_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter16_num" id="parameter16_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter16_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter16_power" id="parameter16_power" class="form-control" value="{{$miller->autometic_miller->parameter16_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter16_topower" id="parameter16_topower" class="form-control" value="{{$miller->autometic_miller->parameter16_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১৭.</td>

            <td><input maxlength="99" type="text" name="parameter17_name" id="parameter17_name" class="form-control" value="{{$miller->autometic_miller->parameter17_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter17_num" id="parameter17_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter17_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter17_power" id="parameter17_power" class="form-control" value="{{$miller->autometic_miller->parameter17_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter17_topower" id="parameter17_topower" class="form-control" value="{{$miller->autometic_miller->parameter17_topower}}"></td>

            </tr>


            <tr>

            <td width="5%">১৮.</td>

            <td><input maxlength="99" type="text" name="parameter18_name" id="parameter18_name" class="form-control" value="{{$miller->autometic_miller->parameter18_name}}"></td>

            <td><input maxlength="4" type="text" name="parameter18_num" id="parameter18_num" size="3" class="form-control" value="{{$miller->autometic_miller->parameter18_num}}"></td>

            <td><input maxlength="30" type="text" name="parameter18_power" id="parameter18_power" class="form-control" value="{{$miller->autometic_miller->parameter18_power}}"></td>

            <td><input maxlength="30" type="text" name="parameter18_topower" id="parameter18_topower" class="form-control" value="{{$miller->autometic_miller->parameter18_topower}}"></td>

            </tr>

            <tr>

            <td width="5%">১৯.</td>

            <td><input maxlength="99" type="text" name="parameter19_name" id="parameter19_name" class="form-control" value="{{$miller->autometic_miller->parameter19_name}}"></td>

            <td colspan="3" align="center"><input maxlength="30" type="text" name="parameter19_topower" id="parameter19_topower" class="form-control" value="{{$miller->autometic_miller->parameter19_topower}}"></td>

            </tr>

            <tr>
                <td colspan="3" id="auto_para_btn_hide"><p align="right" style="margin-top: 20px">
                    <input type="hidden" id="auto_para_section" name="auto_para_section" value="form_submit">
                    <input type="submit" id="auto_para_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                    <input type="button" id="auto_para" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                </p></td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
    </div>
</fieldset>

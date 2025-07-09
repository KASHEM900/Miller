<fieldset id="autometic_mechin_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>যন্ত্রপাতির বিবরণ </b> </span>
            <span><div align="right"> <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </div>
            </span>
        </div>

        <div class="card-body">

        <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

        <table width="100%" align="center">

            <tr>

            <td width="5%">ক)</td>

            <td><strong>:</strong></td>

            <td>
                <textarea maxlength="255" class="form-control" name="machineries_a"  id="machineries_a">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_a}}@endif</textarea>
            </td>

        </tr>

        <tr> <td colspan="3" align="right" id="errorMsgMachi"></td></tr>

         <tr>

            <td >খ)</td>

            <td><strong>:</strong></td>

            <td> <textarea maxlength="255" class="form-control" name="machineries_b" id="machineries_b" >@if($miller->autometic_miller){{$miller->autometic_miller->machineries_b}}@endif</textarea>

            </td>

        </tr>

         <tr>

            <td>গ)</td>

            <td><strong>:</strong></td>

            <td> <textarea maxlength="255" class="form-control" name="machineries_c" id="machineries_c">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_c}}@endif</textarea>

            </td>

        </tr>

        <tr>

            <td>ঘ)</td>

            <td><strong>:</strong></td>

            <td> <textarea maxlength="255" class="form-control" name="machineries_d" id="machineries_d">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_d}}@endif</textarea>

            </td>

        </tr>

        <tr>

            <td>ঙ)</td>

            <td><strong>:</strong></td>

            <td> <textarea maxlength="255" class="form-control" name="machineries_e" id="machineries_e" >@if($miller->autometic_miller){{$miller->autometic_miller->machineries_e}}@endif</textarea>

            </td>

        </tr>

        <tr>

            <td>চ)</td>

            <td><strong>:</strong></td>

            <td> <textarea maxlength="255" class="form-control" name="machineries_f" id="machineries_f">@if($miller->autometic_miller){{$miller->autometic_miller->machineries_f}}@endif</textarea>

            </td>

        </tr>

        <tr>
            <td colspan="3" id="autometic_mechin_btn_hide"><p align="right" style="margin-top: 20px">
                <input type="hidden" id="autometic_mechin_section" name="autometic_mechin_section" value="form_submit">
                <input type="submit" id="autometic_mechin_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                <input type="button" id="autometic_mechin" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
            </p></td>
        </tr>
        </tbody>
    </table>
</form>
</div>
</div>
</fieldset>

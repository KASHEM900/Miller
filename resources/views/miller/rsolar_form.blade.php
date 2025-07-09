<fieldset id="rsolar_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>রাবার শেলার ও রাবার পলিশারের তথ্য</b> </span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">

    <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table>

        <tbody>
        <tr>

            <td width="80%">রাবার শেলার ও রাবার পলিশার আছে কিনা?<span style="color: red;"> * </span></td>

            <td width="10"> : </td>

            <td><select id="is_rubber_solar" name="is_rubber_solar"  class="form-control">

                <option value="হ্যা" {{ ( $miller->is_rubber_solar == "হ্যা") ? 'selected' : '' }}>হ্যা</option>
                <option value="না" {{ ( $miller->is_rubber_solar == "না") ? 'selected' : '' }}>না</option>

            </select></td>

        </tr>
        <tr>

            <td colspan="3" id="rsolar_btn_hide"><p align="right" style="margin-top: 20px">




            <input type="submit" id="rsolar_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
            <input type="button" id="rsolar" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
            </p></td>
        </tr>

        <tr><td align="right" colspan="3" id="errorMsgrsolar"></td></tr>

        <tr><td colspan="3" id="flash8"></td></tr>

        <tr><td colspan="3" align="right" id="rsolar_success" style="color: #DC2201;"></td></tr>

        </tbody></table>

    </form>
        </div>
    </div>
</fieldset>

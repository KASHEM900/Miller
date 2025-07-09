<fieldset id="boiller_form" style="display:none;">
    <div class="card">

    <div class="card-header flex justify-between">
        <span class="text-xl"><b>বয়লারের তথ্য </b></span>
        <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে</span>
    </div>

    <div class="card-body">

    <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table>

            <tbody><tr>

                <td width="50%">বয়লারের সংখ্যা <span style="color: red;"> * </span></td>

                <td width="10"> : </td>

                <td><input type="text" name="boiller_num" id="boiller_num" class="form-control" value="{{App\BanglaConverter::en2bn(0, $miller->boiller_num)}}" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>

            </tr>

            <tr>

                <td>বয়লারে স্বয়ংক্রিয় সেফটি ভালভ আছে কিনা ?<span style="color: red;"> * </span></td>

                <td width="10"> : </td>

                <td>

                    <select id="is_safty_vulve" name="is_safty_vulve" class="form-control">
                        <option value="হ্যা" {{ ( $miller->is_safty_vulve == "হ্যা") ? 'selected' : '' }}>হ্যা</option>
                        <option value="না" {{ ( $miller->is_safty_vulve == "না") ? 'selected' : '' }}>না</option>
                    </select>

                </td>

            </tr>

            <tr>

                <td>বয়লারে চাপমাপক যন্ত্র আছে কিনা ?<span style="color: red;"> * </span></td>

                <td width="10"> : </td>

                <td>
                    <select id="is_presser_machine" name="is_presser_machine" class="form-control">
                        <option value="হ্যা" {{ ( $miller->is_presser_machine == "হ্যা") ? 'selected' : '' }}>হ্যা</option>
                        <option value="না" {{ ( $miller->is_presser_machine == "না") ? 'selected' : '' }}>না</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td colspan="3" id="boiller_btn_hide" style=""><p align="right" style="margin-top: 20px">



                    <input type="submit" id="boiller_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                    <input type="button" id="boiller" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                </p></td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</div>

</fieldset>

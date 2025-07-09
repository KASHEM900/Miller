<fieldset id="chimni_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>চিমনীর তথ্য</b> </span>
            <span> <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে</span>
        </div>

        <div class="card-body">

        <form action="{{ route('millers.update', $miller->miller_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                <table>

                <tbody><tr>

                <td width="60%">চিমনীর উচ্চতা (মিটার) <span style="color: red;"> * </span></td>

                <td width="10"> : </td>

                <td><input type="text" name="chimney_height" id="chimney_height" class="form-control" value="{{App\BanglaConverter::en2bn(2, $miller->chimney_height)}}" onkeydown="checkbanglainput(event)" placeholder="অনুগ্রহ করে বাংলায় লিখুন"></td>

                </tr>

                <tr>
                    <td colspan="3" id="chimni_btn_hide"><p align="right" style="margin-top: 20px">



                        <input type="submit" id="chimni_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                        <input type="button" id="chimni" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                    </p></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    </div>
</fieldset>


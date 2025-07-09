<fieldset id="p_power_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">

        <form action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <table>

               <tbody><tr>

                <td width="50%" ><b style="background-color:#0ee60e;">চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></td>

                <td>: </td>

                <td><b style="background-color:#0ee60e;">{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}} মেট্টিক টন চাল</b> &nbsp; &nbsp; &nbsp;(সবচেয়ে কম পাক্ষিক ক্ষমতাই হলো ধানের পাক্ষিক ক্ষমতাঃ <b>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power)}}মেট্টিক টন ধান </b> )</td>

                </tr>

                <tr>
                    <td><b>চালকলের পাক্ষিক ছাঁটাই ক্ষমতা অনুমোদন ফাইল</b></td>
                    <td><strong>:</strong> </td>
                    <td><input class="upload" type="file" name="miller_p_power_approval_file"></td>
                </tr>

                <tr>
                    <td><b>চালকলের তথ্য সম্পূর্ণ ?</b></td>
                    <td>:</td>
                    <td>
                        <input required type="radio" name="cmp_status" value="1" {{ ( $miller->cmp_status == "1") ? 'checked' : '' }}>&nbsp;সম্পূর্ণ&nbsp;&nbsp;
                        <input required type="radio" name="cmp_status" value="0" {{ ( $miller->cmp_status != "1") ? 'checked' : '' }}>&nbsp;অসম্পূর্ণ&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                <td colspan="3" id="chal_btn_hide"><p align="right" style="margin-top: 20px">

                        <input type="submit" id="p_power_submit" class="btn2 btn-primary" title="অনুগ্রহ করে  সংরক্ষন করুন" value="সাবমিট ">
                        <input type="button" id="p_power" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
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

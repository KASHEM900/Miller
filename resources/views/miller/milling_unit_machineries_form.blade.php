<fieldset id="milling_unit_machineries_form" style="display:none;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>মিলিং ইউনিটের যন্ত্রপাতির বিবরণ</b></span>
            <span><span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </span>
        </div>

        <div class="card-body">

            <form id="MillingUnitMachineriesForm" action="{{ route('millers.update',$miller->miller_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <table width="100%">
                    <tbody>
                    
                    <tr>

                    <!-- <td width="5%"><b>ক্রঃ নং</b></td> -->

                    <td align="left" width="15%"><b> যন্ত্রাংশের নাম</b></td>

                    <td align="left" width="10%"><b> ব্রান্ডের নাম</b></td>

                    <td align="left" width="10%"><b> প্রস্তুতকারী দেশ</b></td>

                    <td align="left" width="15%"><b> আমদানির তারিখ</b></td>

                    <td align="left" width="10%"><b> সংযোগের প্রকৃতি (সমান্তরাল/অনুক্রম)</b></td>

                    <td align="center" width="5%"><b>সংখ্যা</b></td>

                    <td align="center" width="10%"><b>একক ক্ষমতা</b></td>

                    <td align="center" width="10%"><b>মোট ক্ষমতা</b></td>

                    <td align="center" width="10%"><b>ব্যবহৃত মোটরের মোট অশ্ব ক্ষমতা</b></td>

                    </tr>

                    <?php $count = 0; ?>
                    @foreach($milling_unit_machinery as $mill_milling_unit_machinery)
                        <tr>

                        <!-- <td width="5%">০১.</td> -->

                        <td><input type="text" name="milling_unit_machinery_name[]" id="milling_unit_machinery_name{{$count}}" class="form-control" value="{{$mill_milling_unit_machinery->name}}">
                            <input type="hidden" name="milling_unit_machinery_machinery_id[]" value="{{$mill_milling_unit_machinery->machinery_id}}" />
                            <input type="hidden" name="mill_milling_unit_machinery_id[]" value="{{$mill_milling_unit_machinery->mill_milling_unit_machinery_id}}" /></td>
                        <td><input type="text" name="milling_unit_machinery_brand[]" id="milling_unit_machinery_brand{{$count}}" class="form-control" value="{{$mill_milling_unit_machinery->brand}}"></td>
                        <td><input type="text" name="milling_unit_machinery_manufacturer_country[]" id="milling_unit_machinery_manufacturer_country{{$count}}" class="form-control" value="{{$mill_milling_unit_machinery->manufacturer_country}}"></td>
                        <td><input type="text" name="milling_unit_machinery_import_date[]" id="milling_unit_machinery_import_date{{$count}}" class="form-control date" value="{{$mill_milling_unit_machinery->import_date}}" placeholder="একটি তারিখ বাছাই করুন" title="আমদানির তারিখ"></td>
                        <td>
                            <select required name="milling_unit_machinery_join_type[]" id="milling_unit_machinery_join_type{{$count}}" class="form-control" size="1"
                                title="অনুগ্রহ করে সংযোগের প্রকৃতি বাছাই করুন" onchange="millUnitMachineriesCalculate({{$count}})">
                                <option value="সমান্তরাল" {{ ( $mill_milling_unit_machinery->join_type == "সমান্তরাল") ? 'selected' : '' }}> সমান্তরাল</option>
                                <option value="অনুক্রম" {{ ( $mill_milling_unit_machinery->join_type == "অনুক্রম") ? 'selected' : '' }}> অনুক্রম</option>
                            </select>
                        </td>
                        <td><input type="text" name="milling_unit_machinery_num[]" id="milling_unit_machinery_num{{$count}}" maxlength="4" class="form-control" size="3" class="form-control" value="{{App\BanglaConverter::en2bn(0, $mill_milling_unit_machinery->num)}}" onchange="millUnitMachineriesCalculate({{$count}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
                        <td><input type="text" name="milling_unit_machinery_power[]" id="milling_unit_machinery_power{{$count}}" maxlength="30" class="form-control" value="{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery->power)}}" onchange="millUnitMachineriesCalculate({{$count}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
                        <td><input type="text" name="milling_unit_machinery_topower[]" id="milling_unit_machinery_topower{{$count}}" readonly maxlength="30" class="form-control" value="{{$mill_milling_unit_machinery->topower}}"></td>
                        <td><input type="text" name="milling_unit_machinery_horse_power[]" id="milling_unit_machinery_horse_power{{$count}}" maxlength="30" class="form-control" value="{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery->horse_power)}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>

                        </tr>
                        
                        <?php $count++;?>
                    @endforeach

                    <tr>
                        <td>মন্তব্য</td>
                        <td colspan="8"><textarea maxlength="99" name="milling_unit_comment" id="milling_unit_comment" class="form-control">{{$miller->milling_unit_comment}}</textarea></td>
                    </tr>
                    </tbody>
                </table>        
                <table style="width:100%">
                    <tbody>
                    <tr>
                        <td colspan="3" id="chal_btn_hide">
                            <p align="center" style="margin-top: 20px">
                                <input type="submit" id="milling_unit_machineries_submit" class="btn2 btn-primary" title="অনুগ্রহ করে সংরক্ষন করুন" value="সাবমিট ">
                                <input type="button" id="milling_unit_machineries" class="btn2 btn-secondary close-button" value="বন্ধ করুন" />
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</fieldset>

<script>

$("#MillingUnitMachineriesForm").on('submit', function() {
    // var topwers = document.getElementsByName('milling_unit_machinery_topower[]');
    // var prev = 9999999999.99;
    // for (var i = 0; i <topwers.length; i++) {
    //     if(parseFloat(topwers[i].value) > prev){
    //         alert("দয়া করে আগের ধাপ থেকে ছোট সংখ্যা দিন।");
    //         $("#milling_unit_machinery_topower"+(i+1)).focus();
    //         return false;
    //     }
        
    //     if(parseFloat(topwers[i].value))
    //         prev = parseFloat(topwers[i].value);
    // }

    return true;
});

</script>


<div>

    <table width="100%" class="mx-2">

        <tbody><tr>

            <td width="50%">বড় হাড়ি সমূহের মোট সেট সংখ্যা <!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input readonly type="text" name="boiler_num" id="boiler_num" value="{{count($boiler_details)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে স্টীপিং হাউসের  সংখ্যা বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle text-xl text-blue-400 px-2 py-1 cursor-pointer" />
            </td>
            </tr>

        </tbody>
    </table>

    <table width="100%" id="boiler_fields">

        <tbody>
        <?php $count = 1; ?>
        @foreach($boiler_details as $row)
        <tr wire:key="{{$loop->index}}">

            <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}} | সিলিন্ডারের ব্যসার্ধ</span><span style="font-size: 10px;">(মিটার) </span></td><td>:</td><td>
            @if($row && $row['boiler_radius'])
            <input onchange="boilerCalculate({{$count}})" id="boiler_radius{{$count}}" size="9" type="text" name="boiler_radius[]" value="{{App\BanglaConverter::en2bn(2, $row['boiler_radius'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="boilerCalculate({{$count}})" id="boiler_radius{{$count}}" size="9" type="text" name="boiler_radius[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            </td>

            <td><span class="four_blocks">সিলিন্ডারের উচ্চতা</span><span style="font-size: 10px;">(মিটার) </span></td><td>:</td><td>
            @if($row && $row['cylinder_height'])
            <input onchange="boilerCalculate({{$count}})" id="cylinder_height{{$count}}" size="9" type="text" name="cylinder_height[]" value="{{App\BanglaConverter::en2bn(2, $row['cylinder_height'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="boilerCalculate({{$count}})" id="cylinder_height{{$count}}" size="9" type="text" name="cylinder_height[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            </td>

            <td><span class="four_blocks">কনিক অংশের উচ্চতা</span><span style="font-size: 10px;">(মিটার) </span></td><td>:</td><td>
            @if($row && $row['cone_height'])
            <input onchange="boilerCalculate({{$count}})" id="cone_height{{$count}}" size="9" type="text" name="cone_height[]" value="{{App\BanglaConverter::en2bn(2, $row['cone_height'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="boilerCalculate({{$count}})" id="cone_height{{$count}}" size="9" type="text" name="cone_height[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            </td>

            <td><span class="four_blocks">আয়তন</span><span style="font-size: 10px;">(ঘন  মিটার) </span></td><td>:</td>
            <td>
                @if($row && $row['boiler_volume'])
                <input id="boiler_volume{{$count}}" size="9" readonly type="text" name="boiler_volume[]" value="{{$row['boiler_volume']}}" class="disableinput" disabled="disabled">
                @else
                <input id="boiler_volume{{$count}}" size="9" readonly type="text" name="boiler_volume[]" value="" class="disableinput" disabled="disabled">
                @endif
            </td>

            <td><span class="four_blocks">সংখ্যা</span></td><td>:</td><td>
            @if($row && $row['qty'])
            <input onchange="boilerCalculate({{$count}})" id="qty{{$count}}" size="9" type="text" name="qty[]" value="{{App\BanglaConverter::en2bn(0, $row['qty'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
            @else
            <input onchange="boilerCalculate({{$count}})" id="qty{{$count}}" size="9" type="text" name="qty[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
            @endif
            <td>
                <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                @if($row && $row['boiler_id'])
                <input type="hidden" name="boiler_id[]" value="{{$row['boiler_id']}}" />
                @else
                <input type="hidden" name="boiler_id[]" value="" />
                @endif
            </td>

        </tr>
        <?php $count++;?>
        @endforeach
        </tbody>
    </table>

</div>

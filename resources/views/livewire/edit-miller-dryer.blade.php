<div>

    <table width="100%" class="mx-2">

        <tbody><tr>

            <td width="50%">ড্রায়ার সমূহের সংখ্যা <!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input readonly type="text" name="dryer_num" id="dryer_num" value="{{count($dryer_details)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে স্টীপিং হাউসের  সংখ্যা বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle text-xl text-blue-400 px-2 py-1 cursor-pointer" />
            </td>
            </tr>

        </tbody>
    </table>

    <table width="100%" id="dryer_fields">

        <tbody>
        <?php $count = 1; ?>
        @foreach($dryer_details as $row)
        <tr wire:key="{{$loop->index}}">

            <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}} । দৈর্ঘ্য</span><span style="font-size: 10px;">(মিটার) </span></td><td>:</td><td>
            @if($row && $row['dryer_length'])
            <input onchange="dryerCalculate({{$count}})" id="dryer_length{{$count}}" size="9" type="text" name="dryer_length[]" value="{{App\BanglaConverter::en2bn(2, $row['dryer_length'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="dryerCalculate({{$count}})" id="dryer_length{{$count}}" size="9" type="text" name="dryer_length[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            </td>

            <td><span class="four_blocks">প্রস্থ</span><span style="font-size: 10px;">(মিটার) </span></td><td>:</td><td>
            @if($row && $row['dryer_width'])
            <input onchange="dryerCalculate({{$count}})" id="dryer_width{{$count}}" size="9" type="text" name="dryer_width[]" value="{{App\BanglaConverter::en2bn(2, $row['dryer_width'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="dryerCalculate({{$count}})" id="dryer_width{{$count}}" size="9" type="text" name="dryer_width[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            </td>

            <td><span class="four_blocks">ঘনকের উচ্চতা</span><span style="font-size: 10px;">(মিটার) </span></td><td>:</td><td>
            @if($row && $row['cube_height'])
            <input onchange="dryerCalculate({{$count}})" id="cube_height{{$count}}" size="9" type="text" name="cube_height[]" value="{{App\BanglaConverter::en2bn(2, $row['cube_height'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="dryerCalculate({{$count}})" id="cube_height{{$count}}" size="9" type="text" name="cube_height[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            </td>

            <td><span class="four_blocks">পিরামিড অংশের উচ্চতা</span><span style="font-size: 10px;">(মিটার) </span></td><td>:</td><td>
            @if($row && $row['pyramid_height'])
            <input onchange="dryerCalculate({{$count}})" id="pyramid_height{{$count}}" size="9" type="text" name="pyramid_height[]" value="{{App\BanglaConverter::en2bn(2, $row['pyramid_height'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="dryerCalculate({{$count}})" id="pyramid_height{{$count}}" size="9" type="text" name="pyramid_height[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            </td>

            <td><span class="four_blocks">আয়তন</span><span style="font-size: 10px;">(ঘন  মিটার) </span></td><td>:</td>
            <td>
            @if($row && $row['dryer_volume'])
            <input id="dryer_volume{{$count}}" size="9" readonly type="text" name="dryer_volume[]" value="{{$row['dryer_volume']}}" class="disableinput" disabled="disabled">
            @else
            <input id="dryer_volume{{$count}}" size="9" readonly type="text" name="dryer_volume[]" value="" class="disableinput" disabled="disabled">
            @endif
            </td>

            <td>
                <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                @if($row && $row['dryer_id'])
                <input type="hidden" name="dryer_id[]" value="{{$row['dryer_id']}}" />
                @else
                <input type="hidden" name="dryer_id[]" value="" />
                @endif
            </td>

        </tr>
        <?php $count++;?>
        @endforeach
        </tbody>
</table>

</div>

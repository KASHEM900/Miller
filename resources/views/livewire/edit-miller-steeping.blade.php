<div>

    <table width="100%" class="mx-2">

        <tbody><tr>

            <td width="50%">স্টীপিং হাউসের সংখ্যা <!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input readonly type="text" name="steping_num" id="steping_num" value="{{count($steeping_house_details)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে স্টীপিং হাউসের  সংখ্যা বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle text-xl text-blue-400 px-2 py-1 cursor-pointer" />
            </td>
            </tr>

            </tbody>
    </table>

    <table width="100%" id="steping_fields">

        <tbody>
        <?php $count = 1; ?>
        @foreach($steeping_house_details as $row)
        <tr wire:key="{{$loop->index}}">

            <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}} । দৈর্ঘ্য - </span></td><td>:</td><td>
            @if($row && $row['steeping_house_long'])  
            <input onchange="steepingCalculate({{$count}})" id="steeping_house_long{{$count}}" size="9" type="text" name="steeping_house_long[]" value="{{App\BanglaConverter::en2bn(2, $row['steeping_house_long'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="steepingCalculate({{$count}})" id="steeping_house_long{{$count}}" size="9" type="text" name="steeping_house_long[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            <span style="font-size: 10px;">(মিটার) </span></td>

            <td><span class="four_blocks">প্রস্থ - </span></td><td>:</td><td>
            @if($row && $row['steeping_house_wide'])  
            <input onchange="steepingCalculate({{$count}})" id="steeping_house_wide{{$count}}" size="9" type="text" name="steeping_house_wide[]" value="{{App\BanglaConverter::en2bn(2, $row['steeping_house_wide'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="steepingCalculate({{$count}})" id="steeping_house_wide{{$count}}" size="9" type="text" name="steeping_house_wide[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            <span style="font-size: 10px;">(মিটার) </span></td>

            <td><span class="four_blocks">উচ্চতা - </span></td><td>:</td><td>
            @if($row && $row['steeping_house_height'])  
            <input onchange="steepingCalculate({{$count}})" id="steeping_house_height{{$count}}" size="9" type="text" name="steeping_house_height[]" value="{{App\BanglaConverter::en2bn(2, $row['steeping_house_height'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="steepingCalculate({{$count}})" id="steeping_house_height{{$count}}" size="9" type="text" name="steeping_house_height[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            <span style="font-size: 10px;">(মিটার) </span></td>

            <td><span class="four_blocks">আয়তন - </span></td><td>:</td>
            <td>
            @if($row && $row['steeping_house_volume'])  
            <input id="steeping_house_volume{{$count}}" size="9" readonly type="text" name="steeping_house_volume[]" value="{{$row['steeping_house_volume']}}" class="disableinput" disabled="disabled">
            @else
            <input id="steeping_house_volume{{$count}}" size="9" readonly type="text" name="steeping_house_volume[]" value="" class="disableinput" disabled="disabled">
            @endif
            <span style="font-size: 10px;">(ঘন  মিটার) </span></td>

            <td>
                <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                @if($row && $row['steeping_house_id'])  
                <input type="hidden" name="steeping_house_id[]" value="{{$row['steeping_house_id']}}" />
                @else
                <input type="hidden" name="steeping_house_id[]" value="" />
                @endif
            </td>

        </tr>
        <?php $count++;?>
        @endforeach
        </tbody>
</table>

</div>

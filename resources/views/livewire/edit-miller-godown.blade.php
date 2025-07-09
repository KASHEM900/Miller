<div>

    <table width="100%" class="mx-2">

        <tbody>
            <tr>

            <td width="50%">চালকলের গুদামের সংখ্যা<!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input readonly type="text" name="godown_num" id="godown_num" value="{{count($godown_details)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে গুদামের  সংখ্যা বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle px-2 py-1 text-xl text-blue-400 cursor-pointer" />
            </td>
            </tr>

        </tbody>
    </table>

    <table width="100%" id="godown_fields">

        <tbody>
        <?php $count = 1; ?>
        @foreach($godown_details as $row)
        <tr wire:key="{{$loop->index}}">

            <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}} । দৈর্ঘ্য - </span></td><td>:</td><td>
            @if($row && $row['godown_long'])    
            <input onchange="godownCalculate({{$count}})" id="godown_long{{$count}}" size="9" type="text" name="godown_long[]" value="{{App\BanglaConverter::en2bn(2, $row['godown_long'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="godownCalculate({{$count}})" id="godown_long{{$count}}" size="9" type="text" name="godown_long[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
            <span style="font-size: 10px;">(মিটার) </span></td>

            <td><span class="four_blocks">প্রস্থ - </span></td><td>:</td><td>
            @if($row && $row['godown_wide'])    
                <input onchange="godownCalculate({{$count}})" id="godown_wide{{$count}}" size="9" type="text" name="godown_wide[]" value="{{App\BanglaConverter::en2bn(2, $row['godown_wide'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="godownCalculate({{$count}})" id="godown_wide{{$count}}" size="9" type="text" name="godown_wide[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
                <span style="font-size: 10px;">(মিটার) </span></td>

            <td><span class="four_blocks">উচ্চতা - </span></td><td>:</td><td>
            @if($row && $row['godown_height'])    
                <input onchange="godownCalculate({{$count}})" id="godown_height{{$count}}" size="9" type="text" name="godown_height[]" value="{{App\BanglaConverter::en2bn(2, $row['godown_height'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else
            <input onchange="godownCalculate({{$count}})" id="godown_height{{$count}}" size="9" type="text" name="godown_height[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @endif
                <span style="font-size: 10px;">(মিটার) </span></td>

            <td><span class="four_blocks">আয়তন - </span></td><td>:</td><td>
            @if($row && $row['godown_valume'])    
                <input id ="godown_valume{{$count}}" size="9" readonly type="text" name="godown_valume[]" value="{{$row['godown_valume']}}" class="disableinput" disabled="disabled">
            @else
            <input id ="godown_valume{{$count}}" size="9" readonly type="text" name="godown_valume[]" value="" class="disableinput" disabled="disabled">
            @endif
                <span style="font-size: 10px;">(ঘন  মিটার) </span></td>

            <td>
                <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                @if($row && $row['godown_id'])    
                <input type="hidden" name="godown_id[]" value="{{$row['godown_id']}}" />
                @else
                <input type="hidden" name="godown_id[]" value="" />
                @endif
            </td>

        </tr>
        <?php $count++;?>
        @endforeach

        </tbody>
</table>

</div>


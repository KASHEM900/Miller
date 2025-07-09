<div>
    <table width="100%" class="mx-2">

        <tbody><tr>

            <td width="50%">চাতালের সংখ্যা <!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input readonly type="text" name="chatal_num" id="chatal_num" value="{{count($chatal_details)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে চাতালের সংখ্যা বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle text-xl text-blue-400 px-2 py-1 cursor-pointer" />
            </td>

            </tr>

        </tbody>
    </table>

    <table width="100%" id="chatal_fields">

        <tbody>
          <?php $count = 1; ?>
            @foreach($chatal_details as $row)
            <tr wire:key="{{$loop->index}}">

                <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}} । দৈর্ঘ্য - </span>
                <!-- <span style="color: red;"> * </span> --></td><td>:</td><td>
                @if($row && $row['chatal_long'])
                <input onkeydown="checkbanglainput(event)" onchange="chatalCalculate({{$count}}) "id ="chatal_long{{$count}}" size="10" type="text" name="chatal_long[]" value="{{App\BanglaConverter::en2bn(2, $row['chatal_long'])}}" class="bangla_input" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
                @else
                <input onkeydown="checkbanglainput(event)" onchange="chatalCalculate({{$count}}) "id ="chatal_long{{$count}}" size="10" type="text" name="chatal_long[]" value="" class="bangla_input" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
                @endif
                <span style="font-size: 12px;">(মিটার) </span></td>

                <td><span class="four_blocks">প্রস্থ - </span>
                <!-- <span style="color: red;"> * </span> --></td><td>:</td><td>
                @if($row && $row['chatal_wide'])
                <input onkeydown="checkbanglainput(event)" onchange="chatalCalculate({{$count}})" id ="chatal_wide{{$count}}" size="10" type="text" name="chatal_wide[]" value="{{App\BanglaConverter::en2bn(2, $row['chatal_wide'])}}" class="bangla_input" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
                @else
                <input onkeydown="checkbanglainput(event)" onchange="chatalCalculate({{$count}})" id ="chatal_wide{{$count}}" size="10" type="text" name="chatal_wide[]" value="" class="bangla_input" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
                @endif
                <span style="font-size: 12px;">(মিটার) </span></td>

                <td><span class="four_blocks">ক্ষেত্রফল - </span>
                <!-- <span style="color: red;"> * </span> --></td><td>:</td><td>
                @if($row && $row['chatal_area'])
                <input  id ="chatal_area{{$count}}" size="10" readonly type="text" name="chatal_area[]" value="{{$row['chatal_area']}}" class="disableinput">
                @else
                <input  id ="chatal_area{{$count}}" size="10" readonly type="text" name="chatal_area[]" value="" class="disableinput">
                @endif
                <span style="font-size: 12px;">(বর্গ  মিটার) </span></td>

                <td>
                    <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                    @if($row && $row['chatal_id'])
                    <input type="hidden" name="chatal_id[]" value="{{$row['chatal_id']}}" />
                    @else
                    <input type="hidden" name="chatal_id[]" value="" />
                    @endif
                </td>

            </tr>
            <?php $count++;?>
            @endforeach
        </tbody>

    </table>
</div>

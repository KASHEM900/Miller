<div>

    <table width="100%" class="mx-2">

        <tbody>
            <tr>

            <td width="50%"> চালকলের সাইলো সংখ্যা <!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input readonly type="text" name="silo_num" id="silo_num" value="{{count($silo_details)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে গুদামের  সংখ্যা বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle px-2 py-1 text-xl text-blue-400 cursor-pointer" />
            </td>
            </tr>

        </tbody>
    </table>

    <table width="100%" id="silo_fields">

        <tbody>
        <?php $count = 1; ?>
        @foreach($silo_details as $row)
        <tr wire:key="{{$loop->index}}">

            <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}} । ব্যাসার্ধ - </span></td><td>:</td><td>

                @if($row && $row['silo_radius'])
                <input onchange="siloCalculate({{$count}})" id="silo_radius{{$count}}" size="9" type="text" name="silo_radius[]"
                value="{{App\BanglaConverter::en2bn(2, $row['silo_radius'])}}" onkeydown="checkbanglainput(event)"
                placeholder="বাংলায় লিখুন"><span style="font-size: 10px;">(মিটার) </span></td>
            @else

            <input onchange="siloCalculate({{$count}})" id="silo_radius{{$count}}" size="9" type="text" name="silo_radius[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">

            @endif

            <td><span class="four_blocks"> উচ্চতা - </span></td><td>:</td><td>

            @if($row && $row['silo_height'])
                <input onchange="siloCalculate({{$count}})" id="silo_height{{$count}}" size="9" type="text" name="silo_height[]" value="{{App\BanglaConverter::en2bn(2, $row['silo_height'])}}" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">
            @else

            <input onchange="siloCalculate({{$count}})" id="silo_height{{$count}}" size="9" type="text" name="silo_height[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন">

            @endif

            <td><span class="four_blocks"> আয়তন - </span></td><td>:</td><td>

            @if($row && $row['silo_volume'])
                <input id ="silo_volume{{$count}}" size="9" readonly type="text" name="silo_volume[]" value="{{$row['silo_volume']}}" class="disableinput" disabled="disabled">
            @else

            <input id ="silo_volume{{$count}}" size="9" readonly type="text" name="silo_volume[]" value="" class="disableinput" disabled="disabled">

            @endif

            <td>
                <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                    <input type="hidden" name="silo_id[]" value="{{ isset($row['silo_id']) ? $row['silo_id'] : '' }}" />
            </td>

        </tr>
        <?php $count++;?>
        @endforeach

        </tbody>
</table>

</div>


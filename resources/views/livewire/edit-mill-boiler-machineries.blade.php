<div>

    <table width="100%">

        <tbody><tr>

            <td width="50%">যন্ত্রপাতির সংখ্যা <!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input readonly type="text" name="boiler_machineries_num" id="boiler_machineries_num" value="{{count($mill_boiler_machineries)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle text-xl text-blue-400 px-2 py-1 cursor-pointer" />
            </td>
        </tr>
        </tbody>
    </table>

    <table width="100%" id="boiler_machineries_fields">

        <tbody><tr>

        <td width="5%"><b>ক্রঃ নং</b></td>

        <td align="left" width="15%"><b> যন্ত্রাংশের নাম</b></td>

        <td align="left" width="10%"><b> ব্রান্ডের নাম</b></td>

        <td align="left" width="10%"><b> প্রস্তুতকারী দেশ</b></td>

        <td align="left" width="15%"><b> আমদানির তারিখ</b></td>

        <td align="center" width="5%"><b>সংখ্যা</b></td>

        <td align="center" width="10%"><b>একক ক্ষমতা</b></td>

        <td align="center" width="10%"><b>যৌথ ক্ষমতা</b></td>

        <td align="left" width="10%"><b> চাপ (প্রতি বর্গ সে.মি.) তে</b></td>

        </tr>
        
        <?php $count = 1; ?>
        @foreach($mill_boiler_machineries as $row)
        <tr wire:key="{{$loop->index}}">

            <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}}</span></td>
            
            @if($row && $row['name'])
            <td><input class="form-control" id="boiler_machineries_name{{$count}}" size="9" type="text" name="boiler_machineries_name[]" value="{{$row['name']}}"></td>
            @else
            <td><input class="form-control" id="boiler_machineries_name{{$count}}" size="9" type="text" name="boiler_machineries_name[]" value=""></td>
            @endif

            @if($row && $row['brand'])
            <td><input class="form-control" id="boiler_machineries_brand{{$count}}" size="9" type="text" name="boiler_machineries_brand[]" value="{{$row['brand']}}"></td>
            @else
            <td><input class="form-control" id="boiler_machineries_brand{{$count}}" size="9" type="text" name="boiler_machineries_brand[]" value=""></td>
            @endif

            @if($row && $row['manufacturer_country'])
            <td><input class="form-control" id="boiler_machineries_manufacturer_country{{$count}}" size="9" type="text" name="boiler_machineries_manufacturer_country[]" value="{{$row['manufacturer_country']}}"></td>
            @else
            <td><input class="form-control" id="boiler_machineries_manufacturer_country{{$count}}" size="9" type="text" name="boiler_machineries_manufacturer_country[]" value=""></td>
            @endif

            @if($row && $row['import_date'])
            <td><input class="form-control date" id="boiler_machineries_import_date{{$count}}" size="9" type="date" name="boiler_machineries_import_date[]" value="{{$row['import_date']}}" placeholder="একটি তারিখ বাছাই করুন" title="আমদানির তারিখ"></td>
            @else
            <td><input class="form-control date" id="boiler_machineries_import_date{{$count}}" size="9" type="date" name="boiler_machineries_import_date[]" value="" placeholder="একটি তারিখ বাছাই করুন" title="আমদানির তারিখ"></td>
            @endif

            @if($row && $row['num'])
            <td><input class="form-control" id="boiler_machineries_num{{$count}}" size="9" type="text" name="boiler_machineries_num[]" value="{{App\BanglaConverter::en2bn(0, $row['num'])}}" onchange="boilerMachineriesCalculate({{$count}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
            @else
            <td><input class="form-control" id="boiler_machineries_num{{$count}}" size="9" type="text" name="boiler_machineries_num[]" value="" onchange="boilerMachineriesCalculate({{$loop->index+1}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
            @endif

            @if($row && $row['power'])
            <td><input class="form-control" id="boiler_machineries_power{{$count}}" size="9" type="text" name="boiler_machineries_power[]" value="{{App\BanglaConverter::en2bn(2, $row['power'])}}" onchange="boilerMachineriesCalculate({{$count}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
            @else
            <td><input class="form-control" id="boiler_machineries_power{{$count}}" size="9" type="text" name="boiler_machineries_power[]" value="" onchange="boilerMachineriesCalculate({{$loop->index+1}})" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
            @endif

            @if($row && $row['topower'])
            <td><input class="form-control" id="boiler_machineries_topower{{$count}}" size="9" readonly type="text" name="boiler_machineries_topower[]" value="{{$row['topower']}}"></td>
            @else
            <td><input class="form-control" id="boiler_machineries_topower{{$count}}" size="9" readonly type="text" name="boiler_machineries_topower[]" value=""></td>
            @endif

            <td><input class="form-control" id="boiler_machineries_pressure{{$count}}" size="9" type="text" name="boiler_machineries_pressure[]" value="" onkeydown="checkbanglainput(event)" placeholder="বাংলায় লিখুন"></td>
           
            @if($row && $row['mill_boiler_machinery_id'])
            <td>
                <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                <input type="hidden" id="mill_boiler_machinery_id{{$count}}" name="mill_boiler_machinery_id[]" value="{{$row['mill_boiler_machinery_id']}}" />
            </td>
            @else
            <td>
                <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                <input type="hidden" id="mill_boiler_machinery_id{{$count}}" name="mill_boiler_machinery_id[]" value="" />
            </td>
            @endif
            

        </tr>
        <?php $count++;?>
        @endforeach
        </tbody>
</table>

</div>

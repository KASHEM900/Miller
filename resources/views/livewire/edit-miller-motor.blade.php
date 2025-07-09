<div>

    <table width="100%" class="mx-2">

        <tbody><tr>

            <td width="50%">মটরের সংখ্যা <!-- <span style="color: red;"> * </span> --></td>

            <td width="10"> : </td>

            <td>
                <input  readonly type="text" name="motor_num" id="motor_num" value="{{count($motor_details)}}" placeholder="অনুগ্রহ করে বাংলায় লিখুন" title="অনুগ্রহ করে মটরের সংখ্যা বাংলায় লিখুন">
                <span wire:click="increment" class="fas fa-plus-circle text-xl text-blue-400 px-2 py-1 cursor-pointer" />
            </td>

            </tr>

        </tbody>

    </table>

    <table width="100%" id="motor_fields">

        <tbody>
            <?php $count = 1; ?>
            @foreach($motor_details as $row)
            <tr wire:key="{{$loop->index}}">

                <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}} । অশ্বশক্তি ও হলার সংখ্যা - </span></td><td>:</td><td>

                <select onchange="motorCalculate({{$count}})" id="motor_power_id{{$count}}" name="motor_power_id[]" class="form-control">

                    <option value=""></option>
                    @foreach($motor_powers as $motor_power)
                    <option value="{{ $motor_power['motorid']}}" {{ $motor_power['motor_power'] == $row['motor_horse_power'] && $motor_power['holar_num'] == $row['motor_holar_num']  ? 'selected' : '' }}>অশ্বশক্তি {{ $motor_power['motor_power']}} ও  হলার {{ $motor_power['holar_num']}}</option>
                    @endforeach

                </select>
                </td>
                <td></td>
                <td><span class="four_blocks">ছাঁটাই ক্ষমতা -</span></td><td>:</td><td><input size="9" readonly type="text" id ="motor_filter_power{{$count}}" name="motor_filter_power" value="{{$row['motor_filter_power']/1000}}" class="disableinput" disabled="disabled"><span style="font-size: 10px;"> (মেঃ টন)</span></td>

                <td>
                    <span class="fas fa-times-circle text-xl text-red-400 p-2" wire:click="remove({{$loop->index}})" />
                    <input type="hidden" name="motor_id[]" value="{{$row['motor_id']}}" />
                </td>

                </tr>
                <?php $count++;?>
                @endforeach
            </tbody>
        </table>

</div>

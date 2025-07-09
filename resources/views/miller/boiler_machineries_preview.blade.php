<fieldset id="boiler_machineries_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>বয়লার এর যন্ত্রপাতির বিবরণ</b></span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="boiler_machineries" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <br />
            <table>
                <tr>
                    <td>বয়লার সার্টিফিকেট</td>
                    <td><strong>:</strong> </td>
                    <td>
                        @if($miller->autometic_miller_new && $miller->autometic_miller_new->boiler_certificate_file != '')
                        <a target="_blank" href="{{ asset('images/boiler_certificate_file/large/'.$miller->autometic_miller_new->boiler_certificate_file) }}">
                            <img width="100" height="100" src="{{ asset('images/boiler_certificate_file/thumb/'.$miller->autometic_miller_new->boiler_certificate_file) }}" alt="{{$miller->boiler_certificate_file}}"/>
                        </a>
                        @endif
                    </td>
                </tr>
            </table>
            <br />
            <br />

            <table width="100%" align="center">

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

                <?php $count = 1; $sum = 0.00; ?>
                @foreach($miller->mill_boiler_machineries as $boiler_machinery)

                    <tr>
                    <td><span class="four_blocks">{{App\BanglaConverter::en2bn(0, $loop->index+1)}}</span></td>
            
                    <td>{{$boiler_machinery['name']}}</td>

                    <td>{{$boiler_machinery['brand']}}</td>

                    <td>{{$boiler_machinery['manufacturer_country']}}</td>

                    <td>{{ date('d-m-Y', strtotime($boiler_machinery['import_date'])) }}</td>

                    <td>{{App\BanglaConverter::en2bn(0, $boiler_machinery['num'])}}</td>

                    <td>{{App\BanglaConverter::en2bn(2, $boiler_machinery['power'])}}</td>

                    <td>{{App\BanglaConverter::en2bn(2, $boiler_machinery['topower'])}}</td>

                    <td>{{App\BanglaConverter::en2bn(2, $boiler_machinery['pressure'])}}</td>

                    </tr>

                    <tr><td colspan="15"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                <?php $count++; $sum += $boiler_machinery['topower']; ?>
                @endforeach

                <input type="hidden" name="boiler_machineries_topower_sum" id="boiler_machineries_topower_sum" value="{{$sum}}">
                </tbody>
            </table>

            <table width="100%" align="center">

                <tbody>
                <tr>
                    <td width="50%">বয়লার এর যন্ত্রপাতির সর্বমোট ক্ষমতা</td>

                    <td>:</td>

                    <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->boiler_machineries_steampower)}}@endif<span style="color: gray;"> (মেঃ টন) </span></td>

                </tr>

                <tr>   
                    <td>পাক্ষিক ধান ভাঁপানো ও ড্রায়ারে ধান শুকানোর ক্ষমতা (সর্বমোট ক্ষমতা) x ১২ x ১৩ মেঃ টন  </td>

                    <td>:</td>

                    <td style=" font-weight:bold;">@if($miller->areas_and_power){{App\BanglaConverter::en2bn(2, $miller->areas_and_power->boiler_machineries_power)}}@endif<span style="color: gray;"> (মেঃ টন)</span></td>

                </tr>

                </tbody></table>


        </div>
    </div>
</fieldset>

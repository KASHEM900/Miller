<fieldset id="milling_unit_machineries_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>মিলিং ইউনিটের যন্ত্রপাতির বিবরণ</b></span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="milling_unit_machineries" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <table width="100%" align="center">
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

                    @foreach($miller->mill_milling_unit_machineries as $mill_milling_unit_machinery)

                    <tr>
                        
                    <!-- <td width="5%">{{App\BanglaConverter::en2bn(0, $count)}}</td> -->
                    <td>{{$mill_milling_unit_machinery->name}}</td>
                    <td>{{$mill_milling_unit_machinery->brand}}</td>
                    <td>{{$mill_milling_unit_machinery->manufacturer_country}}</td>
                    <td>{{$mill_milling_unit_machinery->import_date}}</td>
                    <td>{{$mill_milling_unit_machinery->join_type}}</td>
                    <td>{{App\BanglaConverter::en2bn(0, $mill_milling_unit_machinery['num'])}}</td>
                    <td>{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery['power'])}}</td>
                    <td>{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery['topower'])}}</td>
                    <td>{{App\BanglaConverter::en2bn(2, $mill_milling_unit_machinery['horse_power'])}}</td>

                    </tr>
                    
                    <tr><td colspan="15"><div style="width: 100%; background-color: silver; height: 1px;"></div></td></tr>
                <?php $count++;?>
                @endforeach

                <tr>
                    <td>মন্তব্য</td>
                    <td colspan="8">{{$miller->milling_unit_comment}}</td>
                </tr>

                </tbody></table>

        </div>
    </div>
</fieldset>

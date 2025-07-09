<div class="card-header flex justify-between" style="text-align: center;">
    <h3>চালকলের তথ্য</h3>
</div>

<div class="card-body">
    <table id="table_id" class="table table-bordered" border="1" cellspacing="0" width="100%">

        <thead>
            <tr>
                <th>ক্রমিক নং</th>
                <th width="10%">ফর্ম নম্বর	@sortablelink('form_no', '')</th>
                <th>চালকলের নাম @sortablelink('mill_name', '')	</th>
                <th>মালিকের নাম @sortablelink('owner_name', '')	</th>
                <th>মোবাইল @sortablelink('mobile_no', '')	</th>
                <th>লাইসেন্স নম্বর @sortablelink('license_no', '')	</th>
                <th width="18%">চালকলের ধরণ @sortablelink('milltype.mill_type_name', '')	</th>
                <th width="13%">পাক্ষিক ক্ষমতা (চাল) @sortablelink('millar_p_power_chal', '') </th>
                <th width="10%">উপজেলা @sortablelink('upazilla.upazillaname', '')</th>
                <th width="10%">জেলা @sortablelink('district.distname', '')</th>
                <th width="10%">চালকলের ধরণ @sortablelink('milltype.mill_type_name', '')</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1; ?>
            @foreach($millers as $key => $miller)
            <tr>
                <td style="text-align: center;"><span>{{App\BanglaConverter::en2bn(0, $count)}}</span></td>
                <td>
                    <span>{{App\BanglaConverter::en2bt($miller->form_no)}}</span>
                </td>
                <td><span>{{$miller->mill_name}}</span></td>
                <td><span>{{$miller->owner_name}}</span></td>
                <td><span>{{$miller->mobile_no}}</span></td>
                <td><span>{{$miller->license_no}}</span></td>
                <td><span>{{($miller->mill_type_id>0)? $miller->milltype->mill_type_name : ''}}</span></td>
                <td style="text-align: center;"><span>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}}</span></td>
                <td><span>{{($miller->mill_upazila_id)? $miller->upazilla->upazillaname : ""}}</span></td>
                <td><span>{{$miller->district->distname}}</span></td>
                <td><span>@if($miller->miller_status == "new_register") নতুন নিবন্ধন @elseif($miller->miller_status == "inactive") বন্ধ চালকল @else সচল চালকল @endif</span></td>
            </tr>
            <?php $count ++; ?>
            @endforeach
        </tbody>
    </table>
</div>


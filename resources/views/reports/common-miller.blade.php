<div class="card-header flex justify-between">
    <span>চালকলের তথ্য</span>
</div>

<div class="card-body">
    <table id="table_id" class="table table-bordered" cellspacing="0" width="100%">

        <thead>
            <tr>
                <th>ক্রমিক নং</th>
                <th width="10%">ফর্ম নম্বর	@sortablelink('form_no', '')</th>
                <th width="14%">চালকলের নাম @sortablelink('mill_name', '')	</th>
                <th width="14%">মালিকের নাম @sortablelink('owner_name', '')	</th>
                <th width="10%">লাইসেন্স নম্বর @sortablelink('license_no', '')	</th>
                <th width="13%">চালকলের ধরণ @sortablelink('milltype.mill_type_name', '')	</th>
                <!--<th width="12%">পাক্ষিক ক্ষমতা(ধান) @sortablelink('millar_p_power', '') </th>-->
                <th width="12%">পাক্ষিক ক্ষমতা(চাল)@sortablelink('millar_p_power_chal', '') </th>
                <th width="10%">উপজেলা @sortablelink('upazilla.upazillaname', '')</th>
                <th width="10%">জেলা @sortablelink('district.distname', '')</th>
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
                <td><span>{{$miller->license_no}}</span></td>
                <td><span>{{($miller->mill_type_id>0)? $miller->milltype->mill_type_name : ''}}</span></td>
                <!--<td style="text-align: center;"><span>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power)}}</span></td>-->
                <td style="text-align: center;"><span>{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}}</span></td>
                <td><span>{{($miller->mill_upazila_id)? $miller->upazilla->upazillaname : ""}}</span></td>
                <td><span>{{$miller->district->distname}}</span></td>
            </tr>
            <?php $count ++; ?>
            @endforeach
        </tbody>
    </table>
    <div class="print_hide">
    {!! $millers->appends(\Request::except('page'))->render() !!}
    </div>
</div>


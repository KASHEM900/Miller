<div class="card-body">
    <table width="100%; text-align: center" align="center">
        <tbody>                
            <tr>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom; height: 100px;" width="15%">
                    @if($miller->approver_mms_user && $miller->approver_mms_user->signature_file != '')
                    <a target="_blank" href="{{ asset('images/user_signature_file/large/'.$miller->approver_mms_user->signature_file) }}">
                        <img width="100%" height="100%" src="{{ asset('images/user_signature_file/thumb/'.$miller->approver_mms_user->signature_file) }}" alt="{{$miller->approver_mms_user->signature_file}}"/>
                    </a>
                    @endif
                    @if($miller->approver_mms_user_date)
                        তারিখঃ {{ $miller->approver_mms_user_date->format("Y-m-d") }}
                    @endif
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom; height: 100px;" width="15%">
                    @if($miller->approver_silo_user && $miller->approver_silo_user->signature_file != '')
                    <a target="_blank" href="{{ asset('images/user_signature_file/large/'.$miller->approver_silo_user->signature_file) }}">
                        <img width="100%" height="100%" src="{{ asset('images/user_signature_file/thumb/'.$miller->approver_silo_user->signature_file) }}" alt="{{$miller->approver_silo_user->signature_file}}"/>
                    </a>
                    @endif
                    @if($miller->approver_silo_user_date)
                        তারিখঃ {{ $miller->approver_silo_user_date->format("Y-m-d") }}
                    @endif
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom; height: 100px;" width="15%">
                    @if($miller->approver_dc_user && $miller->approver_dc_user->signature_file != '')
                    <a target="_blank" href="{{ asset('images/user_signature_file/large/'.$miller->approver_dc_user->signature_file) }}">
                        <img width="100%" height="100%" src="{{ asset('images/user_signature_file/thumb/'.$miller->approver_dc_user->signature_file) }}" alt="{{$miller->approver_dc_user->signature_file}}"/>
                    </a>
                    @endif
                    @if($miller->approver_dc_user_date)
                        তারিখঃ {{ $miller->approver_dc_user_date->format("Y-m-d") }}
                    @endif
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom; height: 100px;" width="15%">
                    @if($miller->approver_rc_user && $miller->approver_rc_user->signature_file != '')
                    <a target="_blank" href="{{ asset('images/user_signature_file/large/'.$miller->approver_rc_user->signature_file) }}">
                        <img width="100%" height="100%" src="{{ asset('images/user_signature_file/thumb/'.$miller->approver_rc_user->signature_file) }}" alt="{{$miller->approver_rc_user->signature_file}}"/>
                    </a>
                    @endif
                    @if($miller->approver_rc_user_date)
                        তারিখঃ {{ $miller->approver_rc_user_date->format("Y-m-d") }}
                    @endif
                </td>
            </tr>        
            <tr>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom;" width="15%">
                    <span><hr style="padding: 0; margin: 0;" /></span>
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom;" width="15%">
                    <span><hr style="padding: 0; margin: 0;" /></span>
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom;" width="15%">
                    <span><hr style="padding: 0; margin: 0;" /></span>
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: bottom;" width="15%">
                    <span><hr style="padding: 0; margin: 0;" /></span>
                </td>
            </tr>        
            <tr>
                <td style="text-align:center; padding: 3px 5%; vertical-align: top;" width="15%">
                    চালকল মালিক সমিতি
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: top;" width="15%">
                    সাইলো সুপার প্রতিনিধি, {{$miller->division->divname}} বিভাগ  
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: top;" width="15%">
                    জেলা খাদ্য নিয়ন্ত্রক, {{$miller->district->distname}}
                </td>
                <td style="text-align:center; padding: 3px 5%; vertical-align: top;" width="15%">
                    আঞ্চলিক খাদ্য নিয়ন্ত্রক, {{$miller->division->divname}} বিভাগ 
                </td>
            </tr>        
        </tbody>
    </table>
</div>

<fieldset id="auto_p_power_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা</b></span>
            @if($edit_perm)
            <span><div align="right" class="print_hide"><button id="auto_p_power" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

        <table width="100%" align="center">
        <tbody><tr>

        <td width="50%"><b style="background-color:#0ee60e;">চালকলের প্রকৃত পাক্ষিক ছাঁটাই ক্ষমতা </b></td>

        <td>: </td>

        <td> <b style="background-color:#0ee60e;">{{App\BanglaConverter::en2bn(0, $miller->millar_p_power_chal)}}  মেট্টিক টন চাল </b></td>

        </tr>
        
        <tr>
            <td><b>চালকলের পাক্ষিক ছাঁটাই ক্ষমতা অনুমোদন ফাইল</b></td>
            <td><strong>:</strong> </td>
            <td>
                @if($miller->miller_p_power_approval_file != '')
                <a target="_blank" href="{{ asset('images/miller_p_power_approval_file/large/'.$miller->miller_p_power_approval_file) }}">
                    <img width="100" height="100" src="{{ asset('images/miller_p_power_approval_file/thumb/'.$miller->miller_p_power_approval_file) }}" alt="{{$miller->miller_p_power_approval_file}}"/>
                </a>
                @endif
            </td>
        </tr>
        
        <tr>
            <td><b>চালকলের তথ্য সম্পূর্ণ ?</b></td>
            <td>:</td>
            <td>
                @if($miller->cmp_status == "1") সম্পূর্ণ @else অসম্পূর্ণ @endif
            </td>
        </tr>

        </tbody></table>

        </div>
    </div>
</fieldset>

<fieldset id="boiller_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>বয়লারের তথ্য </b> </span>
            @if($edit_perm)
            <span><div align="right" class="print_hide"><button id="boiller" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

            <table width="100%" align="center" class="report_fontsize">

                <tbody>
                    <tr>

                        <td width="50%">বয়লারের সংখ্যা </td>

                        <td width="10"> : </td>

                        <td>{{App\BanglaConverter::en2bn(0, $miller->boiller_num)}}</td>

                    </tr>

                    <tr>

                        <td>বয়লারে স্বয়ংক্রিয় সেফটি ভালভ আছে কিনা ?</td>

                        <td width="10"> : </td>

                        <td>{{$miller->is_safty_vulve}}</td>

                    </tr>

                    <tr>

                        <td>বয়লারে চাপমাপক যন্ত্র আছে কিনা ?</td>

                        <td width="10"> : </td>

                        <td>{{$miller->is_presser_machine}}</td>

                    </tr>



                </tbody>
            </table>

    </div>
    </div>
</fieldset>

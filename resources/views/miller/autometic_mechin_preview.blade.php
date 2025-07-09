<fieldset id="autometic_mechin_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"> <b>যন্ত্রপাতির বিবরণ </b></span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="autometic_mechin" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">
        <table width="100%" align="center">

                <tbody><tr>

                <td width="5%">ক)</td>

                <td><strong>:</strong></td>

                <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_a}}@endif</td>

            </tr>

            <tr> <td colspan="3" align="right" id="errorMsgMachi"></td></tr>

            <tr>

                <td>খ)</td>

                <td><strong>:</strong></td>

                <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_b}}@endif </td>

            </tr>

            <tr>

                <td>গ)</td>

                <td><strong>:</strong></td>

                <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_c}}@endif </td>

            </tr>

            <tr>

                <td>ঘ)</td>

                <td><strong>:</strong></td>

                <td> @if($miller->autometic_miller){{$miller->autometic_miller->machineries_d}}@endif</td>

            </tr>

            <tr>

                <td>ঙ)</td>

                <td><strong>:</strong></td>

                <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_e}}@endif</td>

            </tr>

            <tr>

                <td>চ)</td>

                <td><strong>:</strong></td>

                <td>@if($miller->autometic_miller){{$miller->autometic_miller->machineries_f}}@endif </td>

            </tr>



        </tbody></table>

    </div>
    </div>
</fieldset>

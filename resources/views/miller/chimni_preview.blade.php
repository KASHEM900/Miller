<fieldset id="chimni_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>চিমনীর তথ্য</b> </span>
            @if($edit_perm)
            <span> <div align="right" class="print_hide"><button id="chimni" class="btn2 btn-primary edit-button">এডিট</button>  </div></span>
            @endif
        </div>

        <div class="card-body">

                <table width="100%" align="center" class="report_fontsize">

                    <tbody><tr>

                        <td width="50%">চিমনীর উচ্চতা (মিটার) </td>

                        <td width="10"> : </td>

                        <td>{{App\BanglaConverter::en2bn(2, $miller->chimney_height)}} মিটার</td>

                        </tr>



                    </tbody>

                </table>

        </div>
    </div>
</fieldset>

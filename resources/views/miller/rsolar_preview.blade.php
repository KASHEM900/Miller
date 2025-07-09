<fieldset id="rsolar_preview" style="display:block;">
    <div class="card">

        <div class="card-header flex justify-between">
            <span class="text-xl"><b>রাবার শেলার ও রাবার পলিশারের তথ্য</b> </span>
            @if($edit_perm)
            <span><div align="right" class="print_hide"><button id="rsolar" class="btn2 btn-primary edit-button">এডিট</button>  </div>
            </span>
            @endif
        </div>

        <div class="card-body">

        <table width="100%" align="center">
            <tbody><tr>

            <td width="50%">রাবার শেলার ও রাবার পলিশার আছে কিনা?</td>

            <td width="10"> : </td>

            <td>{{$miller->is_rubber_solar}}</td>

            </tr>



        </tbody></table>
        </div>
    </div>
</fieldset>

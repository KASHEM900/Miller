@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="form_margin" class="form_page">
                <h2 align="center">FPS Hotfix</h2>
                    <div id="chalkol_div">

                        <form id="millerform" action="{{ route('millers.fpshotfix') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                            <table width="100%" class="mx-2">
                                    <tbody>
										<tr>
											<td>চালকল মালিকের স্ট্যাটাস<span style="color: red;"> * </span></td>
											<td>:</td>
											<td>
												<input required type="radio" name="miller_status" id="miller_status_active" value="active" checked>&nbsp;Active&nbsp;&nbsp;
												<input required type="radio" name="miller_status" id="miller_status_inactive" value="inactive">&nbsp;Inactive&nbsp;&nbsp;
											</td>
										</tr>

                                        <tr>
                                            <td>মিল মালিকের এনআইডি<span style="color: red;"> * </span></td>
                                            <td><strong>:</strong></td>
                                            <td>
                                               <input required minlength="10" maxlength="17" style="float: left;width: 60%;" type="number" name="nid_no" id="nid_no" class="form-control" value="" title="মিল মালিকের এনআইডি">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                               <input type="button" class="btn btn-primary" value="Submit" onclick="activateMiller()">
                                               <br />
                                               <br />
                                            </td>
                                        </tr>
										<tr>
											<td>চালকলের অবস্থা<span style="color: red;"> * </span></td>
											<td>:</td>
											<td>
												<input required type="radio" name="mill_status" id="mill_status_active" value="active" checked>&nbsp;Active&nbsp;&nbsp;
												<input required type="radio" name="mill_status" id="mill_status_inactive" value="inactive">&nbsp;Inactive&nbsp;&nbsp;
											</td>
										</tr>

                                        <tr>
                                            <td>লাইসেন্স নং<span style="color: red;"> * </span></td>
                                            <td><strong>:</strong></td>
                                            <td>
                                                <input required type="text" maxlength="99" style="float: left;width: 60%;" name="license_no" id="license_no" class="form-control" value="" title="লাইসেন্স নম্বর ">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                               <input type="button" class="btn btn-primary" value="Submit" onclick="activateMill()">
                                               <br />
                                               <br />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

function activateMiller(){
    var nid_no = $('#nid_no').val();
    var miller_status = $("input[name='miller_status']:checked").val();

    if(!nid_no){
        alert('অনুগ্রহ করে মিল মালিকের এনআইডি প্রদান করুন');
        $('#nid_no').focus();
    }
    else{
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/activateMiller",
            method:"POST",
            data:{nid_no:nid_no, miller_status:miller_status, _token:_token},
            success:function(result)
            {
                alert(result.message);
            }
        })
    }
};

function activateMill(){
    var license_no = $('#license_no').val();
    var mill_status = $("input[name='mill_status']:checked").val();

    if(!license_no){
        alert('অনুগ্রহ করে লাইসেন্স নং প্রদান করুন');
        $('#license_no').focus();
    }
    else{
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/activateMill",
            method:"POST",
            data:{license_no:license_no, mill_status:mill_status, _token:_token},
            success:function(result)
            {
                alert(result.message);
            }
        })
    }
};
</script>

@endsection

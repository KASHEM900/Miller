function printPage(div_name){

    var tableData = document.getElementById(div_name).innerHTML+'';

    var data = '<style>@media print { #print_button {display:none;} } .print_hide{display:none;}</style>'+
        '<button id="print_button" style="height:30px;margin-bottom:10px;color: #fff;background-color: #3490dc;border-color: #3490dc;"  onclick="window.print()">পেইজটা প্রিন্ট করুন</button>'+
        tableData;

    myWindow=window.open('','','width=800,height=600');

    myWindow.innerWidth = screen.width;

    myWindow.innerHeight = screen.height;

    myWindow.screenX = 0;

    myWindow.screenY = 0;

    myWindow.document.write(data);

    myWindow.focus();

};

function verifyNID(){
    var nid_no = $('#nid_no').val();
    var birth_date = $('#birth_date').val();

    if(!nid_no){
        alert('অনুগ্রহ করে মিল মালিকের এনআইডি প্রদান করুন');
        $('#nid_no').focus();
    }
    else if(!birth_date){
        alert('অনুগ্রহ করে জন্ম তারিখ প্রদান করুন');
        $('#birth_date').focus();
    }
    else{
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/verifyNID",
            method:"POST",
            data:{nid_no:nid_no, birth_date:birth_date.substring(0, 10), _token:_token},
            success:function(result)
            {
                if(!result.status){
                    alert(result.message);
                    $('#nid_no').focus();
                }
                else{
                    $('#owner_name').val(result.data.Name_Bn);
                    $('#birth_date').val(result.data.DOB.substring(0, 10));
                    $('#father_name').val(result.data.Father_Name);
                    $('#mother_name').val(result.data.Mother_Name);
                    $('#owner_address').val(result.data.Permanent_Address);
                    $('#owner_name_english').val(result.data.Name_En);
                    $('#gender').val(result.data.Gender);
                    alert(result.message);
                }
            }
        })
    }
};

function loadMillerInfoByNID(){
    var nid_no = $('#nid_no').val();

    if(nid_no){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/getMillerByNID",
            method:"POST",
            data:{nid_no:nid_no, _token:_token},
            success:function(result)
            {
                $('#division_id').val(result.division_id);

                if(result.division_id != '')
                {
                 var divId = result.division_id;
                 $.ajax({
                  url:"/districts/getDistrictListByDivId",
                  method:"POST",
                  data:{divId:divId, _token:_token},
                  success:function(result2)
                  {
                   $('#district_id').html(result2);
                   $('#district_id').val(result.district_id);
                  }
                 })
                  //Miller Birth Place

                    $.ajax({
                        url:"/districts/getAllDistrict",
                        method:"POST",
                        data:{divId:divId, _token:_token},
                        success:function(result)
                        {
                        $('#miller_birth_place').html(result);
                        }
                    })
                }

                if(result.district_id != '')
                {
                 var distId = result.district_id;
                 $.ajax({
                  url:"/upazillas/getUpazillaListByDistId",
                  method:"POST",
                  data:{distId:distId, _token:_token},
                  success:function(result2)
                  {
                   $('#mill_upazila_id').html(result2);
                   $('#mill_upazila_id').val(result.mill_upazila_id);
                   $('#miller_birth_place').val(result.miller_birth_place);
                  }
                 })
                }

                $('#mill_name').val(result.mill_name);
                $('#mill_address').val(result.mill_address);
                $('#owner_name').val(result.owner_name);
                $('#birth_date').val(result.birth_date.substring(0, 10));
                $('#father_name').val(result.father_name);
                $('#mother_name').val(result.mother_name);
                $('#owner_address').val(result.owner_address);
                $('#mobile_no').val(result.mobile_no);
                $('#owner_name_english').val(result.owner_name_english);
                $('#gender').val(result.gender);

                $('#bank_account_no').val(result.bank_account_no);
                $('#bank_account_name').val(result.bank_account_name);
                $('#bank_name').val(result.bank_name);
                $('#bank_branch_name').val(result.bank_branch_name);

                $('#miller_nationality').val(result.miller_nationality);
                $('#miller_religion').val(result.miller_religion);
            }
        })
    }
    else{
        alert('অনুগ্রহ করে মিল মালিকের এনআইডি প্রদান করুন');
    }
};

function printInfoWiseReport(){
    var urlParams = new URLSearchParams(window.location.search);
    var searchtext = urlParams.get('searchtext');
    var division_id = urlParams.get('division_id');
    var district_id = urlParams.get('district_id');
    var cmp_status = urlParams.get('cmp_status');
    var page = urlParams.get('page');

    var _token = $('input[name="_token"]').val();
    $.ajax({
        url:"/printinfowise",
        method:"POST",
        data:{division_id:division_id, district_id:district_id, cmp_status:cmp_status, page:page, searchtext:searchtext, _token:_token},
        success:function(result)
        {
            var data = '<style>@media print { #print_button {display:none;} } .print_hide{display:none;}</style>'+
                '<button id="print_button" style="height:30px;margin-bottom:10px;color: #fff;background-color: #3490dc;border-color: #3490dc;" onclick="window.print()">পেইজটা প্রিন্ট করুন</button>'+
                result;

            myWindow=window.open('','','width=800,height=600');

            myWindow.innerWidth = screen.width;

            myWindow.innerHeight = screen.height;

            myWindow.screenX = 0;

            myWindow.screenY = 0;

            myWindow.document.write(data);

            myWindow.focus();
        }
    })
};

function printRegionWiseReport(){
    var urlParams = new URLSearchParams(window.location.search);
    var searchtext = urlParams.get('searchtext');
    var division_id = urlParams.get('division_id');
    var district_id = urlParams.get('district_id');
    var upazila_id = urlParams.get('upazila_id');
    var page = urlParams.get('page');

    var _token = $('input[name="_token"]').val();
    $.ajax({
        url:"/printregionwise",
        method:"POST",
        data:{division_id:division_id, district_id:district_id, upazila_id:upazila_id, page:page, searchtext:searchtext, _token:_token},
        success:function(result)
        {
            var data = '<style>@media print { #print_button {display:none;} } .print_hide{display:none;}</style>'+
                '<button id="print_button" style="height:30px;margin-bottom:10px;color: #fff;background-color: #3490dc;border-color: #3490dc;" onclick="window.print()">পেইজটা প্রিন্ট করুন</button>'+
                result;

            myWindow=window.open('','','width=800,height=600');

            myWindow.innerWidth = screen.width;

            myWindow.innerHeight = screen.height;

            myWindow.screenX = 0;

            myWindow.screenY = 0;

            myWindow.document.write(data);

            myWindow.focus();
        }
    })
};

function printTypeWiseReport(){
    var urlParams = new URLSearchParams(window.location.search);
    var searchtext = urlParams.get('searchtext');
    var division_id = urlParams.get('division_id');
    var district_id = urlParams.get('district_id');
    var chal_type_id = urlParams.get('chal_type_id');
    var mill_type_id = urlParams.get('mill_type_id');
    var page = urlParams.get('page');

    var _token = $('input[name="_token"]').val();
    $.ajax({
        url:"/printtypewise",
        method:"POST",
        data:{division_id:division_id, district_id:district_id, chal_type_id:chal_type_id, mill_type_id:mill_type_id, page:page, searchtext:searchtext, _token:_token},
        success:function(result)
        {
            var data = '<style>@media print { #print_button {display:none;} } .print_hide{display:none;}</style>'+
                '<button id="print_button" style="height:30px;margin-bottom:10px;color: #fff;background-color: #3490dc;border-color: #3490dc;" onclick="window.print()">পেইজটা প্রিন্ট করুন</button>'+
                result;

            myWindow=window.open('','','width=800,height=600');

            myWindow.innerWidth = screen.width;

            myWindow.innerHeight = screen.height;

            myWindow.screenX = 0;

            myWindow.screenY = 0;

            myWindow.document.write(data);

            myWindow.focus();
        }
    })
};

function printForms(){
    /*var array = [];
    $("input:checkbox[name=selected_id]:checked").each(function() {
        array.push($(this).val());
    });*/
    var checkedValues = $('input:checkbox[name=selected_id]:checked').map(function() {
        return this.value;
    }).get();

    if(checkedValues.length){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/getSelectedForms",
            method:"POST",
            data:{checkedValues:checkedValues, _token:_token},
            success:function(result)
            {
                var data = '<style>@media print { body {font-size: 0.8rem;line-height: 1.35;} #print_button {display:none;} } .print_hide{display:none;}</style>'+
                    '<button id="print_button" style="height:30px;margin-bottom:10px;color: #fff;background-color: #3490dc;border-color: #3490dc;" onclick="window.print()">পেইজটা প্রিন্ট করুন</button>'+
                    result;

                myWindow=window.open('','','width=800,height=600');

                myWindow.innerWidth = screen.width;

                myWindow.innerHeight = screen.height;

                myWindow.screenX = 0;

                myWindow.screenY = 0;

                myWindow.document.write(data);

                myWindow.focus();
            }
        })
    }
    else{
        alert('অনুগ্রহ করে প্রিন্টের জন্য চালকল সিলেক্ট করুন');
    }
};

function printLicenseForms(){
    var checkedValues = $('input:checkbox[name=selected_id]:checked').map(function() {
        return this.value;
    }).get();

    if(checkedValues.length){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/getSelectedLicenseForms",
            method:"POST",
            data:{checkedValues:checkedValues, _token:_token},
            success:function(result)
            {
                var data = '<style>@media print {#print_button {display:none;} } .print_hide{display:none;}</style>'+
                    '<button id="print_button" style="height:30px;margin-bottom:10px;color: #fff;background-color: #3490dc;border-color: #3490dc;" onclick="window.print()">পেইজটা প্রিন্ট করুন</button>'+
                    result;

                myWindow=window.open('','','width=800,height=600');

                myWindow.innerWidth = screen.width;

                myWindow.innerHeight = screen.height;

                myWindow.screenX = 0;

                myWindow.screenY = 0;

                myWindow.document.write(data);

                myWindow.focus();
            }
        })
    }
    else{
        alert('অনুগ্রহ করে প্রিন্টের জন্য চালকল সিলেক্ট করুন');
    }
};

function printLicenseHistory(){
    var checkedValues = $('input:checkbox[name=selected_id]:checked').map(function() {
        return this.value;
    }).get();

    if(checkedValues.length){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/getSelectedLicenseHistory",
            method:"POST",
            data:{checkedValues:checkedValues, _token:_token},
            success:function(result)
            {
                var data = '<style>@media print {#print_button {display:none;} } .print_hide{display:none;}</style>'+
                    '<button id="print_button" style="float: left; height:30px;margin-bottom:10px;color: #fff;background-color: #3490dc;border-color: #3490dc;" onclick="window.print()">পেইজটা প্রিন্ট করুন</button>'+
                    result;

                myWindow=window.open('','','width=1000,height=800');

                myWindow.innerWidth = screen.width;

                myWindow.innerHeight = screen.height;

                myWindow.screenX = 0;

                myWindow.screenY = 0;

                myWindow.document.write(data);

                myWindow.focus();
            }
        })
    }
    else{
        alert('অনুগ্রহ করে প্রিন্টের জন্য চালকল সিলেক্ট করুন');
    }
};

$("#select-all").on("click", function() {
    var all = $(this);
    $('input:checkbox').each(function() {
            $(this).prop("checked", all.prop("checked"));
    });
});

$(document).ready(function(){

    $("#chal_type_id").change(function(){
        var chal_type_id = parseInt($(this).find('option:selected').val());
        if(chal_type_id==1){
            $("#boiler_form").hide();
        }
        else{
            $("#boiler_form").show();
        }
    });

    $("#license_fee_id").change(function(){
        $("#license_deposit_amount").val(parseInt($(this).find('option:selected').text()));
    });

    $('#division_id').change(function(){
      $('#miller_birth_place').val('');
      $('#district_id').val('');
      $('#mill_upazila_id').val('');
      if($(this).val() != '')
      {
       var divId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/districts/getDistrictListByDivId",
        method:"POST",
        data:{divId:divId, _token:_token},
        success:function(result)
        {
         $('#district_id').html(result);
        }
       })

        //Miller Birth Place

       $.ajax({
        url:"/districts/getAllDistrict",
        method:"POST",
        data:{divId:divId, _token:_token},
        success:function(result)
        {
         $('#miller_birth_place').html(result);
        }
       })

      }
     });

   
     $('#district_id').change(function(){
      $('#mill_upazila_id').val('');
      if($(this).val() != '')
      {
       var distId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/upazillas/getUpazillaListByDistId",
        method:"POST",
        data:{distId:distId, _token:_token},
        success:function(result)
        {
         $('#mill_upazila_id').html(result);
         $('#miller_birth_place').val(distId).change();
        }
       })
      }
     });

     $('#mill_upazila_id').change(function(){
      $('#user_id').val('');
      if($(this).val() != '')
      {
       var upazillaid = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/users/getUserListByUpzId",
        method:"POST",
        data:{upazillaid:upazillaid, _token:_token},
        success:function(result)
        {
         $('#user_id').html(result);
        }
       })
      }
     });

     $('#division_id').change(function(){
      $('#user_id').val('');
      if($(this).val() != '')
      {
       var divId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/users/getUserListByDivId",
        method:"POST",
        data:{divId:divId, _token:_token},
        success:function(result)
        {
         $('#user_id').html(result);
        }
       })
      }
     });

     $('#district_id').change(function(){
       $('#user_id').val('');
       if($(this).val() != '')
       {
        var distId = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
         url:"/users/getUserListByDistId",
         method:"POST",
         data:{distId:distId, _token:_token},
         success:function(result)
         {
          $('#user_id').html(result);
         }
        })
       }
      });

    $('#division_id').change(function(){
    $('#current_office_id').val('');
    if($(this).val() != '')
    {
        var divId = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
        url:"/users/getOfficeListByDivId",
        method:"POST",
        data:{divId:divId, _token:_token},
        success:function(result)
        {
        $('#current_office_id').html(result);
        }
        })
    }
    });

     $('#division_id1').change(function(){
      $('#district_id1').val('');
      $('#mill_upazila_id1').val('');
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var divId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/districts/getDistrictListByDivId",
        method:"POST",
        data:{divId:divId, _token:_token},
        success:function(result)
        {
         $('#district_id1').html(result);
        }
       })
      }
     });

     $('#district_id1').change(function(){
      $('#mill_upazila_id1').val('');
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var distId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/upazillas/getUpazillaListByDistId",
        method:"POST",
        data:{distId:distId, _token:_token},
        success:function(result)
        {
         $('#mill_upazila_id1').html(result);
        }
       })
      }
     });

     $('#mill_upazila_id1').change(function(){
      $('#current_office_id').val('');
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var upazila_id = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/users/getOfficeListByLSD",
        method:"POST",
        data:{upazila_id:upazila_id, _token:_token},
        success:function(result)
        {
         $('#current_office_id').html(result);
        }
       })
      }
     });



     $('#division_id2').change(function(){
      $('#district_id2').val('');
      $('#mill_upazila_id2').val('');
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var divId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/districts/getDistrictListByDivId",
        method:"POST",
        data:{divId:divId, _token:_token},
        success:function(result)
        {
         $('#district_id2').html(result);
        }
       })
      }
     });

     $('#district_id2').change(function(){
      $('#mill_upazila_id2').val('');
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var distId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/upazillas/getUpazillaListByDistId",
        method:"POST",
        data:{distId:distId, _token:_token},
        success:function(result)
        {
         $('#mill_upazila_id2').html(result);
        }
       })
      }
     });

     $('#mill_upazila_id2').change(function(){
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var upazila_id = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/users/getOfficeListByUpzId",
        method:"POST",
        data:{upazila_id:upazila_id, _token:_token},
        success:function(result)
        {
         $('#current_office_id').html(result);
        }
       })
      }
     });


     $('#division_id3').change(function(){
      $('#district_id3').val('');
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var divId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/districts/getDistrictListByDivId",
        method:"POST",
        data:{divId:divId, _token:_token},
        success:function(result)
        {
         $('#district_id3').html(result);
        }
       })
      }
     });

     $('#district_id3').change(function(){
      $('#current_office_id').val('');
      if($(this).val() != '')
      {
       var distId = $(this).val();
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"/users/getOfficeListByDistId",
        method:"POST",
        data:{distId:distId, _token:_token},
        success:function(result)
        {
         $('#current_office_id').html(result);
        }
       })
      }
     });


     $('#division_id5').change(function(){
        $('#district_id5').val('');
        $('#mill_upazila_id5').val('');
        if($(this).val() != '')
        {
         var divId = $(this).val();
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/districts/getDistrictListByDivId",
          method:"POST",
          data:{divId:divId, _token:_token},
          success:function(result)
          {
           $('#district_id5').html(result);
          }
         })
        }
       });
       $('#district_id5').change(function(){
        $('#mill_upazila_id5').val('');
        if($(this).val() != '')
        {
         var distId = $(this).val();
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/upazillas/getUpazillaListByDistId",
          method:"POST",
          data:{distId:distId, _token:_token},
          success:function(result)
          {
           $('#mill_upazila_id5').html(result);
          }
         })
        }
       });
       $('#mill_upazila_id5').change(function(){
        $('#user_id5').val('');
        if($(this).val() != '')
        {
         var upazillaid = $(this).val();
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/users/getUserListByUpzId",
          method:"POST",
          data:{upazillaid:upazillaid, _token:_token},
          success:function(result)
          {
           $('#user_id5').html(result);
          }
         })
        }
       });

       $('#division_id3d').change(function(){
        $('#district_id3d').val('');
        if($(this).val() != '')
        {
         var divId = $(this).val();
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/districts/getDistrictListByDivId",
          method:"POST",
          data:{divId:divId, _token:_token},
          success:function(result)
          {
           $('#district_id3d').html(result);
          }
         })
        }
       });

       $('#district_id3d').change(function(){
        $('#user_id3d').val('');
        if($(this).val() != '')
        {
         var distId = $(this).val();
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/users/getUserListByDistId",
          method:"POST",
          data:{distId:distId, _token:_token},
          success:function(result)
          {
           $('#user_id3d').html(result);
          }
         })
        }
       });

       $('.userform').submit(function(){
            if ($("#email").val() != $("#email_confirmation").val()) {
                alert("ইমেইল ও ইমেইল নিশ্চিত একরকম হয়নি।");
                $("#email_confirmation").focus();
                return false;
            }
            if ($("#password").val() != $("#password_confirmation").val()) {
                alert("পাসওয়ার্ড ও পাসওয়ার্ড নিশ্চিত একরকম হয়নি।");
                $("#password_confirmation").focus();
                return false;
            }
            return true;
        });
});

function checkbanglainput(e){
    var chr = String.fromCharCode( e.which );
    if( /[a-zA-Z0-9]/.test( chr ) ) {
        e.preventDefault();
    }
}


// Motor
function motorCalculate(count){
    var motor_powers = [650, 700, 750, 800, 850, 900, 1400, 1500, 1600, 1700, 1800, 1900, 2000, 2100, 2200, 2300, 2400, 2500, 2600];
    if ($("#motor_power_id"+count).val() != null) {
        $("#motor_filter_power"+count).val((motor_powers[$("#motor_power_id"+count).val() - 1]/1000).toFixed(2));
    }

    var areasum = 0;
    for (i = 1; i <= 10; i++) {

        if ($("#motor_power_id"+i).val() != null) {
                areasum += motor_powers[$("#motor_power_id"+i).val() - 1]/1000;
        }
    }

    $("#motor_area_total").val(areasum.toFixed(2));

    $("#motor_power").val((areasum * 8 * 11).toFixed(2));

    miller_p_power_calculate();
}

// Chatal
function chatalCalculate(count){
    if ($("#chatal_long"+count).val() != null && $("#chatal_wide"+count).val() != null) {
        $("#chatal_area"+count).val((convertToEnglishStr($("#chatal_long"+count).val()) * convertToEnglishStr($("#chatal_wide"+count).val())).toFixed(2));
    }

    var areasum = 0;
    for (i = 1; i <= 10; i++) {
        if ($("#chatal_long"+i).val() != null && $("#chatal_wide"+i).val() != null) {
                areasum += (convertToEnglishStr($("#chatal_long"+i).val()) * convertToEnglishStr($("#chatal_wide"+i).val()));
        }
    }

    $("#chatal_area_total").val(areasum.toFixed(2));
    $("#chatal_power").val(((areasum * 7) / 125).toFixed(2));

    miller_p_power_calculate();
}

//Godown
function godownCalculate(count){
    if ($("#godown_long"+count).val() != null && $("#godown_wide"+count).val() != null
    && $("#godown_height"+count).val() != null)
    {
        $("#godown_valume"+count).val((convertToEnglishStr($("#godown_long"+count).val()) * convertToEnglishStr($("#godown_wide"+count).val())
        * convertToEnglishStr($("#godown_height"+count).val())).toFixed(2));
    }

    var volumesum = 0;
    for (i = 1; i <= 10; i++) {

        if ($("#godown_long"+i).val() != null && $("#godown_wide"+i).val() != null
        && $("#godown_height"+i).val() != null)
        {
            volumesum += (convertToEnglishStr($("#godown_long"+i).val()) * convertToEnglishStr($("#godown_wide"+i).val()) * convertToEnglishStr($("#godown_height"+i).val()));
        }
    }

    $("#godown_area_total").val(volumesum.toFixed(2));
    $("#godown_power").val((volumesum / 4.077).toFixed(2));
    
    let siloPower = parseFloat($("#silo_power").val()) || 0;
    let godownPower = parseFloat($("#godown_power").val()) || 0;
    $("#final_godown_silo_power").val((siloPower + godownPower).toFixed(2));
    miller_p_power_calculate();
}

//silo
function siloCalculate(count){
    if ($("#silo_radius"+count).val() != null && $("#silo_height"+count).val() != null)
    {
        $("#silo_volume"+count).val(
            (Math.PI *
             Math.pow(convertToEnglishStr($("#silo_radius"+count).val()), 2) *
             convertToEnglishStr($("#silo_height"+count).val())
            ).toFixed(2)
        );
    }

    var volumesum = 0;
    for (i = 1; i <= 10; i++) {

        if ($("#silo_radius"+i).val() != null && $("#silo_height"+i).val() != null)
        {
            let r = convertToEnglishStr($("#silo_radius"+i).val()); // Get radius
            let h = convertToEnglishStr($("#silo_height"+i).val()); // Get height

            if (r && h) {
                let volume = Math.PI * Math.pow(r, 2) * h; // Apply πr^2h formula
                volumesum += volume;
                $("#silo_volume"+i).val(volume.toFixed(2)); // Set the calculated volume
            }
        }
    }

    $("#silo_area_total").val(volumesum.toFixed(2));
    $("#silo_power").val((volumesum / 1.75).toFixed(2));
    let siloPower = parseFloat($("#silo_power").val()) || 0;
    let godownPower = parseFloat($("#godown_power").val()) || 0;
    $("#final_godown_silo_power").val((siloPower + godownPower).toFixed(2));

    miller_p_power_calculate();
}

//Steeping
function steepingCalculate(count){
    if ($("#steeping_house_long"+count).val() != null && $("#steeping_house_wide"+count).val() != null
    && $("#steeping_house_height"+count).val() != null)
    {
        $("#steeping_house_volume"+count).val((convertToEnglishStr($("#steeping_house_long"+count).val()) * convertToEnglishStr($("#steeping_house_wide"+count).val())
        * convertToEnglishStr($("#steeping_house_height"+count).val())).toFixed(2));
    }

    var volumesum = 0;

    for (i = 1; i <= 10; i++) {
        if ($("#steeping_house_long"+i).val() != null && $("#steeping_house_wide"+i).val() != null
        && $("#steeping_house_height"+i).val() != null)
        {
            volumesum += (convertToEnglishStr($("#steeping_house_long"+i).val()) * convertToEnglishStr($("#steeping_house_wide"+i).val()) *
            convertToEnglishStr($("#steeping_house_height"+i).val()));
        }
    }

    $("#steping_area_total").val(volumesum.toFixed(2));
    $("#steping_power").val(((volumesum/1.75) * 7).toFixed(2));

    miller_p_power_calculate();
}

function boilerMachineriesCalculate(count){
    n = $("#boiler_machineries_num"+count).val();
    p = $("#boiler_machineries_power"+count).val();

    if (n != null && p != null)
    {
        $("#boiler_machineries_topower"+count).val(
            (convertToEnglishStr(n) * convertToEnglishStr(p)).toFixed(2)
        );
    }

    var volumesum = 0;
    for (i = 1; i <= 10; i++) {

        if ($("#boiler_machineries_num"+i).val() != null && $("#boiler_machineries_power"+i).val() != null)
        {
            volumesum += (convertToEnglishStr($("#boiler_machineries_num"+i).val()) * convertToEnglishStr($("#boiler_machineries_power"+i).val()));
        }
    }

    $("#boiler_machineries_steampower").val(volumesum.toFixed(2));
    $("#boiler_machineries_power").val((volumesum * 12).toFixed(2));

    miller_p_power_calculate();

}

function millUnitMachineriesCalculate(count){
    n = $("#milling_unit_machinery_num"+count).val();
    p = $("#milling_unit_machinery_power"+count).val();
    op = $("#milling_unit_machinery_join_type"+count+" option:selected").val();

    if(op == "অনুক্রম")
        n="১";

    if (n != null && p != null)
    {
        $("#milling_unit_machinery_topower"+count).val(
            (convertToEnglishStr(n) * convertToEnglishStr(p)).toFixed(2)
        );

        $("#mill_milling_unit_machineries_output_"+count).text(
            (convertToEnglishStr(n) * convertToEnglishStr(p)).toFixed(2)
        );
    }
}

//Boiler
function boilerCalculate(count){
    r = $("#boiler_radius"+count).val();
    h1 = $("#cylinder_height"+count).val();
    h2 = $("#cone_height"+count).val();
    qty = $("#qty"+count).val();

    if (r != null && h1 != null && h2 != null)
    {
        $("#boiler_volume"+count).val(
            (
                Math.PI * (convertToEnglishStr(r) * convertToEnglishStr(r) * convertToEnglishStr(h1) +
                (convertToEnglishStr(r) * convertToEnglishStr(r) * convertToEnglishStr(h2))/3)
            ).toFixed(2)
        );
    }

    var volumesum = 0;
    var qtysum = 0;

    for (i = 1; i <= 10; i++) {
        r = $("#boiler_radius"+i).val();
        h1 = $("#cylinder_height"+i).val();
        h2 = $("#cone_height"+i).val();
        qty = $("#qty"+i).val();

        if (r != null && h1 != null && h2 != null)
        {
            volumesum += Math.PI * (convertToEnglishStr(r) * convertToEnglishStr(r) * convertToEnglishStr(h1) +
            (convertToEnglishStr(r) * convertToEnglishStr(r) * convertToEnglishStr(h2))/3) * convertToEnglishStr(qty);
        }

        if(qty != null)
            qtysum += convertToEnglishStr(qty)/1;
    }

    $("#boiler_number_total").val(qtysum);
    $("#boiler_volume_total").val(volumesum.toFixed(2));
    $("#boiler_power").val(((volumesum/1.75) * 13).toFixed(2));

    miller_p_power_calculate();
}

//Dryer
function dryerCalculate(count){
    l = $("#dryer_length"+count).val();
    w = $("#dryer_width"+count).val();
    h1 = $("#cube_height"+count).val();
    h2 = $("#pyramid_height"+count).val();

    if (l != null && w != null && h1 != null && h2 != null)
    {
        $("#dryer_volume"+count).val(
            (
                (convertToEnglishStr(l) * convertToEnglishStr(w) * convertToEnglishStr(h1) +
                (convertToEnglishStr(l) * convertToEnglishStr(w) * convertToEnglishStr(h2))/3)
            ).toFixed(2)
        );
    }

    var volumesum = 0;

    for (i = 1; i <= 10; i++) {
        l = $("#dryer_length"+i).val();
        w = $("#dryer_width"+i).val();
        h1 = $("#cube_height"+i).val();
        h2 = $("#pyramid_height"+i).val();

        if (l != null && w != null && h1 != null && h2 != null)
        {
            volumesum += (convertToEnglishStr(l) * convertToEnglishStr(w) * convertToEnglishStr(h1) +
            (convertToEnglishStr(l) * convertToEnglishStr(w) * convertToEnglishStr(h2))/3);
        }
    }

    $("#dryer_volume_total").val(volumesum.toFixed(2));
    $("#dryer_power").val(((volumesum*.65/1.75) * 13).toFixed(2));

    miller_p_power_calculate();
}

//MillingUnit
function millingUnitCalculate(){
    o1 = $("#sheller_paddy_seperator_output").val();
    o2 = $("#whitener_grader_output").val();
    o3 = $("#colour_sorter_output").val();

    $("#sheller_paddy_seperator_output_hour").text(convertToEnglishStr(o1)*60);
    $("#whitener_grader_output_hour").text(convertToEnglishStr(o2)*60);
    $("#colour_sorter_output_hour").text((convertToEnglishStr(o3)*60).toFixed(2));

    var minoutput = 0;
    if (o1 != null && o2 != null && o3 != null)
    {
        minoutput = Math.min(convertToEnglishStr(o1), convertToEnglishStr(o2), convertToEnglishStr(o3));
    }

    $("#milling_unit_output").val(minoutput.toFixed(2));
    //$("#milling_unit_power").val((minoutput*6.24).toFixed(2));
    $("#milling_unit_power").val((minoutput*9.6).toFixed(2));

    miller_p_power_calculate();
}

function miller_p_power_calculate(){
    var millar_p_power = 0;

    if($("#mill_type_id").val() ==3 || $("#mill_type_id").val() == 4)
    {
        millar_p_power = Math.min($("#chatal_power").val(), $("#steping_power").val(), $("#godown_power").val(), $("#motor_power").val());
    }
    else if($("#mill_type_id").val() == 1)
    {
        millar_p_power = Math.min($("#chatal_power").val(), $("#godown_power").val(), $("#motor_power").val());
    }
    else if($("#mill_type_id").val() == 5)
    {
        if($("#chal_type_id option:selected").val() != 1)
            millar_p_power = Math.min($("#boiler_machineries_power").val(), $("#boiler_power").val(), $("#dryer_power").val(), $("#final_godown_silo_power").val(), $("#milling_unit_power").val());
        else
            millar_p_power = Math.min($("#boiler_machineries_power").val(), $("#dryer_power").val(), $("#final_godown_silo_power").val(), $("#milling_unit_power").val());
    }

    $("#millar_p_power").val(millar_p_power.toFixed(2));
}

function convertToEnglish(bngNum)
{
    var engNum = 0;

    if(bngNum.length==1)
    {
        if(bngNum=='১'){engNum=1;}

        else if(bngNum=='২'){engNum=2;}

        else if(bngNum=='৩'){engNum=3;}

        else if(bngNum=='৪'){engNum=4;}

        else if(bngNum=='৫'){engNum=5;}

        else if(bngNum=='৬'){engNum=6;}

        else if(bngNum=='৭'){engNum=7;}

        else if(bngNum=='৮'){engNum=8;}

        else if(bngNum=='৯'){engNum=9;}

        else if(bngNum=='০'){engNum=0;}

        else if(bngNum=='.'){engNum='.';}
    }

    return engNum;
}

function convertToEnglishStr(str)
{
    var banStr = str;
    var banStrLen = banStr.length;
    var engStr = "";

    for(var i=0;i<=banStrLen-1;i++)
    {
        var chunck = banStr.substr(i,1);

        if(chunck!=' '){
            var engChunk = convertToEnglish(chunck);
        }
        else
        {
            var engChunk ='';
        }
        var engStr = engStr + engChunk;
    }

    return engStr;
}


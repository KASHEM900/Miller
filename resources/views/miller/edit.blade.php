@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div style="float:right">
                <input type="checkbox" checked style="display: none" name="selected_id" value="{{$miller->miller_id}}">
                <a class="btn btn-primary" href="{{route('millers.list')}}?page={{$pp_page}}&division_id={{$pp_division}}&district_id={{$pp_district}}&mill_upazila_id={{$pp_mill_upazila}}&mill_type_id={{$pp_mill_type_id}}&chal_type_id={{$pp_chal_type_id}}&miller_status={{$pp_miller_status}}&cmp_status={{$pp_cmp_status}}&searchtext={{$pp_searchtext}}">আগের পৃষ্ঠা</a>
                <input type="button" class="btn btn-primary" value="প্রিন্ট ফরম" onclick="printForms()">
                <input type="button" class="btn btn-primary" value="প্রিন্ট লাইসেন্স" onclick="printLicenseForms()">
                <a href="../../millers.send2fps?miller_id={{$miller->miller_id}}" class="btn btn-large btn-danger show_confirm">Send to FPS</a>
            </div>
            <div id="report_print" class="report_page">
                <div id="overlay">
					<div id="blanket"></div>
				</div>
                <h2 align="center">@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif
                চালকলের মিলিং ক্ষমতা নির্ণয় ফরম</h2>

                <p style="text-align:center; color: #e53e3e; font-weight: 700; font-size:16px;">চালকলের তথ্য এফ পি এস সিস্টেমে পাঠাতে 'Send to FPS' বাটন  চাপুন |</p>

                @if(session()->has('message'))
                <div class="alert alert-success">
                    {!! session()->get('message') !!}
                </div>
                @endif


                @if ($errors->any())
                    <div class="alert alert-danger">
                    <strong>দুঃখিত!</strong> আপনার এন্ট্রি করতে কোনো সমস্যা হয়েছে|<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @include('miller.chalkol_preview')
                @include('miller.chalkol_form')

                @include('miller.license_preview')
                @include('miller.license_form')

                @if($miller->mill_type_id==2)

                    @if($miller->autometic_miller)
                        @include('miller.autometic_mechin_preview')
                        @include('miller.autometic_mechin_form')

                        @include('miller.auto_para_preview')
                        @include('miller.auto_para_form')
                    @endif

                    @include('miller.auto_p_pwer')
                    @include('miller.auto_p_pwer_form')

                @else

                    @if($miller->mill_type_id!=1 && $miller->mill_type_id!=5)

                        @include('miller.boiller_preview')
                        @include('miller.boiller_form')

                        @include('miller.chimni_preview')
                        @include('miller.chimni_form')

                    @endif

                    @if($miller->mill_type_id==5)
                        @include('miller.milling_unit_machineries_preview')
                        @include('miller.milling_unit_machineries_form')

                        @include('miller.boiler_machineries_preview')
                        @include('miller.boiler_machineries_form')
                    @endif

                    @include('miller.godown_preview')
                    @include('miller.godown_form')

                    @if($miller->mill_type_id!=5)
                        @include('miller.chatal_preview')
                        @include('miller.chatal_form')

                        @if($miller->mill_type_id!=1)

                            @include('miller.steping_preview')
                            @include('miller.steping_form')

                        @endif

                        @include('miller.motor_preview')
                        @include('miller.motor_form')

                    @else
                        @if($miller->chal_type_id!=1)
                            @include('miller.boiler_preview')
                            @include('miller.boiler_form')
                        @endif

                        @include('miller.dryer_preview')
                        @include('miller.dryer_form')

                        @include('miller.milling_unit_preview')
                        @include('miller.milling_unit_form')

                    @endif

                    @if($miller->mill_type_id == 4)
                        @include('miller.rsolar_preview')
                        @include('miller.rsolar_form')
                    @endif

                    @include('miller.p_power_preview')
                    @include('miller.p_power_form')

                @endif
                <br/>
                @include('miller.authorization_preview')
                <br/>
                <p style="text-align:center">
                    <a href="../../millers.approve?miller_id={{$miller->miller_id}}" class="btn btn-large btn-success">Approve</a>
                    <a href="../../millers.send2fps?miller_id={{$miller->miller_id}}" class="btn btn-large btn-danger show_confirm">Send to FPS</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        @if($miller->cmp_status || $miller->miller_status != 'new_register')
        $(".edit-button").click(function () {
                //takes the ID of appropriate dialogue
                var id = $(this).attr('id');
               //open dialogue
               $("#"+id+"_preview").hide();
               $("#"+id+"_form").show();
            });

            $(".close-button").click(function () {
                //takes the ID of appropriate dialogue
                var id = $(this).attr('id');
               //open dialogue
               $("#"+id+"_preview").show();
               $("#"+id+"_form").hide();
            });
        @else
            $(".edit-button").hide();
        @endif

        $('.show_confirm_approve').click(function(e) {
            if(!confirm("এপ্রুভ করার পূর্বে চালকলের সব তথ্য চেক করে নিন। একবার  এপ্রুভ করার পর, তা পরিবর্তন করার কোনো সুযোগ নেই| আপনি কি এখুনি এপ্রুভ করতে চান?")) {
                e.preventDefault();
            }
        });

        $('.show_confirm').click(function(e) {
            if(!confirm("এফ পি এস সিস্টেমে তথ্য পাঠানোর পূর্বে অনুগ্রহ করে চালকলের লাইসেন্স নম্বর চেক করে নিন| একবার এফ পি এস সিস্টেমে তথ্য পাঠানোর পর, লাইসেন্স নম্বর পরিবর্তন করার কোনো সুযোগ নেই| আপনি কি এফ পি এস সিস্টেমে তথ্য পাঠাতে চান?")) {
                e.preventDefault();
                var id = $(this).attr('id');
                //open dialogue
                $("#license_preview").hide();
                $("#license_form").show();
                $("#license_no").focus();
            }
        });
    });

    $(function () {
        $(".upload").bind("change", function () {
            let file = this.files[0];
            let allowedExtensions = ["jpeg", "jpg", "png"];
            let fileSizeLimit = 1024 * 1024 * 2; // 2MB
            let fileName = file.name.toLowerCase();
            let fileExtension = fileName.split('.').pop();

            // Check file type
            if (!allowedExtensions.includes(fileExtension)) {
                alert("শুধুমাত্র JPEG, JPG এবং PNG ফাইল আপলোড করা যাবে।");
                this.value = "";
                return;
            }

            // Check file size
            if (file.size > fileSizeLimit) {
                alert("ফাইলটির সাইজ ২ মেগাবাইট এর বেশি, দয়া করে কম সাইজের ফাইল সিলেক্ট করুন।");
                this.value = "";
            }
        });

        $("input[name='photo_file']").bind("change", function () {
        let file = this.files[0];

        if (file) { // Check if a file is selected

            // Check image dimensions **ONLY for photo_file field**
            let img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = () => {
                if (img.width !== 300 || img.height !== 300) {
                    alert("ছবির সাইজ 300x300 পিক্সেল হতে হবে।");
                    $(this).val(""); // Clear only this input field
                }
            };
        }
    });
    });

</script>

@endsection

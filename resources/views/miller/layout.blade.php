@extends('layouts.app')

@section('content')
<div class="row">
<div style="padding-top:10px" class="col-2 shadow">
<ul>
    <li><strong>চালকল ম্যানেজ</strong>
        <ul id="sub_nav_mng" class="sidenav ">
            @if(DGFAuth::check(4020, 1,  3) || DGFAuth::check(4010, 1,  4))
            <li class="nav-item"><a class="nav-link" href="millers.list"> এডিট ও ডিলিট চালকল </a></li>
            @endif

            <ul id="sub_nav_mng" class="sidenav ">
            @if(DGFAuth::check(4030, 1,  3))
                <li class="nav-item"><a class="nav-link" href="/inspections"> চালকল পরিদর্শন </a></li>
            @endif
            </ul>

            <ul id="sub_nav_mng" class="sidenav ">
            @if(DGFAuth::check(4040, 1,  2))
                <li class="nav-item"><a class="nav-link" href="/searchPasscode"> পাসকোড অনুসন্ধান </a></li>
            @endif
            </ul>

            <ul id="sub_nav_mng" class="sidenav">
            @if(DGFAuth::check(4060, 1,  2))
                <li class="nav-item"><a class="nav-link" href="/newRegisterMiller"> নতুন চালকল </a></li>
            @endif
            </ul>


             <ul id="sub_nav_mng" class="sidenav">
             @if(DGFAuth::check(4050, 1,  2))
                <li class="nav-item"><a class="nav-link" href="/invalidLicence">অনবায়নকৃত লাইসেন্স </a></li>
            @endif
            </ul>

            <ul id="sub_nav_mng" class="sidenav">
            @if(DGFAuth::check(4051, 1,  2))
                <li class="nav-item"><a class="nav-link" href="/validLicence">নবায়নকৃত লাইসেন্স </a></li>
            @endif
           </ul>

            <!--<ul id="sub_nav_mng" class="sidenav">

                <li class="nav-item"><a class="nav-link" href="/newLicence">নতুন লাইসেন্স </a></li>

            </ul>-->

            <ul id="sub_nav_mng" class="sidenav"> 
            @if(DGFAuth::check(4052, 1,  2))
                <li class="nav-item"><a class="nav-link" href="/duplicateLicence">ডুপ্লিকেট লাইসেন্স </a></li>
            @endif
            </ul>  

            <ul id="sub_nav_mng" class="sidenav">
            @if(DGFAuth::check(4080, 1,  2))
                <li class="nav-item"><a class="nav-link" href="/millerListFPSStatus">মিলার স্ট্যাটাস ইন এফ পি এস সিস্টেম </a></li>
            @endif
            </ul> 

            <ul id="sub_nav_mng" class="sidenav">
            @if(DGFAuth::check(4070, 1,  2))
                <li class="nav-item"><a class="nav-link" href="/activity"> একটিভিটি লগ </a></li>
            @endif
            </ul>     
     </li>
 </ul>
</div>

<div class="col-10">
    @yield('contentbody')
</div>
</div>
@endsection

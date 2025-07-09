@extends('layouts.app')

@section('content')
<div class="row">
<div style="padding-top:10px" class="col-2 shadow">
<ul>
    @if(DGFAuth::check(5010))
    <li><strong>অঞ্চল</strong>
        <ul id="sub_nav_mng" class="sidenav ">
            @if(DGFAuth::check(5011))
            <li class="nav-item"><a class="nav-link" href="/divisions"> বিভাগ</a></li>
            @endif
            @if(DGFAuth::check(5012))
            <li class="nav-item"><a class="nav-link" href="/districts"> জেলা</a></li>
            @endif
            @if(DGFAuth::check(5013))
            <li class="nav-item"><a class="nav-link" href="/upazillas"> উপজেলা</a></li>
            @endif            
        </ul>
    </li>
    @endif
    @if(DGFAuth::check(5020))
    <li><strong> সেটিং</strong>
        <ul id="manage_nav" class="sidenav">

            @if(DGFAuth::check(5021))
            <li class="nav-item"><a class="nav-link" href="/chaltypes"> চালের ধরন</a></li>
            @endif
            @if(DGFAuth::check(5022))
            <li class="nav-item"><a class="nav-link" href="/milltypes"> চালকলের ধরন</a></li>
            @endif
            @if(DGFAuth::check(5023))
            <li class="nav-item"><a class="nav-link" href="/motorpowers"> মটরের ক্ষমতা</a></li>
            @endif
            @if(DGFAuth::check(5024))
            <li class="nav-item"><a class="nav-link" href="/office_types"> অফিসের ধরন</a></li>
            @endif
            @if(DGFAuth::check(5025))
            <li class="nav-item"><a class="nav-link" href="/offices"> অফিস</a></li>
            @endif
            @if(DGFAuth::check(5026))
            <li class="nav-item"><a class="nav-link" href="/inspection_periods"> পরিদর্শন পিরিয়ড</a></li>
            @endif
            @if(DGFAuth::check(5027))
            <li class="nav-item"><a class="nav-link" href="/license_types"> লাইসেন্স টাইপ</a></li>
            @endif
            @if(DGFAuth::check(5028))
            <li class="nav-item"><a class="nav-link" href="/license_fees"> লাইসেন্স ফী</a></li>
            @endif
            @if(DGFAuth::check(5029))
            <li class="nav-item"><a class="nav-link" href="/millingunitmachineries"> মিলিং ইউনিটের যন্ত্রপাতি</a></li>
            @endif
            @if(DGFAuth::check(5036))
            <li class="nav-item"><a class="nav-link" href="/corporate_institutes"> কর্পোরেট প্রতিষ্ঠান</a></li>
            @endif
            @if(Auth::user()->name == "sadmin")
            <li class="nav-item"><a class="nav-link" href="/millers.fpshotfix"> এফ পি এস হট ফিক্স</a></li>
            @endif
            
        </ul>    
    </li>
    @endif
    @if(DGFAuth::check(5030))
    <li><strong> পারমিশন</strong>
        <ul id="manage_nav" class="sidenav">
            @if(DGFAuth::check(5031))
            <li class="nav-item"><a class="nav-link" href="/events"> ইভেন্ট</a></li>
            @endif
            @if(DGFAuth::check(5032))
            <li class="nav-item"><a class="nav-link" href="/usertypes"> ইউজারের ধরন</a></li>
            @endif
            @if(DGFAuth::check(5033))
            <li class="nav-item"><a class="nav-link" href="/menupermissions"> ইউজারের ধরন অনুযায়ী পারমিশন</a></li> 
            @endif 
            @if(DGFAuth::check(5034))
           <li class="nav-item"><a class="nav-link" href="/eventPermissionTimes">ইভেন্টস পারমিশন সময়নিরুপণ</a></li>
           @endif
           @if(DGFAuth::check(5035))
           <li class="nav-item"><a class="nav-link" href="/registration_permission_times">রেজিস্ট্রেশন পারমিশন সময়নিরুপণ</a></li>
            @endif          
        </ul>    
    </li>
    @endif
</ul>
</div>

<div class="col-10">
    <div class="container">
        @yield('contentbody')
    </div>
</div>
</div>
@endsection

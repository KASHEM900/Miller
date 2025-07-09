@extends('layouts.app')

@section('content')
<div class="row">
<div style="padding-top:10px" class="col-2 shadow">
<ul>
    @if(DGFAuth::check(2010, 2, 1))
    <li><strong>নতুন ইউজার তৈরি করুন</strong>
        <ul id="sub_nav_mng" class="sidenav ">
            @if(DGFAuth::check(2011))
                <li class="nav-item"><a class="nav-link"  href="createuser"> এডমিন ইউজার</a></li>
            @endif
            @if(DGFAuth::check(2012))
                <li class="nav-item"><a class="nav-link"  href="createuser1"> DGF ইউজার</a></li>
            @endif
            @if(DGFAuth::check(2013, 2, 1))
                <li class="nav-item"><a class="nav-link" href="createuser2"> বিভাগীয় ইউজার</a></li>
            @endif
            @if(DGFAuth::check(2014, 2, 1))
                <li class="nav-item"><a class="nav-link" href="createuser3"> জেলা ইউজার</a></li>
            @endif
            @if(DGFAuth::check(2015, 2, 1))
                <li class="nav-item"><a class="nav-link" href="createuser4"> উপজেলা ইউজার</a></li>
            @endif
            <!-- @if(DGFAuth::check(2016, 2, 1))
                <li class="nav-item"><a class="nav-link" href="createuser5"> CSD/LSD ইউজার</a></li>
            @endif-->
            @if(DGFAuth::check(2017, 2, 1))
                <li class="nav-item"><a class="nav-link" href="createuser6"> সাইলো ইউজার</a></li>
            @endif
        </ul>
    </li>
    @endif
    @if(DGFAuth::check(2020, 2, 2))
    <li><strong> ম্যানেজ ইউজার</strong>
        <ul id="manage_nav" class="sidenav">
            @if(DGFAuth::check(2021))
                <li class="nav-item"><a class="nav-link" href="showpermission">ইউজার পারমিশন</a></li>
            @endif
            @if(DGFAuth::check(2022, 2, 2))
                <li class="nav-item"><a class="nav-link" href="{{route('users.index')}}">ইউজার লিস্ট</a></li>
            @endif
            @if(DGFAuth::check(2023, 2, 4))
                <li class="nav-item"><a class="nav-link" href="deleteindex">ডিলিট ইউজার </a></li>
            @endif
            @if(DGFAuth::check(2024, 2, 3 ))
                <li class="nav-item"><a class="nav-link" href="editdgfindex">এডিট DGF ইউজার</a></li>
            @endif
            @if(DGFAuth::check(2025, 2, 3 ))
                <li class="nav-item"><a class="nav-link" href="editdivisionindex">এডিট বিভাগীয় ইউজার</a></li>
            @endif
            @if(DGFAuth::check(2026, 2, 3))
                <li class="nav-item"><a class="nav-link" href="editdisupzindex">এডিট জেলা ও উপজেলা ইউজার</a></li>
            @endif
            <!--  @if(DGFAuth::check(2027, 2, 3))
                <li class="nav-item"><a class="nav-link" href="editlsdindex">এডিট CSD/LSD ইউজার</a></li>
            @endif-->
            @if(DGFAuth::check(2028, 2, 3))
                <li class="nav-item"><a class="nav-link" href="editsailoindex">এডিট সাইলো ইউজার</a></li>
            @endif
        </ul>    
    </li>
    @endif
</ul>
</div>
<div class="col-10">
    @yield('contentbody')
</div>
</div>
@endsection
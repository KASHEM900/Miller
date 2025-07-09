@extends('layouts.app')

@section('content')
<div class="row">
<div style="padding-top:10px" class="col-2 shadow">
<ul>
    <li><strong>চালকলের তালিকা</strong>
        <ul id="sub_nav_mng" class="sidenav ">
            @if(DGFAuth::check(3010))
            <li class="nav-item"><a class="nav-link" href="/infowise">  তথ্য অনুযায়ী  </a></li>
            @endif
            @if(DGFAuth::check(3020))
            <li class="nav-item"><a class="nav-link" href="/regionwise">  অঞ্চল অনুযায়ী  </a></li>
            @endif
            @if(DGFAuth::check(3030))
            <li class="nav-item"><a class="nav-link" href="/typewise">  চালকলের ধরণ অনুযায়ী  </a></li>
            @endif
            @if(DGFAuth::check(3040))
            <li class="nav-item"><a class="nav-link" href="/summary/1">  সংক্ষিপ্ত প্রতিবেদন (আতপ)</a></li>
            @endif
            @if(DGFAuth::check(3040))
            <li class="nav-item"><a class="nav-link" href="/summary/2">  সংক্ষিপ্ত প্রতিবেদন (সিদ্ধ)</a></li>
            @endif
            @if(DGFAuth::check(3040))
            <li class="nav-item"><a class="nav-link" href="/summarycorporate/1">  সংক্ষিপ্ত প্রতিবেদন (আতপ - কর্পোরেট)</a></li>
            @endif
            @if(DGFAuth::check(3040))
            <li class="nav-item"><a class="nav-link" href="/summarycorporate/2">  সংক্ষিপ্ত প্রতিবেদন (সিদ্ধ - কর্পোরেট)</a></li>
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

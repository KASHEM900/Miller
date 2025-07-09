@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-2xl">সংক্ষিপ্ত তথ্য</div>

                <div class="card-body">
                    <table cellpadding="5px">
                        <tr class="text-xl">
                            <strong>
                            <td>ইউজারের নাম</td>
                            <td>:</td>
                            <td>{{ Auth::user()->name }} </td>
                            </strong>
                        </tr>
                        <tr>
                            <td>ইউজারের ইমেইল</td>
                            <td>:</td>
                            <td>{{ Auth::user()->email }} </td>
                        </tr>
                        <tr>
                            <td>ইউজারের টাইপ</td>
                            <td>:</td>
                            <td>
                                {{ Auth::user()->usertype->name }}
                                {{-- @if(Auth::user()->user_type == 99)
                                    অ্যাডমিন
                                @elseif(Auth::user()->user_type == 1)
                                    DGF
                                @elseif(Auth::user()>user_type == 2)
                                    বিভাগীয়
                                @elseif(Auth::user()->user_type == 3)
                                    জেলা
                                @elseif(Auth::user()->user_type == 4)
                                    উপজেলা
                                @elseif(Auth::user()->user_type == 5)
                                    LSD
                                @else
                                    ইউজার
                                @endif --}}
                        </tr>
                        <tr>
                            <td>ইউজারের স্ট্যাটাস</td>
                            <td>:</td>
                            <td>{{ Auth::user()->UserStatus }} </td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <table cellpadding="5px">
                        <tr >
                            <td>বিভাগ</td>
                            <td>:</td>
                            <td>{{ Auth::user()->DivisionName }} </td>
                        </tr>
                        <tr>
                            <td>জেলা</td>
                            <td>:</td>
                            <td>{{ Auth::user()->DistrictName }}</td>
                        </tr>
                        <tr>
                            <td>উপজেলা</td>
                            <td>:</td>
                            <td>{{ Auth::user()->UpazillaName }}</td>
                        </tr>
                    </table>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection

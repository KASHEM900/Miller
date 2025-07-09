@extends('users.layout')

@section('contentbody')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-2xl">সংক্ষিপ্ত তথ্য</div>

                <div class="card-body">
                    <table cellpadding="5px">
                        <tr class="text-xl">
                            <strong>
                            <td>ইউজারের সংখ্যা</td>
                            <td>:</td>
                            <td>{{ BanglaConverter::en2bn(0, $usercount) }}</td>
                            </strong>
                        </tr>
                        <tr>
                            <td>একটিভ ইউজারের সংখ্যা</td>
                            <td>:</td>
                            <td>{{  BanglaConverter::en2bn(0, $activeusercount) }}</td>
                        </tr>
                        <tr>
                            <td>ইনএকটিভ ইউজারের সংখ্যা</td>
                            <td>:</td>
                            <td>{{ BanglaConverter::en2bn(0, $inactiveusercount) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>এডমিন ইউজারের সংখ্যা</td>
                            <td>:</td>
                            <td>{{ BanglaConverter::en2bn(0, $adminusercount) }}</td>
                        </tr>
                        <tr>
                            <td>বিভাগীয় ইউজারের সংখ্যা</td>
                            <td>:</td>
                            <td>{{ BanglaConverter::en2bn(0, $divisionusercount) }}</td>
                        </tr>
                        <tr>
                            <td>জেলা ইউজারের সংখ্যা</td>
                            <td>:</td>
                            <td>{{ BanglaConverter::en2bn(0, $districtuserercount) }}</td>
                        </tr>
                        <tr>
                            <td>উপজেলা ইউজারের সংখ্যা</td>
                            <td>:</td>
                            <td>{{ BanglaConverter::en2bn(0, $upazillauserercount) }}</td>
                        </tr>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection


@extends('miller.layout')

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
                            <td>চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td>{{ App\BanglaConverter::en2bn(0, $millercount) }}</td>
                            </strong>
                        </tr>
                        <tr>
                            <td>পূর্ন তথ্যসম্ব্যলীত চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td><a href="millers.list?cmp_status=1">{{ App\BanglaConverter::en2bn(0,  $activemillercount ) }}</a></td>
                        </tr>
                        <tr>
                            <td>অসম্পূর্ন তথ্যসম্ব্যলীত চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td><a href="millers.list?cmp_status=0">{{ App\BanglaConverter::en2bn(0, $inactivemillercount) }}</a></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>অটোমেটিক চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td><a href="millers.list?mill_type_id=2">{{ App\BanglaConverter::en2bn(0, $automillercount) }}</a></td>
                        </tr>
                        <tr>
                            <td>সেমি-অটোমেটিক চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td><a href="millers.list?mill_type_id=1">{{ App\BanglaConverter::en2bn(0, $semiautomillercount) }}</a></td>
                        </tr>
                        <tr>
                            <td>রাবার শেলার ও পলিশার যুক্ত হাস্কিং চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td><a href="millers.list?mill_type_id=4">{{ App\BanglaConverter::en2bn(0, $withpislersemiautomillercount) }}</a></td>
                        </tr>
                        <tr>
                            <td>রাবার শেলার ও পলিশার বিহীন হাস্কিং চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td><a href="millers.list?mill_type_id=3">{{ App\BanglaConverter::en2bn(0, $exceptpislerautomillercount) }}</a></td>
                        </tr>
                        <tr>
                            <td>হালনাগাদকৃত অটোমেটিক চালকলের সংখ্যা</td>
                            <td>:</td>
                            <td><a href="millers.list?mill_type_id=3">{{ App\BanglaConverter::en2bn(0, $newautomillercount) }}</a></td>
                        </tr>
                    </table>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection


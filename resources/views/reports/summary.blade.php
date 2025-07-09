@extends('reports.layout')

@section('contentbody')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card"  id="report_print_summery">
                <div class="card-header text-2xl flex justify-between" style="text-align: center">
                    <h4>চালকলের সংক্ষিপ্ত প্রতিবেদন আতপ - সিদ্ধ {{ $headertext }} (চালের ধরন: {{$chal_type}})</h4>
                    <div>
                    @if($level==1)
                        <a class="btn btn-secondary print_hide" href="{{ route('summary', $chal_type_id) }}">
                    @elseif($level==2)
                        <a class="btn btn-secondary print_hide" href="{{ route('summarywithdivision', [$returnid, $chal_type_id]) }}">
                    @elseif($level==3)
                        <a class="btn btn-secondary print_hide" href="{{ route('summarywithdistrict', [$returnid, $chal_type_id]) }}">
                    @endif

                    @if($level==1 || $level==2 || $level==3)
                        আগের পৃষ্ঠা
                        </a>
                    @endif
                    <span><input type="button"  class="btn btn-secondary print_hide" value="প্রিন্ট করুন" onclick="printPage('report_print_summery')"></span>
                    </div>
                </div>

                <div class="card-body">
                    <div>
                    <table width="100%" border="1" cellspacing="0" cellpadding="0">

                            <thead>
                                <tr bgcolor="silver" style="height:2px;">
                                    <td></td>
                                    <td style="text-align: center" colspan="2" rowspan="">অটোমেটিক চালকলের </td>
                                    <td style="text-align: center" colspan="2" rowspan="">সেমি-অটোমেটিক চালকলের </td>
                                    <td style="text-align: center" colspan="2" rowspan="">রাবার শেলার যুক্ত (হাস্কিং) চালকলের </td>
                                    <td style="text-align: center" colspan="2" rowspan="">রাবার শেলার বিহীন (হাস্কিং) চালকলের </td>
                                    <td style="text-align: center" colspan="2" rowspan="">হালনাগাদকৃত অটোমেটিক চালকলের </td>
                                    <td colspan="2" style="text-align:center;"> মোট </td>
                                </tr>

                                <tr bgcolor="silver" style="height:2px;">
                                    <td align="center">
                                        @if($level==0)
                                            বিভাগ
                                        @elseif($level==1)
                                            জেলা
                                        @elseif($level==2)
                                            উপজেলা
                                        @elseif($level==3)
                                            চালকলের নাম
                                        @endif
                                    </td>

                                    <td align="center"> সংখ্যা</td>
                                    <td align="center">পাক্ষিক ক্ষমতা</td>

                                    <td align="center">সংখ্যা</td>
                                    <td align="center">পাক্ষিক ক্ষমতা</td>

                                    <td align="center">সংখ্যা</td>
                                    <td align="center">পাক্ষিক ক্ষমতা</td>

                                    <td align="center">চালকলের সংখ্যা </td>
                                    <td align="center">পাক্ষিক ক্ষমতা</td>

                                    <td align="center">চালকলের সংখ্যা </td>
                                    <td align="center">পাক্ষিক ক্ষমতা</td>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($millers_info as $key => $miller_info)
                                <tr>
                                    <td class="px-1">
                                        @if($level==0)
                                            <a href="{{ route('summarywithdivision', [$miller_info->id, $chal_type_id]) }}">
                                        @elseif($level==1)
                                            <a href="{{ route('summarywithdistrict', [$miller_info->id, $chal_type_id]) }}">
                                        @elseif($level==2)
                                            <a href="{{ route('summarywithupazilla', [$miller_info->id, $chal_type_id,]) }}">
                                        @elseif($level==3)
                                            <a  target="_blank" href="{{ route('millers.edit',$miller_info->id) }}">
                                        @endif
                                        <span>{{$miller_info->name}}</span>
                                        @if($level==0 || $level==1 || $level==2 || $level==3)
                                            </a>
                                        @endif
                                    </td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalcount2)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalpower2)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalcount1)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalpower1)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalcount4)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalpower4)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalcount3)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalpower3)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalcount5)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalpower5)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalcount)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $miller_info->totalpower)}}</span></td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr bgcolor="lightgray">

                                    <td class="px-1">মোট চালকলের সংখ্যা  ও মোট পাক্ষিক ক্ষমতা</td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalcount2)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalpower2)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalcount1)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalpower1)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalcount4)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalpower4)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalcount3)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalpower3)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalcount5)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalpower5)}}</span></td>

                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalcount)}}</span></td>
                                    <td align="right" class="px-1"><span>{{App\BanglaConverter::en2bn(0, $millers_info_total->totalpower)}}</span></td>
                                </tr>
                        </tfoot>
                    </table>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    table, th, td {
        border: 1px solid;
        border-collapse: collapse;
    }
 </style>
@endsection


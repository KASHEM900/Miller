<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" id="miller_list">
                <h2 class="card-header text-2xl" style="text-align: center;">
                    তথ্য অনুযায়ী চালকলের সমূহের তালিকা
                </h2>
                <div class="p-3 flex justify-between">

                    <div>
                        <table cellpadding="2px" class="center" style="margin-left:auto; margin-right:auto;">
                            <tbody>
                                <tr>

                                    <td>অনুসন্ধান</td>
                                    <td>:</td>
                                    <td>
                                    @if($searchtext == null)
                                        সকল,
                                        @else
                                        {{ $searchtext }},
                                        @endif

                                    </td>

                                    <td>বিভাগ</td>
                                    <td>:</td>
                                    <td>
                                    @if($division_name == null)
                                        সকল,
                                        @else
                                        {{ $division_name }},
                                        @endif

                                    </td>

                                    <td> জেলা</td>
                                    <td>:</td>
                                    <td>
                                    @if($district_name == null)
                                        সকল,
                                        @else
                                        {{ $district_name }},
                                        @endif

                                    </td>

                                    <td> চালকলের তথ্য</td>
                                    <td>:</td>
                                    <td>@if($cmp_status == "0")
                                        অসম্পুর্ণ
                                        @elseif($cmp_status == "1")
                                        সম্পুর্ণ
                                        @else
                                        সকল
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @include('reports.common-printmiller')

            </div>
        </div>
    </div>
</div>

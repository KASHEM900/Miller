<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" style="padding: 50px; 50px; 50px; 50px">
            <div class="card" id="miller_list">
                <h2 class="card-header text-2xl" style="text-align: center;">
                    চালকলের ধরণ অনুযায়ী চালকলের সমূহের তালিকা
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

                                    <td> চালের ধরণ</td>
                                    <td>:</td>
                                    <td>
                                    @if($chal_type_name == null)
                                        সকল,
                                        @else
                                        {{ $chal_type_name }},
                                        @endif
                                        
                                    </td>

                                    <td> চালকলের ধরণ</td>
                                    <td>:</td>
                                    <td width="20%">
                                    @if($mill_type_name == null)
                                        সকল,
                                        @else
                                        {{ $mill_type_name }}
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

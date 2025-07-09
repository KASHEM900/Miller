@foreach($millers as $key => $miller)
    <div style="margin-bottom: 40px; page-break-after: always;">
        <h2 align="center">@if($miller->milltype){{$miller->milltype->mill_type_name}}@endif
            চালকলের মিলিং ক্ষমতা নির্ণয় ফরম</h2>

        @include('miller.chalkol_preview')
        @include('miller.license_preview')

        @if($miller->mill_type_id==2)

            @if($miller->autometic_miller)
                @include('miller.autometic_mechin_preview')

                @include('miller.auto_para_preview')
            @endif

            @include('miller.auto_p_pwer')

        @else

            @if($miller->mill_type_id!=1 && $miller->mill_type_id!=5)

                @include('miller.boiller_preview')

                @include('miller.chimni_preview')

            @endif

            @if($miller->mill_type_id==5)
                @include('miller.milling_unit_machineries_preview')

                @include('miller.boiler_machineries_preview')
            @endif

            @include('miller.godown_preview')

            @if($miller->mill_type_id!=5)
                @include('miller.chatal_preview')

                @if($miller->mill_type_id!=1)
                    @include('miller.steping_preview')
                @endif

                @include('miller.motor_preview')

            @else
                @if($miller->chal_type_id!=1)
                    @include('miller.boiler_preview')
                @endif

                @include('miller.dryer_preview')

                @include('miller.milling_unit_preview')

            @endif

            @if($miller->mill_type_id == 4)
                @include('miller.rsolar_preview')
            @endif

            @include('miller.p_power_preview')

        @endif
        
        <br/>
        @include('miller.authorization_preview')
        <br/>
        
    </div>
@endforeach

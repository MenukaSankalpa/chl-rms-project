@if(!Auth::guest())
    @php
        $error_count = 0;
    @endphp
    <div class="d-inline-block">
        <ul>
            @if($prev_container!=null)
                @if ($prev_container->plug_off_date == '' && $prev_container->plug_off_time == '')
                    @php
                        $error_count ++;
                    @endphp

                    <li>
                        <small style="color: red">Error: Previous plug Off not found on ({{$prev_container->plug_on_date}}) !
                        </small>
                    </li>

                @endif

                @if ($prev_container->plug_off_date > $container->plug_on_date)
                    @php
                        $error_count ++;
                    @endphp

                    <li>
                        <small style="color: red">Error: Plug on Date must be later date than previous plug
                            off({{$prev_container->plug_off_date}}) !
                        </small>
                    </li>
                @endif

            @endif
            @if($container->container_number=='')
                @php
                    $error_count ++;
                @endphp

                <li>
                    <small style="color: red">Error: Container number required !</small>
                </li>
            @endif
            @if(strlen($container->container_number)!=11)
                @php
                    $error_count ++;
                @endphp

                <li>
                    <small style="color: red">Error: Container number must be of 11 characters !</small>
                </li>
            @endif
            @if($container->container_number=='')
                @php
                    $error_count ++;
                @endphp

                <li>
                    <small style="color: red">Error: Container number required !</small>
                </li>
            @endif
            @if($container->vessel_id!=''&&!isset($container->vessel))
                @php
                    $error_count ++;
                @endphp

                <li>
                    <small style="color: red">Error: Vessel is not In Database !</small>
                </li>
            @endif
            @if($container->voyage_id!=''&&!isset($container->voyage))
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Voyage is not In Database !</small>
                </li>
            @endif
            @if($container->ex_on_career_vessel!=''&&!isset($container->ex_vessel))
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Ex On Carrier Vessel is not In Database !</small>
                </li>
            @endif
            @if($container->ex_on_career_voyage!=''&&!isset($container->ex_voyage))
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Ex On Carrier Voyage is not In Database !</small>
                </li>
            @endif
            @if($container->yard_location=='')
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Yard Location Required!</small>
                </li>
            @endif
            @if($container->ts_local=='')
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Un Known Container Category!</small>
                </li>
            @endif
            @if($container->set_temp===null)
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Set Temperature Required!</small>
                </li>
            @endif
            @if($container->plug_on_temp===null)
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Plug On Temperature Required!</small>
                </li>
            @endif
            @if($container->plug_on_date=='')
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Plug On Date Required!</small>
                </li>
            @endif
            @if($container->plug_on_time=='')
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Plug On Time Required!</small>
                </li>
            @endif
            @if($container->box_owner!=''&&!isset($container->box_owner))
                @php
                    $error_count ++;
                @endphp
                <li>
                    <small style="color: red">Error: Box Owner is not In Database !</small>
                </li>
            @endif
            {{--@if($container->box_owner=='')--}}
                {{--@php--}}
                    {{--$error_count ++;--}}
                {{--@endphp--}}
                {{--<li>--}}
                    {{--<small style="color: red">Error: Box Owner Required !</small>--}}
                {{--</li>--}}
            {{--@endif--}}
            @if($error_count == 0)
                <li>
                    <small style="color: green">OK.</small>
                </li>
            @endif

        </ul>
    </div>
@endif

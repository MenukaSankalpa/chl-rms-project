@if(!Auth::guest())

    @if($state->code == 0 || $state->code == 7 )
        <input value="{{$state->monitoring!=null?$state->monitoring->schedule_24:''}}" style="width: 5em" type="text"  name="schedule_24"
               class=" border-0"
               step="0.001" readonly disabled>

    @elseif($state->code == 11)
        <input value="{{$state->monitoring!=null?$state->monitoring->schedule_24:''}}" style="width: 5em" type="text"  name="schedule_24"
               class=" border-0"
               step="0.001"
            {{$state->prev_date_at > $container->plug_on_date.' 24:00:00' ? "disabled readonly":''}}>
    @elseif($state->code == 13)
        <input value="{{$state->monitoring!=null?$state->monitoring->schedule_24:''}}" style="width: 5em" type="text"
               name="schedule_24"
               class=" border-0"
               step="0.001"
            {{$state->prev_date_at > $state->monitoring->date.' 24:00:00' ? "disabled readonly":''}}>
    @elseif($state->code == 14)
        <input value="" style="width: 5em" type="text"
               name="schedule_24"
               class=" border-0"
               step="0.001">
    @else
        <input value="{{$state->monitoring!=null?$state->monitoring->schedule_24:''}}" style="width: 5em" type="text"  name="schedule_24"
               class=" border-0"
               step="0.001"
        >

    @endif
@endif

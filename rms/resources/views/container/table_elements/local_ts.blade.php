@if(!Auth::guest())

    <input name="ts_local" class="border-0" maxlength="5" size="5"
           tabindex="4" value="{{$container->ts_local}}">

@endif

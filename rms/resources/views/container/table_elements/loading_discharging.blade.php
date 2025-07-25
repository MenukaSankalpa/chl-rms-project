@if(!Auth::guest())
    <input name="loading_discharging" class="border-0" maxlength="1" size="2"
           tabindex="4" value="{{$container->loading_discharging}}">
@endif

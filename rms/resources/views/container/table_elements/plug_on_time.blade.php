@if(!Auth::guest())
    <input value="{{$container->plug_on_time}}" type="text" maxlength="8" size="9" name="plug_on_time"
           pattern="([01]?[0-9]|2[0-3])(:[0-5][0-9]){1,2}" class="border-0"/>
@endif

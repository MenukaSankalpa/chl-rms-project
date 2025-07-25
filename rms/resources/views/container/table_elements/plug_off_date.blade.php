@if(!Auth::guest())
        <input value="{{$container->plug_off_date}}" type="text" maxlength="10" size="11" name="plug_off_date" class="border-0"/>
@endif

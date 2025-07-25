@if(!Auth::guest())
    <input value="{{$container->plug_off_temp??''}}" style="width: 5em" type="number"  name="plug_off_temp"
           class=" border-0"
           placeholder="Plug Off Temp"
           step="0.001" >
@endif

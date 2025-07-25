@if(!Auth::guest())
    <input value="{{$container->plug_on_temp}}" style="width: 5em" type="number"  name="plug_on_temp"
           class=" border-0"
           placeholder="Plug On Temp"
           step="0.001" >
@endif

@if(!Auth::guest())
    <input value="{{$container->rdt_temp}}" style="width: 5em" type="number"  name="rdt_temp"
           class=" border-0"
           placeholder="RDT Temp"
           step="0.001" >
@endif

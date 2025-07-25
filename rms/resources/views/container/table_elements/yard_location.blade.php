@if(!Auth::guest())
<input type="text" class=" border-0"  size="6" name="yard_location" value="{{$container->yard_location}}">
@endif

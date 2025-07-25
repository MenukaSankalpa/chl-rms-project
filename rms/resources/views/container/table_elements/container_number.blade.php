@if(!Auth::guest())
<input type="text" maxlength="11" size="12" class=" border-0" name="container_number" value="{{$container->container_number}}">
{{--Quick save method requre following--}}
@method('put')
<input type="hidden" name="row_edit" value="true">
@endif

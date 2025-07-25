@if(!Auth::guest())
    @if($container->monitoring_count<1)
        <input style="width: 5em" type="checkbox"
               {{ $container->plugging_category=="plug_on_and_off_only"?'checked':'' }}
               value="plug_on_and_off_only" name="plugging_category"
               class=" border-0"
               data-container="{{$container->id}}"
        >
        @else
        <span class="small" style="color: red;"><strong>Has Monitoring data</strong></span>
    @endif
@endif

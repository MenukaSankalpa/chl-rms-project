@if(!Auth::guest())
    @if($container->plug_off_date==''){{--after plug off data change is not allowed--}}
    @if($container->lock==0)
        <div class="d-inline-block">
            <button type="submit" id="quick_save" data-id="{{$container->id}}"
                    class="btn btn-success btn-sm btn-circle"><i
                    class="fa fa-save "></i>
            </button>
        </div>
    @else
        <i class="fa fa-lock"></i>
    @endif
    @endif
@endif

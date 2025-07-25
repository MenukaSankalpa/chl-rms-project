@if(!Auth::guest())
    @if($container->plug_off_date==''){{--after plug off data change is not allowed--}}
    @if($container->lock==0)
        <div style="width: 70px;" class="d-inline-block">
        <form action="{{url('/container/'.$container->id)}}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <a href="{{url('/container/'.$container->id.'/edit')}}"
               class="btn btn-primary btn-sm btn-circle"><i
                        class="fa fa-edit"></i></a>

            <button type="submit" id="submit"
                    class="btn btn-danger btn-sm btn-circle"><i
                        class="fa fa-trash "></i></button>
        </form>
    </div>
    @else
        <i class="fa fa-lock"></i>
    @endif
    @endif
@endif

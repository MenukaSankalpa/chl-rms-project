@if( ! Auth::guest())
    {{--{{var_dump($state->next_monitoring)}}--}}
    @if(
     $state->code!=12 //cannot delete empty monitoring
     &&$state->code!=11 //cannot delete empty monitoring
     &&$state->code!=14 //cannot delete empty monitoring
     &&$state->code!=0 //cannot delete empty monitoring
     &&$state->code!=7 //cannot delete empty monitoring
    )
        @if($container->lock==0)
            <div style="width: 70px;" class="d-inline-block">
                <form name="delete_form" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="monitoring_id" value="{{$state->monitoring->id}}">
                    <button type="submit" id="delete" data-id="{{$state->monitoring->id}}"
                            class="btn btn-danger btn-sm btn-circle"><i
                            class="fa fa-trash "></i></button>
                </form>
            </div>

        @else
            <i class="fa fa-lock"></i>
        @endif
    @endif
@endif

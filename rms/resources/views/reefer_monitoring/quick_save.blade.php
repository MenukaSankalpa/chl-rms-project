@if( ! Auth::guest())
    @if($container->lock==0)
        {!! $state->button !!}
    @else
        <i class="fa fa-lock"></i>
    @endif
@endif

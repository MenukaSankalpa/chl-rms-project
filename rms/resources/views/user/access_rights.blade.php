@if(!Auth::guest())
    <form action="{{url('/access_right/'.$user->id.'/edit')}}" method="get">
        @csrf
        <button class="btn btn-success btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-lock"></i>
                                        </span>
            <span class="text">Edit Access Rights</span>
        </button>
    </form>
@endif

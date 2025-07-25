@if(!Auth::guest())
    <a href="{{url('/access_right/'.$user->id.'/edit')}}"
       class="btn btn-primary btn-sm btn-circle"><i
                class="fa fa-edit"></i></a>
@endif

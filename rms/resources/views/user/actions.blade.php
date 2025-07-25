@if(!Auth::guest())
    <a href="{{url('/user/'.$user->id.'/edit')}}"
       class="btn btn-primary btn-sm btn-circle"><i
                class="fa fa-edit"></i></a>
    <form action="{{url('/user/'.$user->id)}}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" id="submit"
                class="btn btn-danger btn-sm btn-circle"><i
                    class="fa fa-trash "></i></button>
    </form>
@endif

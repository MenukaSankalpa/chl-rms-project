@if(!Auth::guest())
    <div style="width: 70px;" class="d-inline-block">
        <form action="{{url('/reefer_monitoring/'.$container->id)}}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <a href="{{url('/reefer_monitoring/'.$container->id.'/edit')}}"
               class="btn btn-primary btn-sm btn-circle"><i
                        class="fa fa-edit"></i></a>

            <button type="submit" id="submit"
                    class="btn btn-danger btn-sm btn-circle"><i
                        class="fa fa-trash "></i></button>
        </form>
    </div>

@endif

@extends('layout.app')
@section('content')
    <a href="{{url('/permission')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit permission</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/permission/'.$permission->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                @method('put')

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       value="{{$permission->name}}"
                                       required>

                                <label>Guard Name</label>
                                <select class="form-control" name="guard_name" id="guard_name" required>
                                    @foreach($guard_list as $guard=>$v)
                                        <option value="{{$guard}}" {{$permission->guard_name==$guard?'selected':''}}>{{$guard}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <hr>
                            <input class="btn btn-primary btn-sm" type="submit" id="submit" name="submit"
                                   value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

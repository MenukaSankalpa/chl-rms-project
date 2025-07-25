@extends('layout.app')
@section('content')
    <a href="{{url('/role')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">role</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       value="{{$role->name}}"
                                       required readonly>

                                <label>Guard Name</label>
                                <select class="form-control" name="guard_name" id="guard_name" required>
                                    @foreach($guard_list as $guard=>$v)
                                        <option value="{{$guard}}" {{$role->guard_name==$guard?'selected':''}}>{{$guard}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

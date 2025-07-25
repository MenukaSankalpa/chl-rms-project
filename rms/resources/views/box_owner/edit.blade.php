@extends('layout.app')
@section('content')
    <a href="{{url('/box_owner')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Box Owner</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/box_owner/'.$box_owner->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                @method('put')
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                       placeholder="Code"
                                       value="{{$box_owner->code}}"
                                       maxlength="10"
                                       required>

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       value="{{$box_owner->name}}"
                                       maxlength="60"
                                       required>
                                <div class="form-group mt-3">
                                    <input type="radio" class="" name="monitor_or_plug" {{$box_owner->monitor_or_plug == 'monitor' ? "checked":''}} value="monitor">
                                    Monitoring
                                </div>

                                <div class="form-group">
                                    <input type="radio" class="" name="monitor_or_plug" {{$box_owner->monitor_or_plug == 'plug' ? "checked":''}} value="plug">
                                    Plug On & Off Only
                                </div>
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

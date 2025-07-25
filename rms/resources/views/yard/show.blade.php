@extends('layout.app')
@section('content')
    <a href="{{url('/yard')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Yard</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                       placeholder="Code"
                                       value="{{$yard->code}}"
                                       required readonly>

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       value="{{$yard->name}}"
                                       required readonly>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

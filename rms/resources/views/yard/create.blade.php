@extends('layout.app')
@section('content')
    <a href="{{url('/yard')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Create Yard</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/yard')}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                       placeholder="Code"
                                       maxlength="10"
                                       required>

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       maxlength="60"
                                       required>
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

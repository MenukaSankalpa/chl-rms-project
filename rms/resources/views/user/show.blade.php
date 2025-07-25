@extends('layout.app')
@section('content')
    <a href="{{url('/user')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">user</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       value="{{$user->name}}"
                                       required readonly>

                                <label>email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="E-mail"
                                       value="{{$user->email}}"
                                       required readonly>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

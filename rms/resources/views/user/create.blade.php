@extends('layout.app')
@section('content')
    <a href="{{url('/user')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Create user</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/user')}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       required>

                                <label>email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="E-mail"
                                       required>

                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Password"
                                       required>

                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirm" id="password_confirm"
                                       placeholder="Confirm Password"
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

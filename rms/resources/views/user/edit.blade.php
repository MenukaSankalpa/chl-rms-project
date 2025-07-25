@extends('layout.app')
@section('content')
    <a href="{{url('/user')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit user</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="{{url('/user/'.$user->id)}}" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                @csrf
                                                @method('put')
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                       placeholder="name"
                                                       value="{{$user->name}}"
                                                       required>

                                                <label>email</label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                       placeholder="E-mail"
                                                       value="{{$user->email}}"
                                                       required>

                                                <div class="card border-left-success shadow h-100 py-2 mt-5">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">

                                                            <div class="text-lg font-weight-bold text-success text-uppercase mb-3">
                                                                Change Password
                                                            </div>

                                                            <div class="col-md-12">
                                                                <label>Password</label>
                                                                <input type="password" class="form-control"
                                                                       name="password"
                                                                       id="password"
                                                                       placeholder="Password">

                                                                <label>Confirm Password</label>
                                                                <input type="password" class="form-control"
                                                                       name="password_confirm"
                                                                       id="password_confirm"
                                                                       placeholder="Confirm Password">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>
                                    <input class="btn btn-primary btn-sm" type="submit" id="submit" name="submit"
                                           value="Submit">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form action="{{url('/access_right/'.$user->id.'/edit')}}" method="get">
                                {{--@csrf--}}
                                <button class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    <span class="text">Edit Access Rights</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

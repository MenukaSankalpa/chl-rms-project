@extends('layout.app')
@section('content')
    <a href="{{url('/access_right')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Access Rights</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                    <div class="col mr-5">
                    <h1>{{$user->name}}</h1>
                    <p> <strong>Roles:</strong>
                        @foreach($roles as $role)
                            <span class="badge badge-success badge-counter">{{$role}}</span>
                        @endforeach
                    </p>
                    </div>
                    <div class="col ml-5">
                        <form action="{{url('/access_right')}}" method="post" name="role_form">
                            <div class="form-group">
                                @csrf
                                <input type="hidden" name="user" value="{{$user->id}}">
                            <select class="form-control" name="role">
                                @foreach($all_roles as $single_role)
                                <option value="{{$single_role->id}}">{{$single_role->name}}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group">
                            <input class="btn btn-primary btn-sm " type="submit" id="submit" name="submit"
                                   value="Add">
                            <input class="btn btn-danger btn-sm " type="submit" id="delete" name="delete"
                                   value="Delete">
                            </div>

                        </form>
                    </div>
                    </div>
                    <form name="access_right_form" action="{{url('/access_right/'.$user->id)}}" method="POST"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-12">
                                @csrf
                                @method('put')
                                <input type="hidden" name="user" value="{{$user->id}}">
                                @foreach($route_list as $key=>$item)
                                <!-- Basic Card Example -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">{{$key}}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                            @foreach($item as $uri => $route)
                                                <!-- Permission Card -->
                                                    <div class="col-xl-3 col-md-6 mb-4">
                                                        <div class="card border-left-success shadow h-100 py-2">
                                                            <div class="card-body">
                                                                <div class="row no-gutters align-items-center">
                                                                    <div class="col mr-2">
                                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{$route['name']}}</div>
                                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"
                                                                             style="font-size: small">
                                                                            <small>{{$route['uri']}}</small>
                                                                        </div>
                                                                        <div>
                                                                            @foreach($route['roles'] as $role)
                                                                            <span class="badge badge-success badge-counter">{{$role}}</span>
                                                                            @endforeach
                                                                        </div>

                                                                        {{--{{var_dump($route['user_has_permission_to'])}}--}}
                                                                        @if( $route['initialized'] == null )
                                                                            <div>
                                                                                <span name="permission_indicator" class="badge badge-danger badge-counter">Permission is Not Initialized ! </span>
                                                                            </div>
                                                                        @else
                                                                            <div>
                                                                                <span name="permission_indicator" class="badge badge-danger badge-counter" hidden>Permission is Not Initialized ! </span>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <i class="fas {{$route['user_has_permission_to'] === true?'fa-unlock':'fa-lock'}} fa-2x text-gray-300"></i>
                                                                        <input type="checkbox" class="form-control"
                                                                               name="permission[]"
                                                                               value="{{$route['name']}}"
                                                                                {{ $route['user_has_permission_to'] === true?' checked':'' }}
                                                                                {!! ($route['initialized'] == null || sizeof($route['roles'])>1)?' onclick="return false;" ':'' !!}
                                                                        >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('form[name=access_right_form]').delegate('input[type=checkbox]', 'click', function (e) {
                // console.log($(this).is(':checked'));
                // console.log($(this).attr('name'));
                // console.log($(this).val());
                // console.log($(this).closest('i'));
                var icon = $(this).parent().find('i');

                $.ajax({
                    url: '{{url('/access_right/'.$user->id)}}',
                    method: 'post',
                    data:{
                        _method:'put',
                        model_id:'{{$user->id}}',
                        permission: $(this).val(),
                        checked:$(this).is(':checked'),
                    }
                }).done(function (data) {
                    if(data.toString() === 'permitted'){
                        icon.removeClass('fa-lock');
                        icon.addClass('fa-unlock');
                    }
                    if(data.toString() === 'revoked'){
                        icon.removeClass('fa-unlock');
                        icon.addClass('fa-lock');
                    }
                });
            })
        })
    </script>
@endsection

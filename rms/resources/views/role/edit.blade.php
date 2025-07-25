@extends('layout.app')
@section('content')
    <a href="{{url('/role')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit role</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/role/'.$role->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                @method('put')

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       value="{{$role->name}}"
                                       required>

                                <label>Guard Name</label>
                                <select class="form-control" name="guard_name" id="guard_name" required>
                                    @foreach($guard_list as $guard=>$v)
                                        <option value="{{$guard}}" {{$role->guard_name==$guard?'selected':''}}>{{$guard}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <hr>
                            <input class="btn btn-primary btn-sm" type="submit" id="submit" name="submit"
                                   value="Submit">
                        </div>
                    </form>
                    {{--permission list--}}
                    <div class="form-group" name="permission">
                        <div class="col-md-12">
                            @csrf
                            @method('put')
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
                                                                    <i class="fas {{$route['role_has_permission_to'] === true?'fa-unlock':'fa-lock'}} fa-2x text-gray-300"></i>
                                                                    <input type="checkbox" class="form-control"
                                                                           name="permission[]"
                                                                           value="{{$route['name']}}"
                                                                           {{$route['role_has_permission_to']===true ? "checked":''}}
                                                                            {!! $route['initialized'] == null?' onclick="return false;" ':'' !!}
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
                    {{--End permission list--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('div[name=permission]').delegate('input[type=checkbox]', 'click', function (e) {
                console.log($(this).is(':checked'));
                console.log($(this).attr('name'));
                console.log($(this).val());
                console.log($(this).closest('i'));

                $.ajax({
                    url: '{{url('/role/permission/'.$role->id)}}',
                    method: 'post',
                    data:{
                        model_id:'{{$role->id}}',
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

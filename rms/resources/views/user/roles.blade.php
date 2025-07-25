@if(!Auth::guest())
    @foreach ($user->getRoleNames() as $role)
    <span class="badge badge-success badge-counter">{{$role}}</span>
    @endforeach
@endif

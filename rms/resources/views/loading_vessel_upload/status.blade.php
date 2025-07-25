@if(!Auth::guest())
    <div class="d-inline-block">
        @if(!isset($container->container_number))
            <small style="color: red">Error: Container Not Found !</small>
        @elseif(isset($container->plug_off_date) && $container->plug_off_date!=null)
            <small style="color: red">Error: Container is Already Plugged off!</small>
        @elseif(isset($container->ex_on_career_vessel) && $container->ex_on_career_vessel!=null)
            <small style="color: orange">Warning: Container Already Having a Loading Vessel!</small>
        @elseif(isset($container->ex_on_career_voyage) && $container->ex_on_career_voyage!=null)
            <small style="color: orange">Warning: Container Already Having a Loading Voyage!</small>
        @else
            <small style="color: green"> OK</small>
        @endif
    </div>
@endif

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion {{--toggled--}}" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/home')}}">
        <div class="sidebar-brand-icon rotate-n-0">
            {{--<i class="fas fa-laugh-wink"></i>--}}
            <i class="fa fa-boxes"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{config('app.name')}}<sup>@auth('admin') Su Admin @endauth
                @auth('web') .
                @foreach (auth()->user()->getRoleNames() as $role)
                    <span class="badge badge-success badge-counter small">{{$role}}</span>
                @endforeach
                @endauth</sup>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{url('/home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Files
    </div>

    <!-- Nav Item - Main Masters Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMainMasters"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Main</span>
        </a>
        <div id="collapseMainMasters" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Main:</h6>
                <a class="collapse-item" href="{{url('/vessel/create')}}">Vessel</a>
                <a class="collapse-item" href="{{url('/voyage/create')}}">Voyage</a>
                <a class="collapse-item" href="{{url('/box_owner/create')}}">Box Owner</a>
                <a class="collapse-item" href="{{url('/container/create')}}">Plug on Container</a>
                <a class="collapse-item" href="{{url('/loading_vessel_upload')}}">Loading Vessel</a>
                <a class="collapse-item" href="{{url('/reefer_monitoring')}}">Reefer Monitoring <br>& Plug Off</a>
                <a class="collapse-item" href="{{url('/plug_off')}}"> Plug On/Off Only</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Reports Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
           aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-paperclip"></i>
            <span>Reports</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Report:</h6>
                <a class="collapse-item" href="{{url('/other_report')}}">Billing Details – Others</a>
                <a class="collapse-item" href="{{url('/mersk_report')}}">Billing Details – Maersk</a>
                <a class="collapse-item" href="{{url('/monitoring_report')}}">Monitoring Report</a>
                <a class="collapse-item" href="{{url('/master_report')}}">Master Report</a>
                <a class="collapse-item" href="{{url('/plug_in_list')}}">Plug In List</a>
                <a class="collapse-item" href="{{url('/missed_monitoring_report')}}">Missed Monitoring</a>
                <a class="collapse-item" href="{{url('/lock')}}">Container Lock</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Admin Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdminMasters"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Admin</span>
        </a>
        <div id="collapseAdminMasters" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin:</h6>
                <a class="collapse-item" href="{{url('/port/create')}}">Port</a>
                <a class="collapse-item" href="{{url('/rate/create')}}">Rate</a>
                <a class="collapse-item" href="{{url('/yard/create')}}">Yard</a>
                <a class="collapse-item" href="{{url('/company/create')}}">Company</a>
                <a class="collapse-item" href="{{url('/user/create')}}">User</a>
                <a class="collapse-item" href="{{url('/role/create')}}">Role</a>
                <a class="collapse-item" href="{{url('/permission/create')}}">Permission</a>
                <a class="collapse-item" href="{{url('/access_right')}}">Access Rights</a>
                <a class="collapse-item" href="{{url('/system_setting')}}">System Settings</a>
                <a class="collapse-item" href="{{url('/audit')}}">Audit</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Help Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHelp"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-question-circle"></i>
            <span>Help</span>
        </a>
        <div id="collapseHelp" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Getting Started:</h6>
                <a class="collapse-item" href="{{url('/help/login')}}">Login</a>
                <h6 class="collapse-header">Guide:</h6>
                <a class="collapse-item" href="{{url('/help/user_manual')}}">User Manual</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Backup Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBackup"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-hdd"></i>
            <span>Backup</span>
        </a>
        <div id="collapseBackup" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Backup:</h6>
                <a class="collapse-item" href="{{url('/backup/index')}}">Download Backups</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

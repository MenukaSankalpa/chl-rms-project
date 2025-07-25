@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">permissions <a href="{{url('/permission/create')}}" class="btn btn-primary btn-sm"><i
                    class="fa fa-plus-square"></i> New permission</a></h1>

    <div class="row">
        <div class="col-md-12">
            {{--data table--}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="permissionTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                            <tr>
                                <th>permission name</th>
                                <th>Guard Type</th>
                                <th>Action</th>
                            </tr>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>permission name</th>
                                <th>Guard Type</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#permissionTable').DataTable( {
                processing: true,
                serverSide: true,
                responsive: true,
                "ajax": 'data/permission',
                columns: [
                    { data: 'name'},
                    { data: 'guard_name'},
                    { data: 'action', orderable: false, searchable: false}
                ]
            } ).rowReorder.disable();
        } );
    </script>
@endsection
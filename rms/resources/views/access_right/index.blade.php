@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Access Rights</h1>

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
                                <th>User name</th>
                                <th>Action</th>
                            </tr>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>User name</th>
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
                "ajax": 'data/access_right',
                columns: [
                    { data: 'name'},
                    { data: 'action'},
                ]
            } )
        } );
    </script>
@endsection
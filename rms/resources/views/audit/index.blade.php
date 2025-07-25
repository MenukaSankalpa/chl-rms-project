@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Audits</h1>

    <div class="row">
        <div class="col-md-12">
            {{--data table--}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="auditTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                            <tr>
                                <th>user</th>
                                <th>guard</th>
                                <th>Request url</th>
                                <th>Method</th>
                                <th>IP</th>
                                <th>Log Time</th>
                            </tr>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>user</th>
                                <th>guard</th>
                                <th>Request url</th>
                                <th>Method</th>
                                <th>IP</th>
                                <th>Log Time</th>
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
        $(document).ready(function () {
            $('#auditTable').DataTable({
                processing: true,
                serverSide: true,
                // rowReorder: {
                //     selector: 'td:nth-child(2)'
                // },
                // responsive: true,
                "ajax": 'data/audit',
                "order": [[ 5, "desc" ]],
                columns: [
                    {data: 'user_name'},
                    {data: 'guard'},
                    {data: 'url'},
                    {data: 'method'},
                    {data: 'ip'},
                    {data: 'created_at'},
                ]
            });
        });
    </script>
@endsection
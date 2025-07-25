@extends('layout.app')
@section('content')
    <a href="{{url('/company')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Create Company</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/company')}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                @csrf
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                       placeholder="Code"
                                       maxlength="10"
                                       required>

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       maxlength="60"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label>Addresses</label>
                                <table class="table table-striped table-sm " name="address_table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <textarea class="form-control-sm"
                                                      placeholder="Address" cols="50" rows="3" name="address"></textarea>
                                        </th>
                                        <th>
                                            <button class="btn btn-success btn-sm" name="add_address"
                                            > Add
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>

                            <div class="col-md-12">
                                <hr>
                                <input class="btn btn-primary btn-sm" type="submit" id="submit" name="submit"
                                       value="Submit">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var addr_tr_template = $(
            '<tr>' +
            '<td>' +
            '<span name="addresses"></span>' +
            '<input type="hidden" name="addresses[]" value="">' +
            '</td>' +
            '<td>' +
            '<button class="btn btn-danger btn-sm" name="delete_row">delete</button></td>' +
            '</tr>'
        );
        $('button[name=add_address]').click(function (e) {
            e.preventDefault();
            var addr = $(this).parent().parent().find('textarea[name=address]');
            if(addr.val()!='') {
                console.log(addr.val());
                var table_body = $(this).parent().parent().parent().parent().find('tbody');
                addr_tr_template.find('span[name=addresses]').html(addr.val());
                addr_tr_template.find('input[name^=addresses]').val(addr.val());
                var tr = addr_tr_template.clone();
                table_body.append(tr);
                addr.val('');
            }
        });
        $('table[name=address_table]').delegate('button[name=delete_row]','click',function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        });
    </script>
@endsection

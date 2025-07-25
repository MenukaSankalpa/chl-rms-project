@extends('layout.app')
@section('content')
    <a href="{{url('/temp_container')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Port</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/temp_container/')}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                @method('put')
{{--                                {{var_dump($temp_container_data)}}--}}
                                <div id="my"></div>
                            </div>
                            <hr>
                            <input class="btn btn-primary btn-sm" type="submit" id="submit" name="submit"
                                   value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $.ajax({
            method:'get',
            url: '{{url('/temp_container/'.$id)}}'
        }).done(function (data) {
            var string = JSON.stringify(data).replace(/\{/g, '[').replace(/}/g, ']');
            console.log(string);
            var d = JSON.parse(string);

            $('#my').jexcel({ data:d, colWidths: [ 100,300,80 ] });

        })
    </script>
@endsection

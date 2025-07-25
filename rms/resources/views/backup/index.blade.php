@extends('layout.app')
@section('content')
    {{--{{url('/home')}}
    {{env('APP_URL')}}--}}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
            @php
                $files = Illuminate\Support\Facades\Storage::disk('backup')->allFiles();
            @endphp
            @foreach($files as $file)
                <div class="col-md-8 mb-2">
                <a href="{{url('/backup/download/'.$file)}}" class="btn btn-primary"><i
                        class="fa fa-database"></i> Backup {{$file}} <i class="fa fa-download"></i></a>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    public function index(){
        if (Gate::authorize('backup.index')) {
            return view('backup.index');
        }
    }

    public function download($name){
        if (Gate::authorize('backup.index')) {
            return Storage::disk('backup')->download($name);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Container;
use App\ReeferMonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MonitoringController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    public function index(Container $container)
    {
        if(Gate::authorize('monitoring.index')) {
            $monitorings = ReeferMonitoring::query()
                ->where('container_id', $container->id)
                ->get();
            return view('monitoring.index', compact('monitorings', 'container'));
        }
    }

}

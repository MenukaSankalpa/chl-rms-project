<?php

namespace App\Http\Controllers;

use App\Container;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:admin,web']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        //$this->authorize('index',auth()->user());
        //var_dump(auth()->user()->hasPermissionTo(8,'web'));
        $monitoring_count = Container::query()
            ->where('plugging_category','monitoring')
            ->whereNull('plug_off_date')->count();
        $plug_only_count = Container::query()
            ->where('plugging_category','plug_on_and_off_only')
            ->whereNull('plug_off_date')->count();
        $plug_off_this_month = Container::query()
            ->whereBetween('plug_off_date',
                [
                    Carbon::now()->startOfMonth()->toDateString(),
                    Carbon::now()->endOfMonth()->toDateString()
                ])->count();

        return view('home',compact('monitoring_count','plug_only_count','plug_off_this_month'));
    }

    public function missing_monitoring(){
        $monitoring_count = Container::query()
            ->where('plugging_category','monitoring')
            ->whereNull('plug_off_date')->count();
        $missing_monitoring = Container::query()
            ->whereNull('plug_off_date')
            ->where('plugging_category','monitoring')
            ->whereRaw(' missing_monitoring(containers.id,containers.plug_on_date,containers.plug_on_time) = ? ',[1])
            ->count();
        echo '{"missing_monitoring_count":'.$missing_monitoring.',"monitoring_count":'.$monitoring_count.',"percentage":'. round(($missing_monitoring/$monitoring_count)*100) .'}';
    }
}

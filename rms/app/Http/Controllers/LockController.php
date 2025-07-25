<?php

namespace App\Http\Controllers;

use App\Container;
use App\Vessel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use DB;

class LockController extends Controller
{
    /**
     * LockController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Gate::authorize('lock.index')) {
            $vessels = Vessel::all();
            return view('lock.index', compact('vessels'));
        }
    }

    /**
     * @param DataTables $datatables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $datatables)
    {
        if (Gate::authorize('lock.index')) { //permission for non model related methods

            parse_str($datatables->getRequest()->extra_search, $ext);

            $request = $ext;

            $search = new \stdClass();
            foreach ($request as $k => $search_option) {
                $search->{$k} = $search_option;
            }

            $container = Container::query()->with(['vessel', 'voyage', 'loading_vessel', 'loading_voyage']);
            if ($search->from != '' && $search->to != '') {
                $plug_off_at = DB::raw("containers.plug_off_date");
                $container->whereBetween($plug_off_at, [$search->from, $search->to]);
            }
            if(isset($search->monitoring)&&!isset($search->plug_only)){
                $container->where('plugging_category','monitoring');
            }elseif(!isset($search->monitoring)&&isset($search->plug_only)){
                $container->where('plugging_category','plug_on_and_off_only');
            }elseif(isset($search->monitoring)&&isset($search->plug_only)){

            }
            $container->whereNotNull('plug_off_date');

            return $datatables->eloquent($container)
                ->editColumn('container_number', function ($container) {
                    return "<strong><a target='_blank' href='" . url('/monitoring/' . $container->cont_id) . "'>" . $container->container_number . "</a></strong>";
                })
                ->editColumn('plug_on_date', function ($container) {
                    return "<strong>" . ($container->plug_on_date) . "</strong>";
                })
                ->editColumn('plug_on_time', function ($container) {
                    return "<strong>" . ($container->plug_on_time) . "</strong>";
                })
                ->editColumn('lock', function ($container) {
                    return view('lock.lock', compact('container'));
                })
                ->addColumn('empty', function ($container) {
                })
                ->rawColumns([
                    'container_number',
                    'plug_on_date',
                    'plug_on_time',
                    'lock',
                ])
                ->make(true);
        }
    }

    public function container_lock($id, Request $request)
    {
        $message = ['error'=>[],'warning'=>[],'success'=>[]];
        $container  = Container::find($id);
        if($container->plug_off_date != null) {
            if (isset($request->lock)) {
                $container->lock = 1;
                $container->update();
                $message['success'] = "Successfully Locked Plug off Container $container->container_number";
            } else {
                $container->lock = 0;
                $container->update();
                $message['success'] = "Successfully Unlocked Plug off Container $container->container_number";
            }
        }else{
            $message['error'][] = "Container needs to be plugged off before locking.";
        }
        echo json_encode($message);

    }

    public function bulk_lock(Request $request){

        $message = ['error'=>[],'warning'=>[],'success'=>[]];

        $container = Container::query();
        if ($request->from != '' && $request->to != '') {
            $plug_off_at = DB::raw("containers.plug_off_date");
            $container->whereBetween($plug_off_at, [$request->from, $request->to]);
        }
        if(isset($search->monitoring)&&!isset($search->plug_only)){
            $container->where('plugging_category','monitoring');
        }elseif(!isset($search->monitoring)&&isset($search->plug_only)){
            $container->where('plugging_category','plug_on_and_off_only');
        }elseif(isset($search->monitoring)&&isset($search->plug_only)){

        }
        $container->whereNotNull('plug_off_date');
        $count = 0;
        if($request->lock_option=='lock'){
            foreach ($container->get() as $the_container){
                $the_container->lock = 1;
                $the_container->update();
                $count++;
            }
            $message['success'] = "Successfully Locked $count Plug off Containers from $request->from to $request->to";
        }elseif ($request->lock_option=='unlock'){
            foreach ($container->get() as $the_container){
                $the_container->lock = 0;
                $the_container->update();
                $count++;
            }
            $message['success'] = "Successfully Unlocked $count Plug off Containers from $request->from to $request->to";

        }

        echo json_encode($message);

    }
}

<?php

namespace App\Http\Controllers;

use App\Container;
use App\Vessel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PlugInListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    public function index()
    {
        if(Gate::authorize('plug_in_list.index')) {
            $vessels = Vessel::all();
            return view('plug_in_list.index', compact('vessels'));
        }
    }

    public function data(DataTables $datatables)
    {
        if (Gate::authorize('plug_in_list.index')) {

            parse_str($datatables->getRequest()->extra_search, $ext);

            $request = $ext;
            //var_dump($ext);
            /*        $reefer_monitoring = ReeferMonitoring::query()->with(['container'=>function($q){
                        $q->with(['vessel','voyage','loading_vessel','loading_voyage','box_owner']);
                    }]);*/
            $search = new \stdClass();
            foreach ($request as $k => $search_option) {
                $search->{$k} = $search_option;
            }
           $rm =  DB::select("SELECT id,container_number,plug_on_date,plug_on_time FROM (
select *
from `containers`
         inner join (SELECT 
                            date,
                            container_id,
                            schedule_4  as                schedule,
                            concat(date, ' ', '04:00:00') date_time,
                            'schedule4' as                description
                     from reefer_monitorings
                     UNION all
                     SELECT 
                            date,
                            container_id,
                            schedule_8  as                schedule,
                            concat(date, ' ', '08:00:00') date_time,
                            'schedule8' as                description
                     from reefer_monitorings
                     union all
                     SELECT 
                            date,
                            container_id,
                            schedule_12  as               schedule,
                            concat(date, ' ', '12:00:00') date_time,
                            'schedule12' as               description
                     from reefer_monitorings
                     union all
                     SELECT 
                            date,
                            container_id,
                            schedule_16  as               schedule,
                            concat(date, ' ', '16:00:00') date_time,
                            'schedule16' as               description
                     from reefer_monitorings
                     union all
                     SELECT 
                            date,
                            container_id,
                            schedule_20  as               schedule,
                            concat(date, ' ', '20:00:00') date_time,
                            'schedule20' as               description
                     from reefer_monitorings
                     union all
                     SELECT 
                            date,
                            container_id,
                            schedule_24  as               schedule,
                            concat(date, ' ', '23:59:59') date_time,
                            'schedule24' as               description
                     from reefer_monitorings) AS reefer_monitorings
                    on `containers`.`id` = `reefer_monitorings`.`container_id`
where `plugging_category` = ?
  AND schedule is not null
  and `reefer_monitorings`.`date_time` between ? and ?) as containers group by containers.id
",['monitoring',$search->from . ' ' . $search->from_time, $search->to . ' ' . $search->to_time]);

//            $container = Container::query()->join($rm ,function ($join){
//                $join->on('containers.id', '=', 'reefer_monitorings.container_id');
//            })
//            ->where('plugging_category','monitoring');
//            //vessel voyage search
/////
//            if ($search->from != '' && $search->to != '') {
//                $container->whereBetween('reefer_monitorings.date_time', [$search->from . ' ' . $search->from_time, $search->to . ' ' . $search->to_time]);
//            }


            return $datatables->of($rm)
                ->editColumn('container_number', function ($container) {
                    return "<strong><a target='_blank' href='" . url('/monitoring/' . $container->id) . "'>" . $container->container_number . "</a></strong>";
                })
                ->editColumn('plug_on_date', function ($container) {
                    return "<strong>" . ($container->plug_on_date) . "</strong>";
                })
                ->editColumn('plug_on_time', function ($container) {
                    return "<strong>" . ($container->plug_on_time) . "</strong>";
                })
                ->addColumn('empty', function ($container) {
                })
                ->rawColumns([
                    'container_number',
                    'plug_on_date',
                    'plug_on_time',
                ])
                ->make(true);
        }
    }
}

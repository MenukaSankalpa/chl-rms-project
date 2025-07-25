<?php

namespace App\Http\Controllers;

use App\Container;
use App\Vessel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MissedMonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    public function index()
    {
        if (Gate::authorize('missed_monitoring.index')) {
            $vessels = Vessel::all();
            return view('missed_monitoring_report.index', compact('vessels'));
        }
    }

    public function data(DataTables $datatables)
    {
        set_time_limit(900);

        if (Gate::authorize('missed_monitoring.index')) {

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
            $fill_col = DB::raw("(CASE
        WHEN reefer_monitorings.container_id IS NULL OR NOT EXISTS (
            SELECT 1 
            FROM reefer_monitorings t3
            WHERE t3.container_id = reefer_monitorings.container_id
            AND t3.id < reefer_monitorings.id
        ) THEN 'fill' ELSE '-'
    END) fill");
            $cont_sub = DB::table('containers')->whereNotNull('plug_off_date')
                ->whereRaw(' missing_monitoring(id, plug_on_date, plug_on_time) = ? ', [1])
                ->where('plugging_category', 'monitoring');
            if ($search->date_from != '' && $search->date_to != '') {
                $cont_sub->whereBetween('plug_on_date', [$search->date_from, $search->date_to]);
            }else{
                $cont_sub->whereNull('id');//stops initial loading
            }
            $container = DB::table(DB::raw("({$cont_sub->toSql()}) AS containers"))
                ->mergeBindings($cont_sub)
                ->select([
                    'containers.container_number',
                    'containers.set_temp',
                    'containers.temperature_unit',
                    'containers.plug_on_temp',
                    'containers.plug_off_temp',
                    'containers.plug_on_date',
                    'containers.plug_off_date',
                    'containers.plug_on_time',
                    'containers.plug_off_time',
                    'reefer_monitorings.date',
                    'reefer_monitorings.schedule_4',
                    'reefer_monitorings.schedule_8',
                    'reefer_monitorings.schedule_12',
                    'reefer_monitorings.schedule_16',
                    'reefer_monitorings.schedule_20',
                    'reefer_monitorings.schedule_24',
                    DB::raw('containers.id cont_id'),
                    $fill_col
                ]);
            $container->leftJoin('reefer_monitorings', 'containers.id', '=', 'reefer_monitorings.container_id');
            //vessel voyage search

            $container
                ->orderBy('containers.container_number')
                ->orderBy('reefer_monitorings.date');

            return $datatables->of($container)/*->eloquent($container)*/
                ->setRowClass(function ($container) {
                    return $container->fill == "fill" ? "border-top" : "";
                })
                ->editColumn('container_number', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong><a target='_blank' href='" . url('/monitoring/' . $container->cont_id) . "'>" . $container->container_number . "</a></strong>";
                })
                ->editColumn('set_temp', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong>" . ($container->set_temp !== null ? $container->set_temp . '&deg;' . $container->temperature_unit : '') . "</strong>";
                })
                ->editColumn('plug_on_temp', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong>" . ($container->plug_on_temp !== null ? $container->plug_on_temp . '&deg;' . $container->temperature_unit : '') . "</strong>";
                })
                ->editColumn('plug_off_temp', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong>" . ($container->plug_off_temp !== null ? $container->plug_off_temp . '&deg;' . $container->temperature_unit : '') . "</strong>";
                })
                ->editColumn('plug_on_date', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong>" . ($container->plug_on_date) . "</strong>";
                })
                ->editColumn('plug_off_date', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong>" . ($container->plug_off_date) . "</strong>";
                })
                ->editColumn('plug_on_time', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong>" . ($container->plug_on_time) . "</strong>";
                })
                ->editColumn('plug_off_time', function ($container) {
                    if ($container->fill == 'fill')
                        return "<strong>" . ($container->plug_off_time) . "</strong>";
                })
                ->editColumn('date', function ($container) {
                    return "<strong>" . ($container->date) . "</strong>";
                })
                ->editColumn('schedule_4', function ($container) {
                    return $container->schedule_4 !== null ? $container->schedule_4 . '&deg;' . $container->temperature_unit : '';
                })
                ->editColumn('schedule_8', function ($container) {
                    return $container->schedule_8 !== null ? $container->schedule_8 . '&deg;' . $container->temperature_unit : '';
                })
                ->editColumn('schedule_12', function ($container) {
                    return $container->schedule_12 !== null ? $container->schedule_12 . '&deg;' . $container->temperature_unit : '';
                })
                ->editColumn('schedule_16', function ($container) {
                    return $container->schedule_16 !== null ? $container->schedule_16 . '&deg;' . $container->temperature_unit : '';
                })
                ->editColumn('schedule_20', function ($container) {
                    return $container->schedule_20 !== null ? $container->schedule_20 . '&deg;' . $container->temperature_unit : '';
                })
                ->editColumn('schedule_24', function ($container) {
                    return $container->schedule_24 !== null ? $container->schedule_24 . '&deg;' . $container->temperature_unit : '';
                })
                ->addColumn('empty', function ($container) {
                })
                ->rawColumns([
                    'container_number',
                    'set_temp',
                    'date',
                    'plug_on_temp',
                    'plug_off_temp',
                    'plug_on_date',
                    'plug_off_date',
                    'plug_on_time',
                    'plug_off_time',
                    'schedule_4',
                    'schedule_8',
                    'schedule_12',
                    'schedule_16',
                    'schedule_20',
                    'schedule_24'
                ])
                ->make(true);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Container;
use App\TempContainer;
use App\Vessel;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MasterReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    public function index()
    {
        if(Gate::authorize('master_report.index')) {
            $vessels = Vessel::all();
            return view('master_report.index', compact('vessels'));
        }
    }

    public function data(DataTables $datatables)
    {
        if (Gate::authorize('master_report.index')) {

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
            $container = Container::query()
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
            if ($search->vessel_id != '' && $search->voyage_id != '') {
                if ($search->loading_discharging == 'B') {
                    $container->where(function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {

                            $q->where('vessel_id', $search->vessel_id);
                            $q->where('voyage_id', $search->voyage_id);
                        })
                            ->orWhere(function ($q) use ($search) {
                                $q->where('ex_on_career_vessel', $search->vessel_id);
                                $q->where('ex_on_career_voyage', $search->voyage_id);

                            });
                    });
                } elseif ($search->loading_discharging == 'L') {
                    $container->where(function ($q) use ($search) {
                        $q->where('ex_on_career_vessel', $search->vessel_id);
                        $q->where('ex_on_career_voyage', $search->voyage_id);
                    });
                } elseif ($search->loading_discharging == 'D') {
                    $container->where(function ($q) use ($search) {
                        $q->where('vessel_id', $search->vessel_id);
                        $q->where('voyage_id', $search->voyage_id);
                    });
                }
            } else {

                if ($search->loading_discharging == 'B') {

                    if (
                        $search->date_from == ''
                    ) {
                        $container->whereNull('containers.id');//to stop from returning all data when non is selected
                    }
                } else if ($search->loading_discharging == 'L') {
                    $container->whereNotNull('ex_on_career_vessel');
                    $container->whereNotNull('ex_on_career_voyage');
                } else if ($search->loading_discharging == 'D') {
                    $container->whereNotNull('vessel_id');
                    $container->whereNotNull('voyage_id');
                }
            }
///
            if ($search->date_from != '') {
                $container->where('plug_on_date', $search->date_from);
            }
$container->orderBy('containers.container_number');
$container->orderBy('reefer_monitorings.date');

            return $datatables->eloquent($container)
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

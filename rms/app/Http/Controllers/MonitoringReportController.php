<?php

namespace App\Http\Controllers;

use App\Container;
use App\Vessel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MonitoringReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    public function index()
    {
        if(Gate::authorize('monitoring_report.index')) {
            $vessels = Vessel::all();
            return view('monitoring_report.index', compact('vessels'));
        }
    }

    public function data(DataTables $datatables)
    {
        if (Gate::authorize('monitoring_report.index')) {

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

            $container = Container::query()->with(['vessel', 'voyage', 'loading_vessel', 'loading_voyage']);

            if ($search->file_id != '') {
                $temp_containers = TempContainer::where('file_id', $search->file_id)->select('number');
                $cnt_array = [];
                foreach ($temp_containers->get() as $cont) {
                    $cnt_array[] = $cont->number;
                }
                $container->whereIn('container_number', $cnt_array);
            }


            //box owner validation
//        $container->whereHas('owner', function ($p) {
//            $p->where('monitor_or_plug', 'monitor');
//        });

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
                        $search->container_number == ''
                        && $search->yard_location == ''
                        && $search->date_from == ''
                        && $search->date_to == ''
                        && !isset($search->plug_off)
                        && !isset($search->plug_on)
                    ) {
                        $container->whereNull('id');//to stop from returning all data when non is selected
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
            if ($search->container_number != '') {
                $container->where('container_number', $search->container_number);
            }
            if ($search->yard_location != '') {
                $container->where('yard_location', $search->yard_location);
            }
            if ($search->date_from != '' && $search->date_to != '') {
                $container->whereBetween('plug_on_date', [$search->date_from, $search->date_to]);
            }
//        if ($search->box_owner != '') {
//            $container->where('box_owner', $search->box_owner);
//        }
            //plug off date search
            if (isset($search->plug_off) && !isset($search->plug_on)) {
                $container->whereNotNull('plug_off_date');
            } elseif (!isset($search->plug_off) && isset($search->plug_on)) {
                $container->whereNull('plug_off_date');
            }

            //todo-search by file
            if ($ext['file_id'] != '') {

            }


            return $datatables->eloquent($container)
                ->editColumn('container_number', function ($container) {
                    return "<a target='_blank' href='" . url('/monitoring/' . $container->id) . "'>" . $container->container_number . "</a>";
                })
                ->editColumn('set_temp', function ($container) {
                    return $container->set_temp !== null ? $container->set_temp . '&deg;' . $container->temperature_unit : '';
                })
                ->editColumn('plug_on_temp', function ($container) {
                    return $container->plug_on_temp !== null ? $container->plug_on_temp . '&deg;' . $container->temperature_unit : '';
                })
                ->editColumn('plug_off_temp', function ($container) {
                    return $container->plug_off_temp !== null ? $container->plug_off_temp . '&deg;' . $container->temperature_unit : '';
                })
                ->addColumn('no_of_days', function ($container) {
                    if ($container->plug_off_date != '') {
                        $monitoring_days_count = 0;
                        $validation = new MonitoringValidationController($container->id, $container);
                        $period = CarbonPeriod::create($container->plug_on_date, $container->plug_off_date != '' ? $container->plug_off_date : '');
                        // Iterate over the period
                        foreach ($period as $date) {
                            //echo $date->format('Y-m-d');
                            $monitoring_days_count++;
                        }

                        return $monitoring_days_count;
                    }
                })
                ->addColumn('empty', function ($container) {
                })
                ->addColumn('vessel_name', function ($container) {
                    return $container->vessel != null ? $container->vessel->name : '';
                })
                ->addColumn('voyage_code', function ($container) {
                    return $container->voyage != null ? $container->voyage->code : '';
                })
                ->addColumn('loading_vessel_name', function ($container) {
                    return $container->loading_vessel != null ? $container->loading_vessel->name : '';
                })
                ->addColumn('loading_voyage_code', function ($container) {
                    return $container->loading_voyage != null ? $container->loading_voyage->code : '';
                })
                ->rawColumns(['container_number', 'set_temp', 'plug_on_temp', 'plug_off_temp'])
                ->make(true);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\BoxOwner;
use App\Container;
use App\ReeferMonitoring;
use App\TempContainer;
use App\Upload;
use App\Vessel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReeferMonitoringController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', ReeferMonitoring::class);
        $vessels = Vessel::all();
        return view('reefer_monitoring.index', compact('vessels'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', ReeferMonitoring::class);
        $vessels = Vessel::all();
        $box_owners = BoxOwner::all()/*where('monitor_or_plug','monitor')->get()*/
        ;
        return view('reefer_monitoring.create', compact('vessels', 'box_owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', ReeferMonitoring::class);
        $reefer_monitoring = new ReeferMonitoring();

        $errors = $request->validate([
            'container_id' => 'required|unique_with:reefer_monitorings,container_id,date',
            'date' => 'required',
        ]);

        $reefer_monitoring->date = $request->date;
        $reefer_monitoring->container_id = $request->container_id;
        $reefer_monitoring->schedule_4 = $request->schedule_4;
        $reefer_monitoring->schedule_8 = $request->schedule_8;
        $reefer_monitoring->schedule_12 = $request->schedule_12;
        $reefer_monitoring->schedule_16 = $request->schedule_16;
        $reefer_monitoring->schedule_20 = $request->schedule_20;
        $reefer_monitoring->schedule_24 = $request->schedule_24;
        $reefer_monitoring->save();

        //return redirect('/reefer_monitoring')->with('success','Created Successfully');
        $container = Container::where('id', $reefer_monitoring->container_id);
        return $container->with(['reefer_monitoring' => function ($q) {
            $q->orderBy('date', 'desc');
        }])->first();

    }

    /**
     * Display the specified resource.
     *
     * @param \App\ReeferMonitoring $reefer_monitoring
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Upload $reefer_monitoring)
    {
        $file = $reefer_monitoring;
        $this->authorize('view', ReeferMonitoring::class);

        $reefer_monitorings = ReeferMonitoring::all();
        $vessels = Vessel::all();
        $box_owners = BoxOwner::all();

        $containers = Container::all();

        $data = json_decode($file->data);

        return view('reefer_monitoring.show', compact('reefer_monitorings', 'vessels', 'box_owners', 'containers', 'file', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ReeferMonitoring $reefer_monitoring
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ReeferMonitoring $reefer_monitoring)
    {

        $this->authorize('update', ReeferMonitoring::class);

        return view('reefer_monitoring.edit', compact('reefer_monitoring'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ReeferMonitoring $reefer_monitoring
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, ReeferMonitoring $reefer_monitoring)
    {
        $this->authorize('update', ReeferMonitoring::class);

        $reefer_monitoring->schedule_4 = $request->schedule_4;
        $reefer_monitoring->schedule_8 = $request->schedule_8;
        $reefer_monitoring->schedule_12 = $request->schedule_12;
        $reefer_monitoring->schedule_16 = $request->schedule_16;
        $reefer_monitoring->schedule_20 = $request->schedule_20;
        $reefer_monitoring->schedule_24 = $request->schedule_24;
        $reefer_monitoring->update();

        //return redirect('/reefer_monitoring')->with('success','Created Successfully');
        $container = Container::where('id', $reefer_monitoring->container_id);
        return $container->with(['reefer_monitoring' => function ($q) {
            $q->orderBy('date', 'desc');
        }])->first();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ReeferMonitoring $reefer_monitoring
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ReeferMonitoring $reefer_monitoring)
    {
        $this->authorize('delete', ReeferMonitoring::class);
        $container_id = $reefer_monitoring->container_id;
        $reefer_monitoring->delete();

        $container = Container::where('id', $container_id);
        return $container->with(['reefer_monitoring' => function ($q) {
            $q->orderBy('date', 'desc');
        }])->first();

    }

    /**
     * @param DataTables $datatables
     * @return mixed
     * @throws \Exception
     */
    public function data(DataTables $datatables)
    {
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
                    && $search->date == ''
                    && $search->yard_location == ''
                    && !isset($search->plug_off)
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
        if ($search->date != '') {
            $container->where('plug_on_date', '<=', $search->date);
        }
//        if ($search->box_owner != '') {
//            $container->where('box_owner', $search->box_owner);
//        }
        //plug off date search
        if (isset($search->plug_off)) {
            if (isset($search->plug_cat) && $search->plug_cat == 'plug_on_and_off_only') {
                $container->where('plugging_category', 'plug_on_and_off_only');
            }
            $container->whereNotNull('plug_off_date');
        } else {
            $container->whereNull('plug_off_date');
        }
        //todo-search by file
        if ($ext['file_id'] != '') {

        }


        return $datatables->eloquent($container)
            ->addColumn('schedule_4', function ($container) use ($search) {
                $_SERVER['state'] = $state = CommonQueryController::stateOfMonitoring($container, $search);
                return view('reefer_monitoring.table_elements.schedule_4', compact('container', 'state'));
            })
            ->addColumn('schedule_8', function ($container) use ($search) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.table_elements.schedule_8', compact('container', 'state'));
            })
            ->addColumn('schedule_12', function ($container) use ($search) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.table_elements.schedule_12', compact('container', 'state'));
            })
            ->addColumn('schedule_16', function ($container) use ($search) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.table_elements.schedule_16', compact('container', 'state'));
            })
            ->addColumn('schedule_20', function ($container) use ($search) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.table_elements.schedule_20', compact('container', 'state'));
            })
            ->addColumn('schedule_24', function ($container) use ($search) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.table_elements.schedule_24', compact('container', 'state'));
            })
            ->addColumn('monitoring_date', function ($container) use ($search) {
                return $_SERVER['state']->date_tag;
            })
            ->addColumn('state', function ($container) use ($search) {
                return $_SERVER['state']->code;
            })
            ->addColumn('plug_off_date', function ($container) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.table_elements.plug_off_date', compact('container', 'state'));
            })
            ->addColumn('plug_off_time', function ($container) {
                return view('reefer_monitoring.table_elements.plug_off_time', compact('container'));
            })
            ->addColumn('plug_off_temp', function ($container) {
                return view('reefer_monitoring.table_elements.plug_off_temp', compact('container'));
            })
            ->addColumn('plugging_category', function ($container) {
                return view('reefer_monitoring.table_elements.plugging_category', compact('container'));
            })
            ->addColumn('quick_save', function ($container) use ($search) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.quick_save', compact('container', 'state'));
            })
            ->addColumn('delete', function ($container) use ($search) {
                $state = $_SERVER['state'];
                return view('reefer_monitoring.delete', compact('container', 'state'));
            })
            ->addColumn('action', function ($container) {
                return view('reefer_monitoring.actions', compact('container'));
            })
            ->addColumn('empty', function ($container) {
            })
            ->rawColumns(['action', 'quick_save',
                'schedule_4',
                'schedule_8',
                'schedule_12',
                'schedule_16',
                'schedule_20',
                'schedule_24',
                'plug_off_date',
                'plug_off_time',
                'plug_off_temp',
                'monitoring_date',
                'state',
                'delete',
                'plugging_category'])
            ->make(true);
    }

//todo -quick save

    public function row_update($id, $monitoring_id = '', Request $request)
    {
        $responce = new \stdClass();
        $message = ['error' => [], 'warning' => [], 'success' => [],];
        $monitoring_validation = new MonitoringValidationController($id, $request);

        $container = Container::find($id);
        if ($request->status == 0 || $request->status == 7) {
            //if status is 0 - means plug off container
            if ($monitoring_validation->isValidVesselVoyage()) {
            }
            if ((isset($request->plug_off_date) && isset($request->plug_off_time) && isset($request->plug_off_temp)) || $container->plug_off_date!='') {
                if (sizeof($monitoring_validation->message['error']) > 0) {
                    $monitoring_validation->message['error'][] = "Plug off not allowed.";
                } else {

                    $container->plug_off_date = $request->plug_off_date;
                    $container->plug_off_time = $request->plug_off_time;
                    $container->plug_off_temp = $request->plug_off_temp;
                    $container->update();
                    $monitoring_validation->message['success'][] = "Plug off changed Successful !";
                    //$message->container = $container;
                }
           } else {
            }
        } else {

            if ($request->status == 13 || $request->status == 15) {
                $monitoring = ReeferMonitoring::where('container_id', $id)
                    ->where('date', $request->row_monitoring_date)->first();
                if ($monitoring != null) {
                    if ($monitoring_validation->isValidMonitoring()) {
                        $monitoring->schedule_4 = $request->schedule_4;
                        $monitoring->schedule_8 = $request->schedule_8;
                        $monitoring->schedule_12 = $request->schedule_12;
                        $monitoring->schedule_16 = $request->schedule_16;
                        $monitoring->schedule_20 = $request->schedule_20;
                        $monitoring->schedule_24 = $request->schedule_24;
                        $monitoring->update();//update new monitoring
                        $responce->monitoring = $monitoring;
                        $monitoring_validation->message['success'][] = "Successfully saved";
                    }
                } else {
                    $monitoring_validation->message['error'][] = "Monitoring Not found";
                }
            }
            if ($monitoring_validation->isValidVesselVoyage()) {

                if ($monitoring_validation->isSetPlugOff()) {

                    if ($monitoring_validation->isPlugOffFilled()) {
                        if ($monitoring_validation->isValidPlugOff()) {
                        }
                        if ($monitoring_validation->isValidFill()) {

                        }

                    }


                    if (sizeof($monitoring_validation->message['error']) > 0) {
                        $monitoring_validation->message['error'][] = "Plug off not allowed.";
                    } else {
                        $container->plug_off_date = $request->plug_off_date;
                        $container->plug_off_time = $request->plug_off_time;
                        $container->plug_off_temp = $request->plug_off_temp;
                        $container->update();
                        $monitoring_validation->message['success'][] = "Plug off Successful !";
                        //$message->container = $container;
                    }
                }


            }

        }


        $responce->message = $monitoring_validation->message;
        return json_encode((array)$responce);
    }

//todo - quick create
    public function row_create($id, Request $request)
    {
        $responce = new \stdClass();
        $message = ['error' => [], 'warning' => [], 'success' => [],];

        $container = Container::find($id);
        $monitoring_validation = new MonitoringValidationController($id, $request);

        if (
            $request->status == 12
            || $request->status == 14
            || $request->status == 11
            || $request->status == 13
            || $request->status == 15
        ) {//new monitoring search date is plug on date.
            if ($monitoring_validation->isValidMonitoring()) {
                $monitoring = new ReeferMonitoring();
                $monitoring->container_id = $id;
                $monitoring->date = $request->row_monitoring_date;
                $monitoring->schedule_4 = $request->schedule_4;
                $monitoring->schedule_8 = $request->schedule_8;
                $monitoring->schedule_12 = $request->schedule_12;
                $monitoring->schedule_16 = $request->schedule_16;
                $monitoring->schedule_20 = $request->schedule_20;
                $monitoring->schedule_24 = $request->schedule_24;
                $monitoring->save();//update monitoring
                $responce->monitoring = $monitoring;
            }
        }
        if ($monitoring_validation->isValidVesselVoyage()) {

            if ($monitoring_validation->isSetPlugOff()) {

                if ($monitoring_validation->isPlugOffFilled()) {
                    if ($monitoring_validation->isValidPlugOff()) {

                    }
                    if ($monitoring_validation->isValidFill()) {

                    }

                }


                if (sizeof($monitoring_validation->message['error']) > 0) {
                    $monitoring_validation->message['error'][] = "Plug off not allowed.";
                } else {
                    $container->plug_off_date = $request->plug_off_date;
                    $container->plug_off_time = $request->plug_off_time;
                    $container->plug_off_temp = $request->plug_off_temp;
                    $container->update();
                    $monitoring_validation->message['success'][] = "Plug off Successful !";
                    //$message->container = $container;
                }
            }
        }

        $responce->message = $monitoring_validation->message;
        return json_encode((array)$responce);
    }

    public function row_delete(ReeferMonitoring $monitoring)
    {
        $responce = new \stdClass();
        $responce->message = ['error' => [], 'warning' => [], 'success' => [],];
        $responce->monitoring = $monitoring->replicate();
        $responce->message['success'][] = "Monitoring id: {$monitoring->id} Successfully Deleted";
        $monitoring->delete();
        $responce->monitoring = $responce->monitoring->toArray();
        return json_encode((array)$responce);

    }

    public function plugging_category(Container $container, Request $request)
    {
        if ($container->reefer_monitoring()->count() < 1) {
            if ($container->plug_off_date != '') {
                return '{"error":"Action Not allowed until Plug off date time and temp is removed"}';
            } else {
                isset($request->plugging_category) ? $container->plugging_category = $request->plugging_category : $container->plugging_category = 'monitoring';
                isset($request->plugging_category) ? $container->box_owner = 3 : $container->box_owner = null;//3 is MAERSK line
                $container->update();
            }
        }
        return Container::query()
            ->where('id', $container->id)
            ->with('reefer_monitoring')
            ->first();
    }
}

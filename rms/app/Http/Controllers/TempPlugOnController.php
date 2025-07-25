<?php

namespace App\Http\Controllers;

use App\Container;
use App\TempPlugOn;
use App\Upload;
use App\Vessel;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class TempPlugOnController extends Controller
{
    /**
     * TempPlugOnController constructor.
     */
    function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    /**
     * @param Upload $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Upload $file)
    {
        $vessels = Vessel::all();
        $data = json_decode($file->data);

        return view('container.upload.create', compact('file', 'vessels', 'data'));
    }

    /**
     * @param DataTables $datatables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $datatables)
    {
        //dd($datatables->getRequest()->extra_search);
        $data = $datatables->getRequest()->extra_search;
        $temp_plug_on = TempPlugOn::query()->with(['vessel', 'voyage', 'ex_vessel', 'ex_voyage', 'owner'])->where('file_id', $data['file']);
        //counting errors
        $message = ['error' => 0, 'warning' => 0, 'success' => 0, 'error_count' => 0];
        foreach ($temp_plug_on->get() as $container) {
            $mes = self::containerValidate($container);
            $message['error'] += $mes['count'];
            if ($mes['count'] == 0) {
                $message['success']++;
            }
        }

        return $datatables->eloquent($temp_plug_on)
            ->with('message', $message)
            ->setRowId('id')
            ->editColumn('vessel.name',function($container){
                return $container->vessel?$container->vessel->name:'';
            })
            ->editColumn('owner.name',function($container){
                return $container->box_owner?$container->owner->name:'';
            })
            ->editColumn('voyage.code',function($container){
                return $container->voyage?$container->voyage->code:'';
            })
            ->addColumn('status', function ($container) {
                $prev_container = Container::where('container_number', $container->container_number)
                    ->latest('plug_on_date')->first();
                return view('container.upload.status', compact('container', 'prev_container'));
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    /**
     * @param Upload $file
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Upload $file)
    {
        $temp_plug_ons = TempPlugOn::where('file_id', $file->id)->get();
        $message = ['error' => [], 'warning' => [], 'success' => [], 'error_count' => 0];

        foreach ($temp_plug_ons as $container) {
            $mes = self::containerValidate($container);
            $message['error'] = array_merge($message['error'], $mes['error']);
            $message['error_count'] += $mes['count'];
            if ($mes['count'] == 0) {
                $new_container = new Container();
                $new_container->vessel_id = $container->vessel_id;
                $new_container->voyage_id = $container->voyage_id;
                $new_container->container_number = $container->container_number;
                $new_container->loading_discharging = $container->loading_discharging;
                $new_container->yard_location = $container->yard_location;
                $new_container->ts_local = $container->ts_local;
                $new_container->temperature_unit = $container->temperature_unit;
                $new_container->set_temp = $container->set_temp;
                $new_container->plug_on_date = $container->plug_on_date;
                $new_container->plug_on_time = $container->plug_on_time;
                $new_container->plug_on_temp = $container->plug_on_temp;
                $new_container->rdt_temp = $container->rdt_temp;
                $new_container->remarks = $container->remarks;
                $new_container->ex_on_career_vessel = $container->ex_on_career_vessel;
                $new_container->ex_on_career_voyage = $container->ex_on_career_voyage;
                $new_container->box_owner = $container->box_owner;
                $new_container->save();
                $message['success'][] = "Success: $new_container->container_number Uploaded successfully";
            }

        }
        return redirect('/container')
            ->with('message', $message)
            ->with('success', "Excel data successfully uploaded");
    }

    public static function containerValidate($container, $row = '')
    {
        $prev_container = Container::where('container_number', $container->container_number)->latest('plug_on_date')->first();;
        $error_count = 0;
        $message = ['error' => [], 'warning' => [], 'success' => []];

        if ($prev_container != null) {
            if ($prev_container->plug_off_date == '' && $prev_container->plug_off_time == '') {
                $error_count++;
                $message['error'][] = "Error: $container->container_number Plug Off not found on ($prev_container->plug_on_date) ! [$row]";
            }

            if ($prev_container->plug_off_date > $container->plug_on_date) {

                $error_count++;

                $message['error'][] = "Error: $container->container_number Plug on Date must be later date than previous plug off($prev_container->plug_off_date) ![$row]";

            }

        }

        if ($container->container_number == '') {
            $error_count++;
            $message['error'][] = "Error: Container number required ! [$row]";

        }
        if (strlen($container->container_number) != 11) {

            $error_count++;

            $message['error'][] = "Error: $container->container_number $container->container_number Container number must be of 11 characters ![$row]";

        }
        if ($container->container_number == '') {

            $error_count++;

            $message['error'][] = "Error: $container->container_number Container number required ![$row]";

        }
        if ($container->vessel_id != '' && !isset($container->vessel)) {

            $error_count++;

            $message['error'][] = "Error: $container->container_number Vessel is not In Database ![$row]";

        }
        if ($container->voyage_id != '' && !isset($container->voyage)) {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Voyage is not In Database![$row]";

        }
        if ($container->ex_on_career_vessel != '' && !isset($container->ex_vessel)) {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Ex On Carrier Vessel is not In Database![$row]";

        }
        if ($container->ex_on_career_voyage != '' && !isset($container->ex_voyage)) {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Ex On Carrier Voyage is not In Database![$row]";

        }
        if ($container->yard_location == '') {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Yard Location Required![$row]";

        }
        if ($container->ts_local == '') {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Un Known Container Category![$row]";

        }
        if ($container->set_temp === null) {//is a float must not be null
            $error_count++;


            $message['error'][] = "Error: $container->container_number Set Temperature Required![$row]";

        }
        if ($container->plug_on_temp === null) {//is a float must not be null
            $error_count++;


            $message['error'][] = "Error: $container->container_number Plug On Temperature Required![$row]";

        }
        if ($container->plug_on_date == '') {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Plug On Date Required![$row]";

        }
        if ($container->plug_on_time == '') {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Plug On Time Required![$row]";

        }
        if ($container->box_owner != '' && !isset($container->box_owner)) {
            $error_count++;


            $message['error'][] = "Error: $container->container_number Box Owner is not In Database![$row]";

        }
//        if ($container->box_owner == '') {
//            $error_count++;
//
//            $message['error'][] = "Error: $container->container_number Box Owner Required![$row]";
//
//        }

        $message['count'] = $error_count;

        return $message;
    }
}

<?php

namespace App\Http\Controllers;

use App\BulkEdit;
use App\BulkEditRow;
use App\Container;
use App\Vessel;
use App\Voyage;
use Illuminate\Http\Request;
use DB;

class BulkEditController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    public function edit(Request $request)
    {
        $message = [];
        $containers = Container::query();
        $search_arr = $request->ext_search;
        $search_arr['plug_on_date'] = $request->search_plug_on_date;

        $search = new \stdClass();

        foreach ($search_arr as $k => $search_option) {
            $search->{$k} = $search_option;
        }
        $search->plug_on_date = $request['search_plug_on_date'];

        //search query
        if ($search->vessel_id != '' && $search->voyage_id != '') {
            if ($search->loading_discharging == 'B') {
                $containers->where(function($query)use($search){
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
                $containers->where(function ($q) use ($search) {
                    $q->where('ex_on_career_vessel', $search->vessel_id);
                    $q->where('ex_on_career_voyage', $search->voyage_id);
                });
            } elseif ($search->loading_discharging == 'D') {
                $containers->where(function ($q) use ($search) {
                    $q->where('vessel_id', $search->vessel_id);
                    $q->where('voyage_id', $search->voyage_id);
                });
            }
            if($search->container_number!='') {
                $containers->where('container_number', $search->container_number);
            }
            if($search->plug_on_date!='') {
                $containers->where('plug_on_date', $search->plug_on_date);
            }
            if($search->yard_location!='') {
                $containers->where('yard_location', $search->yard_location);
            }
            if (isset($search->plug_on) && !isset($search->plug_off)) {
                //echo "plug on with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_on_date');
                    $q->whereNull('plug_off_date');
                    //$q->whereNotNull('plug_on_time');
                });
            }
            elseif (!isset($search->plug_on) && isset($search->plug_off)) {
                //echo "plug off with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_off_date');
                    //$q->whereNull('plug_on_date');
                    //$q->whereNotNull('plug_off_time');
                });
            }

        } else {

            if ($search->loading_discharging == 'B') {

                if(
                    $search->container_number==''
                    &&$search->plug_on_date==''
                    &&$search->yard_location==''
                    &&!isset($search->plug_on)
                    &&!isset($search->plug_off)
                ) {
                    $containers->whereNull('id');//to stop from returning all data when non is selected
                }
            }else if ($search->loading_discharging == 'L') {
                $containers->whereNotNull('ex_on_career_vessel');
                $containers->whereNotNull('ex_on_career_voyage');
            }else if ($search->loading_discharging == 'D'){
                $containers->whereNotNull('vessel_id');
                $containers->whereNotNull('voyage_id');
            }
            if($search->container_number!='') {
                $containers->where('container_number', $search->container_number);
            }
            if($search->plug_on_date!='') {
                $containers->where('plug_on_date', $search->plug_on_date);
            }
            if($search->yard_location!='') {
                $containers->where('yard_location', $search->yard_location);
            }
            if (isset($search->plug_on) && !isset($search->plug_off)) {
                //echo "plug on with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_on_date');
                    $q->whereNull('plug_off_date');
                    //$q->whereNotNull('plug_on_time');
                });
            }
            elseif (!isset($search->plug_on) && isset($search->plug_off)) {
                //echo "plug off with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_off_date');
                    //$q->whereNull('plug_on_date');
                    //$q->whereNotNull('plug_off_time');
                });
            }

        }
        //end search query


        $bulk_edit = new BulkEdit();
        $bulk_edit->options = json_encode($request->toArray(), true);
        $bulk_edit->action = 'EDIT';
        $bulk_edit->guard = check_guard();
        $bulk_edit->user_id = auth()->user()->id;
        //dd($search_arr);
        $bulk_edit->save();

        $vss_code_before = Vessel::find($search_arr['vessel_id'])->code??'All';
        $voy_code_before = Voyage::find($search_arr['voyage_id'])->code??'All';

        $vss_code_after = Vessel::find($request->vessel_id)->code??'Same';
        $voy_code_after = Voyage::find($request->voyage_id)->code??'Same';


            foreach ($containers->get() as $k => $container) {

                $bulk_edit_row = new BulkEditRow();
                $bulk_edit_row->bulk_edit_id = $bulk_edit->id;
                $bulk_edit_row->edited_row = $container->toJson();
                $bulk_edit_row->save();

                if($request->loading_discharging=='L') {
                    $container->ex_on_career_vessel = $request->vessel_id;
                    $container->ex_on_career_voyage= $request->voyage_id;

                    $message['success'][] =
                        "Edited: $container->container_number \n
                        Load/Dis $container->loading_discharging to ".($request->loading_discharging??'same')." \n
                        Ex_on_carrier vessel: $vss_code_before to $vss_code_after\n
                        Ex_on_carrier Voyage: $voy_code_before to $voy_code_after";

                }elseif ($request->loading_discharging=='D'){
                    $container->vessel_id = $request->vessel_id;
                    $container->voyage_id= $request->voyage_id;
                    $message['success'][] =
                        "Edited: $container->container_number \n
                        Load/Dis $container->loading_discharging to ".($request->loading_discharging??'same')." \n
                        vess: $vss_code_before to $vss_code_after\n
                        voyage: $voy_code_before to $voy_code_after";

                }


                $container->save();

            }

        echo json_encode($message);
    }

    public function revert(Request $request){
        $message['success'][]='Revert';
        $bulk_edit = BulkEdit::query()->with('bulk_edit_rows')
            ->where('guard',check_guard())
            ->where('user_id',auth()->user()->id)
            ->orderBy('created_at','DESC')->first();


        foreach ($bulk_edit->bulk_edit_rows as $k => $v ){
            $row_object  = json_decode($v->edited_row);
            $container_save = Container::find($row_object->id);
            if($container_save!=null) {
                $container = $container_save->replicate();


            $vessel_code_befor = Vessel::find($container->vessel_id)->code;
            $vessel_code_after = Vessel::find($row_object->vessel_id)->code;

            $voyage_code_befor = Voyage::find($container->voyage_id)->code;
            $voyage_code_after = Voyage::find($row_object->voyage_id)->code;

             $me = "Revert: $row_object->container_number \n
            Load\Dis: $container->loading_discharging to $row_object->loading_discharging \n
            Vessel: $vessel_code_befor to $vessel_code_after \n
            Voyage: $voyage_code_befor to $voyage_code_after";


            $container_save->vessel_id = $row_object->vessel_id;
            $container_save->voyage_id = $row_object->voyage_id;
            $container_save->loading_discharging = $row_object->loading_discharging;
            if($container_save->update()){
                $message['success'][] = $me;
            }else{
                $message['error'][] = 'Error '.$me;
            }
            $bulk_edit->action = "REVERT";
            $bulk_edit->update();
            }
        }

        echo json_encode($message);
    }

    public function delete(Request $request){
        $message = [];
        $containers = Container::query();
        $search_arr = $request->ext_search;
        $search_arr['plug_on_date'] = $request->search_plug_on_date;
        $search = new \stdClass();

        foreach ($search_arr as $k => $search_option) {
            $search->{$k} = $search_option;
        }
        $search->plug_on_date = $request['search_plug_on_date'];

        //search query
        if ($search->vessel_id != '' && $search->voyage_id != '') {
            if ($search->loading_discharging == 'B') {
                $containers->where(function($query)use($search){
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
                $containers->where(function ($q) use ($search) {
                    $q->where('ex_on_career_vessel', $search->vessel_id);
                    $q->where('ex_on_career_voyage', $search->voyage_id);
                });
            } elseif ($search->loading_discharging == 'D') {
                $containers->where(function ($q) use ($search) {
                    $q->where('vessel_id', $search->vessel_id);
                    $q->where('voyage_id', $search->voyage_id);
                });
            }
            if($search->container_number!='') {
                $containers->where('container_number', $search->container_number);
            }
            if($search->plug_on_date!='') {
                $containers->where('plug_on_date', $search->plug_on_date);
            }
            if($search->yard_location!='') {
                $containers->where('yard_location', $search->yard_location);
            }
            if (isset($search->plug_on) && !isset($search->plug_off)) {
                //echo "plug on with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_on_date');
                    $q->whereNull('plug_off_date');
                    //$q->whereNotNull('plug_on_time');
                });
            }
            elseif (!isset($search->plug_on) && isset($search->plug_off)) {
                //echo "plug off with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_off_date');
                    //$q->whereNull('plug_on_date');
                    //$q->whereNotNull('plug_off_time');
                });
            }

        } else {

            if ($search->loading_discharging == 'B') {

                if(
                    $search->container_number==''
                    &&$search->plug_on_date==''
                    &&$search->yard_location==''
                    &&!isset($search->plug_on)
                    &&!isset($search->plug_off)
                ) {
                    $containers->whereNull('id');//to stop from returning all data when non is selected
                }
            }else if ($search->loading_discharging == 'L') {
                $containers->whereNotNull('ex_on_career_vessel');
                $containers->whereNotNull('ex_on_career_voyage');
            }else if ($search->loading_discharging == 'D'){
                $containers->whereNotNull('vessel_id');
                $containers->whereNotNull('voyage_id');
            }
            if($search->container_number!='') {
                $containers->where('container_number', $search->container_number);
            }
            if($search->plug_on_date!='') {
                $containers->where('plug_on_date', $search->plug_on_date);
            }
            if($search->yard_location!='') {
                $containers->where('yard_location', $search->yard_location);
            }
            if (isset($search->plug_on) && !isset($search->plug_off)) {
                //echo "plug on with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_on_date');
                    $q->whereNull('plug_off_date');
                    //$q->whereNotNull('plug_on_time');
                });
            }
            elseif (!isset($search->plug_on) && isset($search->plug_off)) {
                //echo "plug off with vessel voyage";
                $containers->where(function ($q) use ($search) {
                    $q->whereNotNull('plug_off_date');
                    //$q->whereNull('plug_on_date');
                    //$q->whereNotNull('plug_off_time');
                });
            }

        }
        //end search query
        $bulk_edit = new BulkEdit();
        $bulk_edit->options = json_encode($request->toArray(), true);
        $bulk_edit->action = 'DELETE';
        $bulk_edit->guard = check_guard();
        $bulk_edit->user_id = auth()->user()->id;
        //dd($search_arr);
        $bulk_edit->save();


        foreach ($containers->get() as $k => $container) {
            $me = "Delete : $container->container_number \n";
            $bulk_edit_row = new BulkEditRow();
            $bulk_edit_row->bulk_edit_id = $bulk_edit->id;
            $bulk_edit_row->edited_row = $container->toJson();
            $bulk_edit_row->save();

            if($container->plug_off_date=='') {
                if ($container->delete()) {
                    $message['success'][] = $me;
                } else {
                    $message['error'][] = 'Error ' . $me;
                }
            }else{
                $message['error'][] = 'Error ' . $me.'already plugged off';
            }


        }
        echo json_encode($message);
    }

    public function edit_stack(){
        $bulk_edits = BulkEdit::where('action','EDIT')
            ->where('user_id',auth()->user()->id)
            ->where('guard',check_guard())->orderBy('created_at','DESC')->limit(10)->get();
        return $bulk_edits;
    }
}

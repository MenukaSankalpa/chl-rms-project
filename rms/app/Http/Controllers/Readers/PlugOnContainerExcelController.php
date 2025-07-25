<?php

namespace App\Http\Controllers\Readers;

use App\BoxOwner;
use App\Container;
use App\TempContainer;
use App\TempPlugOn;
use App\Upload;
use App\Vessel;
use App\Voyage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PlugOnContainerExcelController extends Controller
{
    public function read(Upload $file)
    {
        $message = ['warning' => [], 'error' => [], 'success' => []];
        $file_name = $file->path . '/' . $file->saved_index;
        $spreadsheet = IOFactory::load($file_name);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        //var_dump($sheetData);

        foreach ($sheetData as $k => $row) {
            $error_count = 0;

            if (($row['A'] != '' || $row['B'] != '') && is_numeric($row['C'])) {

                $data = json_decode($file->data);
                $ld = 'D';
                if ($data->vessel_id == '' && $data->voyage_id == '') {
                    $ld = 'L';
                }

                $container = new TempPlugOn();
                $container->vessel_id = $data->vessel_id;
                $container->voyage_id = $data->voyage_id;
                $container->temperature_unit = $data->temperature_unit;
                $container->loading_discharging = $ld;
                $container->yard_location = $row['A'];
                $container->container_number = $row['B'];
                $container->set_temp = $row['C'];
                $container->plug_on_temp = $row['D'];
                $container->plug_on_date = $this->date_format($row['E']);
                $container->plug_on_time = $row['F'];
                $box_owner = BoxOwner::where('code', $row['G'])->first();
                $container->box_owner = $box_owner != null ? $box_owner->id : null;
                if(trim(strtoupper($row['H']))=='TRANSSHIPMENT'){
                    $ts = 'TS';
                }elseif (trim(strtoupper($row['H']))=='EXPORT'){
                    $ts = 'EXP';
                }elseif ((trim(strtoupper($row['H']))=='IMPORT')){
                    $ts = 'IMP';
                }elseif ((trim(strtoupper($row['H']))=='RESTOW')){
                    $ts = 'RSTW';
                }else{
                    $ts ='';
                }
                $container->ts_local = $ts;
                $container->file_id = $file->id;
                $container->save();

                //todo - plugoff read previous date last entry < current date - ok
                //todo - plugoff read previous date last entry > current date - fail
                //todo - plugoff read previous date last entry not plug off -> warning not plugged off
                //todo - doing
            }
        }

        //return redirect('/temp_container/'.$file->id.'/edit')->with('success', 'Plug On Container Excel Uploaded Successfully');
        return redirect('/temp_plug_on/'.$file->id)->with('success', 'Plug On Container Excel Uploaded Successfully');
    }


    public function date_format($date)
    {
        if(preg_match_all('/(?P<day>([0-2]?[0-9])|([3]?[0-1]))\/(?P<month>[A-Za-z]{3})\/(?P<year>([0-2]?[0-9]))/', $date, $matches)) {
            $month_arr = ['jan' => '01', 'feb' => '02', 'mar' => '03', 'apr' => '04', 'may' => '05', 'jun' => '06', 'jul' => '07', 'aug' => '08', 'sep' => '09', 'sept' => '09', 'oct' => '10', 'nov' => '11', 'dec' => '12'];
            $month = $month_arr[strtolower($matches['month'][0])];
            return '20' . $matches['year'][0] . '-' . $month . '-' . $matches['day'][0];
        }
        return null;
    }
}

<?php

namespace App\Http\Controllers;

use App\Container;
use App\ReeferMonitoring;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * since validation is a main component of the system clear separation of validation functions and system methods was became a
 * requirement. provided validation methods of laravel are not enough to handle this task so.
 * The Monitoring validation controller separates validation from the create and save method of ReeferMonitoringController
 * the basic set of validations are as follows
 *
 * 1. At least one monitoring should be filled
 * 2. plug of date time and temp needs to be set
 * 3. one of two vessel voyages should be filled
 * 4. plug off at time slot must be within the last monitoring time slot
 * 5. within plug on of period every slot must be filled
 * 6. ignore time slots tat are less than plug on at
 */
class MonitoringValidationController extends Controller
{
    /**
     * @var integer $id - id of the container
     */
    public $id = null;
    /**
     * @var Request $request - Request object of the relevant method
     */
    public $request = null;
    /**
     * @var array $message - placeholder for Error Warning and Success messages
     */
    public $message = ['error' => [], 'warning' => [], 'success' => [],];
    /**
     * @var Container $container - App\Container
     */
    public $container = null;
    /**
     * @var ReeferMonitoring $last_monitoring - App\ReeferMonitoring last monitoring fot the selected container.
     */
    public $last_monitoring = null;
    /**
     * @var array $molnitoring_time_slots - Array of Monitoring time slots (Current standard is 6 time slots each every four hours starting from 0th hour).
     * todo - make responsive time schedule where user can change time slots
     */
    public $monitoring_time_slots = [
        'schedule_4' => '04:00:00',
        'schedule_8' => '08:00:00',
        'schedule_12' => '12:00:00',
        'schedule_16' => '16:00:00',
        'schedule_20' => '20:00:00',
        'schedule_24' => '24:00:00'
    ];

    /**
     * MonitoringValidationController constructor.
     * @param $id - Id of the validating container
     * @param $request - Request sent to create or store methods of ReeferMonitoringController
     */
    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->request = $request;
        $this->container = Container::find($id);
        $this->last_monitoring = $this->last_monitoring();
    }

    /**
     * 09/15/2019 - Dhawala
     * Assign last monitoring and return last monitoring.
     * real time last monitoring is required when
     * quick saving the monitoring dta and plug off at same time.
     * @return App\ReeferMonitoring - last monitoring day for the selected container.
     */
    public function last_monitoring()
    {
        return $this->last_monitoring = ReeferMonitoring::where('container_id', $this->id)->latest('date')->first();
    }

    /**
     * At least one monitoring should be filled
     */
    public function isValidMonitoring()
    {
        if (
            $this->request->schedule_4 != ''
            || $this->request->schedule_8 != ''
            || $this->request->schedule_12 != ''
            || $this->request->schedule_16 != ''
            || $this->request->schedule_20 != ''
            || $this->request->schedule_24 != ''
        ) {
            $this->message['success'][] = "Monitoring Successfully Created.";
            return true;
        } else {
            $this->message['success'][] = "No Monitoring changes were found";
            return false;
        }
    }

    /**
     * All three plug off date time and temp needs to be set. and if even one of them is missing give an error with return false
     */
    public function isSetPlugOff()
    {
        if (
            isset($this->request->plug_off_date)
            && isset($this->request->plug_off_time)
            && isset($this->request->plug_off_temp)
        ) {
            return true;
        } else if (
            isset($this->request->plug_off_date)
            || isset($this->request->plug_off_time)
            || isset($this->request->plug_off_temp)
        ){
            $this->message['error'][] = "To plug off all three of Plug off date time and temp must be set";
            return false;
        }

    }

    /**
     * All three Plug off date time temp must be filled.
     * @return bool
     */
    public function isPlugOffFilled()
    {
        if (
            $this->request->plug_off_date != ''
            && $this->request->plug_off_time != ''
            && $this->request->plug_off_temp != ''
        ) {
            return true;
        } else {
            $this->message['warning'][] = "To plug off all three of Plug off date time and temp must be filled";
            return false;
        }

    }

    /**
     * Either vessel voyage or Loading Vessel voyage should be filled for the container.
     */
    public function isValidVesselVoyage()
    {
        if (
            ($this->container->vessel_id != null && $this->container->voyage_id != null)
            || ($this->container->ex_on_career_vessel != null && $this->container->ex_on_career_voyage != null)
        ) {
            return true;
        } else {
            $this->message['error'][] = "Loading/Discharging Vessel Voyages are missing.";
            return false;
        }
    }

    /**
     * Checks if the monitoring data fill is valid, before plug off following standards should met.
     * 1. plug off at time slot must be within the last monitoring time slot.
     * 2. within plug on of period every slot must be filled.
     * 3. ignore time slots tat are less than plug on at.
     */
    public function isValidFill()
    {
        for ($i = Carbon::parse($this->getPlugOnTimeSlot());
             $i->toDateTimeString() <= Carbon::parse($this->getLastMonitoringTimeSlot())->toDateTimeString();
             $i = $i->addHours(4)) {
            //var_dump($this->dateString24Midnight($i->toDateTimeString()));
            if ($this->isDateHasMonitoring($this->dateString24Midnight($i->toDateTimeString()))) {
                if ($this->isEmptySlot($this->dateTimeString24Midnight($i->toDateTimeString()))) {

                }
            }
            //dump($i->toDateTimeString());
            if ($this->request->plug_off_date . ' ' . $this->request->plug_off_time < $this->dateTimeString24Midnight($i->toDateTimeString())) {
                $this->message['error'][] = "Plug Off Must be later than {$this->dateTimeString24Midnight($i->toDateTimeString())}.";
            }

        }
        return sizeof($this->message['error']) == 0;//added after testing remove if necessary
        //dd();
    }

    /**
     * By the common practice customer counts the midnight as 24:00 of current day but
     * php language conceder midnight as 00:00 th hour of next day according to ISO standard
     * So we have to improvise to resolve time conflict.
     * this function takes the 00:00 hour of current day and converts it in to 24:00th hour of previous day if date is not the plug on date
     *
     * @param $date - date with time slot
     * @return string - date-time string
     */
    public function dateTimeString24Midnight($date)
    {
        if ($this->getPlugOnTimeSlot() != $date) {
            $d = Carbon::parse($date);
            return $d->toTimeString() == '00:00:00' ? $d->sub(1, 'day')->toDateString() . " 24:00:00" : $d->toDateTimeString();
        } else {
            return $this->getPlugOnTimeSlot();
        }
    }

    /**
     * as same as the dateTimeString24Midnight function this also converts current day to previous day on midnight time slot but only returns day
     * @param $date - date with time slot
     * @return string - date only string
     */
    public function dateString24Midnight($date)
    {
        if ($this->getPlugOnTimeSlot() != $date) {
            $d = Carbon::parse($date);
            return $d->toTimeString() == '00:00:00' ? $d->sub(1, 'day')->toDateString() : $d->toDateString();
        } else {
            return Carbon::parse($this->getPlugOnTimeSlot())->toDateString();
        }
    }

    /**
     * checks weather the plug off is in the correct time slot
     * for monitoring containers plug off must be in between the last monitoring time slot and immediately after time slot.
     * any time larger or smaller are invalid
     * @return bool
     */
    public function isValidPlugOff()
    {
        if (
            ($this->getLastMonitoringTimeSlot() < $this->request->plug_off_date . ' ' . $this->request->plug_off_time)
            && ($this->request->plug_off_date . ' ' . $this->request->plug_off_time < Carbon::parse($this->getLastMonitoringTimeSlot())->addHours(4)->toDateTimeString())
        ) {
            return true;
        } else {
            $this->message['error'][] = "Plug Off Must be Between {$this->getLastMonitoringTimeSlot()} and " . Carbon::parse($this->getLastMonitoringTimeSlot())->addHours(4)->toDateTimeString() . " .";
            return false;
        }
    }

    /**
     * sole purpose of this function is to get the correct plug on time slot.
     * plug on date time is compared with monitoring time slot array in order to get the correct time slot.
     * @return string
     */
    public function getPlugOnTimeSlot()
    {
        //$time_slot = Carbon::parse($this->container->plug_on_date)->sub(1, 'day')->toDateString() . ' ' . '24:00:00';//monitoring not found on day before plug on date error
        //$time_slot = Carbon::parse($this->container->plug_on_date)->toDateString() . ' ' . '24:00:00';//plug off not allowed on monitoring day "24:00:00" error
        $time_slot = Carbon::parse($this->container->plug_on_date)->toDateString() . ' ' . '00:00:00';
        foreach ($this->monitoring_time_slots as $monitoring_time_slot) {
            if ($this->container->plug_on_at >= $this->container->plug_on_date . ' ' . $monitoring_time_slot) {
                $time_slot = $this->container->plug_on_date . ' ' . $monitoring_time_slot;
            }
        }
        return $time_slot;
    }

    /**
     * Extract the last monitoring time slot using the last monitoring date time.
     * @return string
     */
    public function getLastMonitoringTimeSlot()
    {
        $time_slot = $this->getPlugOnTimeSlot();
        if ($this->last_monitoring() !== null) {
            foreach ($this->monitoring_time_slots as $k => $monitoring_time_slot) {
                if ($this->last_monitoring->{$k} != '') {
                    $time_slot = $this->last_monitoring->date . ' ' . $monitoring_time_slot;
                }
            }
        }
        return $time_slot;
    }

    /**
     * Check weather a date has monitoring data, if the date doesnt have monitoring then check if the given date is in plug on time slot
     * @param $date - date time string (time slot)
     * @param bool $return - if true returns the ReeferMonitoringController::class else returns true or false.
     * @return bool|App\ReeferMonitoring
     */
    public function isDateHasMonitoring($date, $return = false)
    {
        $m = ReeferMonitoring::where('container_id', $this->id)
            ->where('date', $date)->first();
        if ($m == null) {
            if (($this->dateTimeString24Midnight($this->getPlugOnTimeSlot()) < $this->request->plug_off_date . ' ' . $this->request->plug_off_time)
                && ($this->dateTimeString24Midnight(Carbon::parse($this->getPlugOnTimeSlot())->addHours(4)->toDateTimeString()) > $this->request->plug_off_date . ' ' . $this->request->plug_off_time)
            ) {

            } else {
                $this->message['error'][$date] = "No monitoring on {$date}.";
                return false;
            }
        } else {
            if ($return == true) {
                return $m;
            }
            return true;
        }
    }

    /**
     * Check weather the given time slot is empty or not if plug on at dte time is less than the slot date time. otherwise ignore.
     * @param $slot - date time string(time slot)
     * @return bool - true if empty
     */
    public function isEmptySlot($slot)
    {

        $date_time = explode(' ', $slot);
        $this_time_slot = array_search($date_time[1], $this->monitoring_time_slots);
        $m = ReeferMonitoring::where('container_id', $this->id)->where('date', Carbon::parse($date_time[0])->toDateString())->first();
        //var_dump($slot, $this->container->plug_on_at, $this->container->plug_on_at >= $slot);
        if ($this->container->plug_on_at >= $slot) {

        } else {
            if ($m->{$this_time_slot} == '') {
                $this->message['error'][] = "Empty Slot at : $slot";
                return true;
            } else {
                return false;
            }
        }
    }


}

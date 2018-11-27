<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\BookingSchedule;
use App\Addservices;

class RegisworkshopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getBookingSchedulePlan()
    {
    	$bookingSchePln = BookingSchedule::where('stationId', Auth::guard('api')->id())->where('aStatus', 'A')->first();

    	$allServices = Addservices::where('stationId', Auth::guard('api')->id())->where('status', '0')->where('serviceSerial', '!=', '0')->get();
		
		$returnData = array(
            'bookingSchePln'        => $bookingSchePln,
            'allServices'        	=> $allServices
        );
        return response($returnData, 201);
    }

    public function bookingSchedulePlan(Request $request)
    {
    	$data = array(
            'stationId'     => $request->input('stationId'), 
            'scheduleType'  => $request->input('scheduleType'), 
            'otMon'   		=> $request->input('otMon'), 
            'ctMon'      	=> $request->input('ctMon'), 
            'restMon'       => $request->input('restMon'), 
            'otTues'     	=> $request->input('otTues'), 
            'ctTues'       	=> $request->input('ctTues'), 
            'restTues'  	=> $request->input('restTues'), 
            'otWed'    		=> $request->input('otWed'),
            'ctWed'    		=> $request->input('ctWed'),
            'restWed'    	=> $request->input('restWed'),
            'otThurs'    	=> $request->input('otThurs'),
            'ctThurs'    	=> $request->input('ctThurs'),
            'restThurs'    	=> $request->input('restThurs'),
            'otFri'    		=> $request->input('otFri'),
            'ctFri'    		=> $request->input('ctFri'),
            'restFri'    	=> $request->input('restFri'),
            'otSat'    		=> $request->input('otSat'),
            'ctSat'    		=> $request->input('ctSat'),
            'restSat'    	=> $request->input('restSat'),
            'otSun'    		=> $request->input('otSun'),
            'ctSun'    		=> $request->input('ctSun'),
            'restSun'    	=> $request->input('restSun')
        );
        if(count(BookingSchedule::where('stationId', Auth::guard('api')->id())->first())>0)
    	{
    		$createData = BookingSchedule::where('stationId', $request->input('stationId'))->update($data);
            $schAdded = array(
                'add_booking_schedule' => 'Y'
            );
            User::where('id', Auth::guard('api')->id())->update($schAdded);
    	}
    	else
    	{
    		$createData = BookingSchedule::create($data);
            $schAdded = array(
                'add_booking_schedule' => 'Y'
            );
            User::where('id', Auth::guard('api')->id())->update($schAdded);
    	}
        
        if($createData)
        {
            $message    = 'Success';
            $code       = '200';
        }
        else
        {
            $message    = 'Failed';
            $code       = '403';
        }
        
        return response($message, $code);
    }

    public function addServices(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
            'serviceName'   => 'required',
            'serviceTime'   => 'required',
            'servicPrice'   => 'required',
            'serviceNumTime'=> 'required',
            'serviceSerial' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 401);
        }
    	$data = array(
            'stationId'     => $request->input('stationId'), 
            'serviceName'  	=> $request->input('serviceName'), 
            'serviceTime'   => $request->input('serviceTime'), 
            'servicPrice'   => $request->input('servicPrice'), 
            'serviceNumTime'=> $request->input('serviceNumTime'), 
            'serviceSerial' => $request->input('serviceSerial')
        );
        $createData = Addservices::create($data);
        if($createData)
        {
            $message    = 'Success';
            $code       = '200';
        }
        else
        {
            $message    = 'Failed';
            $code       = '403';
        }
        return response($message, $code);
    }

    public function deleteService(Request $request)
    {
    	$data = array(
            'status'   		=> '1'
        );
        $createData = Addservices::where('id', $request->input('ServiceId'))->where('stationId', Auth::guard('api')->id())->update($data);
        if($createData)
        {
            $message    = 'Success';
            $code       = '200';
        }
        else
        {
            $message    = 'Failed';
            $code       = '403';
        }
        return response($message, $code);
    }

    public function editService(Request $request)
    {
    	$service = Addservices::where('stationId', Auth::guard('api')->id())->where('status', '0')->where('id', $request->input('ServiceId'))->first();
		
		$returnData = array(
            'service'        => $service
        );
        return response($returnData, 201);
    }

    public function updateServices(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
            'serviceName' 	=> 'required',
            'serviceName'   => 'required',
            'serviceTime'   => 'required',
            'servicPrice'   => 'required',
            'serviceNumTime'=> 'required',
            'serviceSerial' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 401);
        }
    	$data = array(
            'serviceName'  	=> $request->input('serviceName'), 
            'serviceTime'   => $request->input('serviceTime'), 
            'servicPrice'   => $request->input('servicPrice'), 
            'serviceNumTime'=> $request->input('serviceNumTime'), 
            'serviceSerial' => $request->input('serviceSerial')
        );
        $createData = Addservices::where('id', $request->input('serviceId'))->where('stationId', Auth::guard('api')->id())->update($data);
        if($createData)
        {
            $message    = 'Success';
            $code       = '200';
        }
        else
        {
            $message    = 'Failed';
            $code       = '403';
        }
        return response($message, $code);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Challan;
use App\Tender;
use App\Schedule;
use App\Headitem;
use App\Itemtotender;
use App\Item;
use App\Workorder;
use App\Websitesetting;
use App\Mail\RequestQuoationParty;
use Mail;
use Excel;
use anlutro\cURL\cURL;

class ChallanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:create-challan', ['only' => ['create-challan','add-create-challan', 'save-challan']]);
    }

    public function createchallan()
    {
        $challans = Challan::groupBy('tender_id')->get();
        return view('admin.create-challan', compact('challans'));
    }
    
    public function editchallen(Request $request)
    {    


        $data = Challan::where('id',$request->id)->groupBy('tender_id')->first();
        return view('admin.edit-challen',compact('data'));
    }
    

    public function createchallandetail($challan_id)
    {
        $challans = Challan::where('id', $challan_id)->first();
        $itemtotenders = Tender::where('id', $challans->tender_id)->first();
        return view('admin.create-challan', compact('itemtotenders'));
    }

    public function makechallan()
    {
        $tenders = Tender::orderBy('id', 'DESC')->get();
        return view('admin.create-challan', compact('tenders'));
    }

    public function getChallanSchList(Request $request)
    {
        $schlists = Schedule::select('id', 'schedule_name')
                ->where('tender_id', $request->tender_id)
                ->orderBy('schedule_name', 'ASC')
                ->get();
        return view('admin.getChallanSchList', compact('schlists'));
    }

    public function getChallanItemHeadList(Request $request)
    {
        $itemHeadLists = Headitem::select('id', 'description')
                ->where('schedule_id', $request->schedule_id)
                ->orderBy('description', 'ASC')
                ->get();
        return view('admin.getChallanItemHeadList', compact('itemHeadLists'));
    }

    public function getChallanItemList(Request $request)
    {
        $getLists = Itemtotender::where('itemhead_id', $request->itemhead_id)
                	->get();
        $itemLists = $getLists;
        return view('admin.getChallanItemList', compact('itemLists'));
    }

    public function savechallan(Request $request)
    {
        
      
        $this->validate($request, [
            'tender_id'             => 'required',
            'schedule_id'           => 'required',
            'itemhead_id'           => 'required',
            'order_no'              => 'required',
            'date_of_challan'       => 'required',
            'dispatch_details'      => 'required',
            'challan_number'        => 'required',
            'itemQty'               => 'required'
        ]);

        for ($i=0; $i < count($request->itemQty); $i++) 
        { 
            if(!empty($request->itemQty[$i]))
            {
                $data = [
                        'tender_id'             => $request->tender_id,
                        'schedule_id'           => $request->schedule_id,
                        'itemhead_id'           => $request->itemhead_id,
                        'item_id'               => $request->item_id[$i],
                        'order_no'              => $request->order_no,
                        'date_of_challan'       => $request->date_of_challan,
                        'dispatch_details'      => $request->dispatch_details,
                        'challan_number'        => $request->challan_number,
                        'place_of_supply'       => $request->place_of_supply,
                        'inspection_authority_call_letter_number'    => $request->inspection_authority_call_letter_number,
                        'inspection_authority_call_letter_number_date' => $request->inspection_authority_call_letter_number_date,
                        'itemQty'               => $request->itemQty[$i]
                    ];


                $item = Challan::create($data);
            }
        }
        
        return redirect()->route('create-challan')
                        ->with('success','Challan successfully created..');
    }
 public function editchallan(Request $request)
    {
       
        $this->validate($request, [
            'date_of_challan'       => 'required',
            'dispatch_details'      => 'required',
            'itemQty'               => 'required'
        ]);
       
        for ($i=0; $i < count($request->id); $i++) 
        { 

            if(!empty($request->id[$i]))
            {
                $data = [
                        
                        'date_of_challan'       => $request->date_of_challan,
                        'dispatch_details'      => $request->dispatch_details,
                        'challan_number'        => $request->challan_number,
                        'place_of_supply'       => $request->place_of_supply,
                        'itemQty'               => $request->itemQty[$i]
                    ];


                $item = Challan::where('id', $request->id[$i])->update($data);

            }


          }
         return redirect()->back()
                        ->with('success','Challan successfully Updated..');
         
       
    }

}

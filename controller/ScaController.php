<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Tender;
use App\Schedule;
use App\Item;
use App\Headitem;
use App\Itemtotender;
use App\Sca;

class ScaController extends Controller
{
    function __construct()
    {
		$this->middleware('permission:sca-list');
    }

    public function sca()
    {
        $itemtotenders = Tender::orderBy('id', 'DESC')->get();
        return view('admin.sca', compact('itemtotenders'));
    }

    public function addsca($id)
    {
        if(count(Tender::where('id', $id)->first())<1)
        {
            return \Redirect()->back();
        }

        $itemtotenders = Tender::where('id', $id)->first();
        return view('admin.sca', compact('itemtotenders', 'id'));
    }

    public function addSCABoth(Request $request)
    {
    	$type          = $request->type;
    	$tender_id     = $request->tender;
    	$schedule_id   = $request->schedule;
    	$itemhead_id   = $request->head;
    	if($type=='I')
    	{
    		$item_id = $request->id;
    		$item = Item::select('id','name')->where('id', $item_id)->first();
    	}
    	else
    	{
			$item_id = NULL;
			$item = '';
    	}
    	$tender = Tender::select('id','tender_number')->where('id', $tender_id)->first();
    	$schedule = Schedule::select('id','schedule_name')->where('id', $schedule_id)->first();
    	$itemhead = Headitem::select('id','description')->where('id', $itemhead_id)->first();
    	
    	return view('admin.addSCABoth', compact('type', 'tender_id', 'schedule_id', 'itemhead_id', 'item_id', 'itemtotender', 'tender', 'schedule', 'itemhead', 'item'));
    }

    public function saveaddsca(Request $request)
    {
        $this->validate($request, [
            'tender_id'      		=> 'required',
            'schedule_id'           => 'required',
            'itemhead_id'    		=> 'required',
            'sca_name' 				=> 'required',
            'sca_quantity' 			=> 'required|numeric',
            'sca_rate' 				=> 'required|numeric',
            'sca_date' 				=> 'required|date',
        ]);
        $scaAdd = [
            'tender_id'             => $request->tender_id,
            'schedule_id'           => $request->schedule_id,
            'itemhead_id'           => $request->itemhead_id,
            'item_id'               => $request->item_id,
            'sca_name'              => $request->sca_name,
            'sca_quantity'          => $request->sca_quantity,
            'sca_rate'              => $request->sca_rate,
            'sca_date'              => $request->sca_date
        ];
        $scaadded = Sca::create($scaAdd);

        $sumScaRate = Sca::where('tender_id', $request->tender_id)
                        ->where('schedule_id', $request->schedule_id)
                        ->where('itemhead_id', $request->itemhead_id)
                        ->where('item_id', $request->item_id)
                        ->sum('sca_rate');
        $countScaRate = Sca::where('tender_id', $request->tender_id)
                        ->where('schedule_id', $request->schedule_id)
                        ->where('itemhead_id', $request->itemhead_id)
                        ->where('item_id', $request->item_id)
                        ->count();
        $avgRate = round(($sumScaRate / $countScaRate), 2);
        if($request->type=='I')
        {
        	$getItemtotenderDetail = Itemtotender::select('id', 'sca_qty', 'sca_rate','accepted_rate')
							->where('tender_id', $request->tender_id)
							->where('schedule_id', $request->schedule_id)
							->where('itemhead_id', $request->itemhead_id)
							->where('item_id', $request->item_id)
							->first();
			$totalQty = $request->sca_quantity + $getItemtotenderDetail->sca_qty;
            $sca_amount = round(($totalQty * $avgRate), 2);
			$accepted_sca_amount = round(($sca_amount + (($sca_amount*$getItemtotenderDetail->accepted_rate)/100)), 2);
			$updateData = [
				'sca_qty'				=> $totalQty,
				'sca_date'				=> $request->sca_date,
				'sca_rate'              => $avgRate,
				'sca_amount'			=> $sca_amount,
				'accepted_sca_amount'	=> $accepted_sca_amount
			];
			Itemtotender::where('id', $getItemtotenderDetail->id)->update($updateData);
        }
        else
        {
        	$getItemtotenderDetail = Headitem::select('id', 'sca_qty', 'sca_rate','accepted_rate')
							->where('tender_id', $request->tender_id)
							->where('schedule_id', $request->schedule_id)
							->where('id', $request->itemhead_id)
							->first();
            $totalQty = $request->sca_quantity + $getItemtotenderDetail->sca_qty;
			$sca_amount = round(($totalQty * $avgRate), 2);
			$accepted_sca_amount = round(($sca_amount + (($sca_amount*$getItemtotenderDetail->accepted_rate)/100)), 2);
			$updateData = [
				'sca_qty'				=> $totalQty,
				'sca_date'				=> $request->sca_date,
				'sca_rate'              => $avgRate,
				'sca_amount'			=> $sca_amount,
				'accepted_sca_amount'	=> $accepted_sca_amount
			];
			Headitem::where('id', $getItemtotenderDetail->id)->update($updateData);
        }
        return redirect()->back()
                        ->with('success','SCA successfully added..');
    }

    public function updateSCA(Request $request)
    {
        $sca = SCA::where('id', $request->id)->first();
        return view('admin.updateSCA', compact('sca'));
    }

    public function updatescadata(Request $request)
    {
        $this->validate($request, [
            'tender_id'             => 'required',
            'schedule_id'           => 'required',
            'itemhead_id'           => 'required',
            'sca_name'              => 'required',
            'sca_quantity'          => 'required|numeric',
            'sca_rate'              => 'required|numeric',
            'sca_date'              => 'required|date',
        ]);
        $scaupdate = [
            'sca_quantity'          => $request->sca_quantity,
            'sca_rate'              => $request->sca_rate,
            'sca_date'              => $request->sca_date
        ];
        $scaUpdated = Sca::where('id', $request->id)->update($scaupdate);
        $getSCARec = Sca::where('id', $request->id)->first();

        $sumScaQty = Sca::where('tender_id', $request->tender_id)
                        ->where('schedule_id', $request->schedule_id)
                        ->where('itemhead_id', $request->itemhead_id)
                        ->where('item_id', $request->item_id)
                        ->sum('sca_quantity');
        $sumScaRate = Sca::where('tender_id', $request->tender_id)
                        ->where('schedule_id', $request->schedule_id)
                        ->where('itemhead_id', $request->itemhead_id)
                        ->where('item_id', $request->item_id)
                        ->sum('sca_rate');
        $countScaRate = Sca::where('tender_id', $request->tender_id)
                        ->where('schedule_id', $request->schedule_id)
                        ->where('itemhead_id', $request->itemhead_id)
                        ->where('item_id', $request->item_id)
                        ->count();
        $avgRate = round(($sumScaRate / $countScaRate), 2);
        if($getSCARec->item_id!=NULL)
        {
            $getItemtotenderDetail = Itemtotender::select('id', 'sca_qty', 'sca_rate','accepted_rate')
                            ->where('tender_id', $request->tender_id)
                            ->where('schedule_id', $request->schedule_id)
                            ->where('itemhead_id', $request->itemhead_id)
                            ->where('item_id', $request->item_id)
                            ->first();
            $totalQty = $sumScaQty;
            $sca_amount = round(($totalQty * $avgRate), 2);
            $accepted_sca_amount = round(($sca_amount + (($sca_amount*$getItemtotenderDetail->accepted_rate)/100)), 2);
            $updateData = [
                'sca_qty'               => $totalQty,
                'sca_date'              => $request->sca_date,
                'sca_rate'              => $avgRate,
                'sca_amount'            => $sca_amount,
                'accepted_sca_amount'   => $accepted_sca_amount
            ];
            Itemtotender::where('id', $getItemtotenderDetail->id)->update($updateData);
        }
        else
        {
            $getItemtotenderDetail = Headitem::select('id', 'sca_qty', 'sca_rate','accepted_rate')
                            ->where('tender_id', $request->tender_id)
                            ->where('schedule_id', $request->schedule_id)
                            ->where('id', $request->itemhead_id)
                            ->first();
            $totalQty = $sumScaQty;
            $sca_amount = round(($totalQty * $avgRate), 2);
            $accepted_sca_amount = round(($sca_amount + (($sca_amount*$getItemtotenderDetail->accepted_rate)/100)), 2);
            $updateData = [
                'sca_qty'               => $totalQty,
                'sca_date'              => $request->sca_date,
                'sca_rate'              => $avgRate,
                'sca_amount'            => $sca_amount,
                'accepted_sca_amount'   => $accepted_sca_amount
            ];
            Headitem::where('id', $getItemtotenderDetail->id)->update($updateData);
        }
        
        return redirect()->back()
                        ->with('success','SCA successfully updated..');
    }

}

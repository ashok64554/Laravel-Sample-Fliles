<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tender;
use App\Schedule;
use App\Headitem;
use App\Item;
use App\Party;

class PurchaseReceive extends Model
{
    protected $fillable = [
		'tender_id', 'schedule_id', 'itemhead_id', 'item_id', 'party_id', 'item_des', 'psNumber' ,'lrNum_docketNum','dispatchDate', 'transportor', 'weight', 'freight', 'loc_from', 'loc_to','bill_num','bill_date','no_of_item','hsn_code', 'gst_per', 'item_rate', 'amount', 'taxType', 'tax1', 'tax2', 'totalAmount', 'freightAmount', 'packingAmount', 'inspectionCharge', 'miscellaneousAmount', 'grantTotalAmount' 
    ];

    public function getTender()
	{
		return $this->hasOne(Tender::class,  'id', 'tender_id');
	}

	public function getSchedule()
	{
		return $this->hasOne(Schedule::class,  'id', 'schedule_id');
	}

	public function getHeaditem()
	{
		return $this->hasOne(Headitem::class,  'id', 'itemhead_id');
	}

	public function getItem()
	{
		return $this->hasOne(Item::class,  'id', 'item_id');
	}

    public function getParty()
	{
		return $this->hasOne(Party::class,  'id', 'party_id');
	}

	public function getDispatchDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getBillDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}
}

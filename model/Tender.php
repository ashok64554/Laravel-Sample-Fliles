<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Itemtotender;
use App\Doc;
use App\Schedule;
use App\User;
use App\Company;
use App\Sca;
use App\PgBg;
use App\Expenditure;
use App\PaymentOfSuppliedItem;
use App\Ccs_master;

class Tender extends Model
{
    use SoftDeletes;
    protected $fillable = [
		'company_id','company_state','company_state_code','name_of_department', 'gstin_of_department', 'state', 'statecode', 'city', 'address', 'phoneNum1', 'phoneNum2', 'emailAddress', 'other_details_about_department', 'tender_number', 'caDate', 'loa_number', 'loaDate', 'tender_name', 'tender_type', 'information_source', 'information_source_specs', 'total_basic_value', 'bid_percentage', 'accepted_value', 'accepted_sca_value', 'date_of_open', 'date_of_work_order', 'work_order_number', 'earnest_money_amount', 'earnest_money_doc_desc', 'earnest_money_date', 'earnest_money_retrival_date', 'perfomance_gaurantee_amount', 'perfomance_gaurantee_desc', 'perfomance_gaurantee_date', 'perfomance_gaurantee_maturity_Date', 'security_deposit_amount', 'bg_Margin_Desc', 'bg_Margin_Value', 'bg_Margin_Date', 'docType', 'tender_completion', 'createdBy'
    ];
    protected $dates = ['deleted_at'];

    public function getAcceptedScaValueAttribute($value) {
	    return number_format($value, 2, '.', '');;
	}

    public function getCaDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getLoaDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getDateOfOpenAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getDateOfWorkOrderAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getEarnestMoneyDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getEarnestMoneyRetrivalDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getPerfomanceGauranteeDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getPerfomanceGauranteeMaturityDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getBgMarginDateAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

	public function getTenderCompletionAttribute($value) {
	    return \Carbon\Carbon::parse($value)->format('d-m-Y');
	}

    public function tenderDocs()
	{
		return $this->hasMany(Doc::class,  'tender_id', 'id');
	}

	public function tenderSchedule()
	{
		return $this->hasMany(Schedule::class,  'tender_id', 'id');
	}

	public function tenderUser()
	{
		return $this->hasOne(User::class,  'id', 'createdBy');
	}

	public function tenderCompany()
	{
		return $this->hasOne(Company::class,  'id', 'company_id');
	}

	public function getItemsITDs()
	{
		return $this->hasMany(Itemtotender::class,  'tender_id', 'id');
	}

	public function pgbgs()
	{
		return $this->hasMany(PgBg::class,  'tender_id', 'id');
	}

	public function expenditureLists()
	{
		return $this->hasMany(Expenditure::class,  'tender_id', 'id');
	}

	public function POSList()
	{
		return $this->hasMany(PaymentOfSuppliedItem::class,  'tender_id', 'id');
	}

	public function ccLists()
	{
	    return $this->hasMany(Ccs_master::class, 'tender_id', 'id');
	}
}

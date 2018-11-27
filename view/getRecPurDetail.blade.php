<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
	<h4 class="modal-title" id="myModalLabel">CA Number : {{$recPurItem->getTender->tender_number}} </h4>
</div>
<div class="modal-body">
	<table class="table table-bordered table-hover table-striped display">
		<thead>
			<tr>
				<th width="15%">Tender No.</th>
				<td width="35%">{{$recPurItem->getTender->tender_number}}</td>
				<th width="15%">Schdule Name</th>
				<td width="35%">{{$recPurItem->getSchedule->schedule_name}}</td>
			</tr>
			<tr>
				<th>Item Head</th>
				<td>{{$recPurItem->getHeaditem->description}}</td>
				<th>Item</th>
				<td>{{$recPurItem->getItem->name}}</td>
			</tr>
			
			<tr>
				<th>Party</th>
				<td>{{$recPurItem->getParty->name}}</td>
				<th>L. R. No / DOCKET No</th>
				<td>{{$recPurItem->lrNum_docketNum}}</td>
			</tr>
			<tr>
				<th>Item Description</th>
				<td colspan="3">{{$recPurItem->item_des}}</td>
			</tr>
			<tr>
				<th>DISPATCH DATE</th>
				<td>{{$recPurItem->dispatchDate}}</td>
				<th>TRANSPORTOR</th>
				<td>{{$recPurItem->transportor}}</td>
			</tr>
			<tr>
				<th>WEIGHT</th>
				<td>{{$recPurItem->weight}}</td>
				<th>FREIGHT</th>
				<td>{{$recPurItem->freight}}</td>
			</tr>
			<tr>
				<th>SEND FROM</th>
				<td>{{$recPurItem->loc_from}}</td>
				<th>SEND TO</th>
				<td>{{$recPurItem->loc_to}}</td>
			</tr>
			<tr>
				<th>BILL NO</th>
				<td>{{$recPurItem->bill_num}}</td>
				<th>BILL DATE</th>
				<td>{{$recPurItem->bill_date}}</td>
			</tr>
			<tr>
				<th>HSN CODE</th>
				<td>{{$recPurItem->hsn_code}}</td>
				<th>NO OF ITEMS SENT</th>
				<td>{{$recPurItem->no_of_item}}</td>
			</tr>
			<tr>
				<th>RATE</th>
				<td>{{$recPurItem->item_rate}}</td>
				<th>AMOUNT</th>
				<td>{{$recPurItem->amount}}</td>
			</tr>
			<tr>
				<th>GST PERCENTAGE</th>
				<td>{{$recPurItem->gst_per}}</td>
				<th>TAX TYPE</th>
				<td>{{$recPurItem->taxType}}</td>
			</tr>
			<tr>
				<th>CGST / IGST</th>
				<td>{{$recPurItem->tax1}}</td>
				<th>SGST</th>
				<td>{{$recPurItem->tax2}}</td>
			</tr>
			<tr>
				<th>TOTAL AMOUNT</th>
				<td>{{$recPurItem->totalAmount}}</td>
				<th>FREIGHT AMOUNT</th>
				<td>{{$recPurItem->freightAmount}}</td>
			</tr>
			<tr>
				<th>PACKING AMOUNT</th>
				<td>{{$recPurItem->packingAmount}}</td>
				<th>MISCELLANEOUS AMOUNT</th>
				<td>{{$recPurItem->miscellaneousAmount}}</td>
			</tr>
			<tr>
				<th>INSPECTION CHARGE</th>
				<td>{{$recPurItem->inspectionCharge}}</td>
				<th>GRANT TOTAL AMOUNT</th>
				<td>{{$recPurItem->grantTotalAmount}}</td>
			</tr>
		</thead>		
	</table>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>
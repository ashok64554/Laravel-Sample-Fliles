			@extends('layouts.masters')
			@section('content')
			<div class="main-content">
				@if(Session::has('success'))
				<div class="alert alert-success login-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {!! Session::get('success') !!} </div>
				@endif

				@if(Session::has('error'))
				<div class="alert alert-danger login-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {!! Session::get('error') !!} </div>
				@endif

				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
		       
 @if(Request::segment(2)==='edit-challan' || Request::segment(2)==='add-create-challan')
			@if(Request::segment(2)==='add-create-challan')
			<?php
		 
			$id 			        = '';
			$tender_id 	   			= '';
			$schedule_id 			= '';
			$itemhead_id 			= '';
			$order_no 				= '';
			$date_of_challan 		= '';
			$dispatch_details 		= '';
			$challan_number 		= '';
			$place_of_supply 		= '';
			?>
			@else
			<?php
			$id 					= $data->id;
			$tender_id 	   		    = $data->tender_id;
			$schedule_id 			= $data->schedule_id;
			$itemhead_id 			= $data->itemhead_id;
			$order_no 				= $data->order_no;
			$date_of_challan 		= $data->date_of_challan;
		    $dispatch_details 		= $data->dispatch_details;
		    $challan_number 		= $data->challan_number;
		    $place_of_supply 		= $data->place_of_supply;
			?>

			@endif
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-piluku">
							<div class="panel-heading">
								<h3 class="panel-title">
								@if(Request::segment(2)==='add-create-challan')
								Add Challan
								@elseif(Request::segment(2)==='edit-challan')
								Edit Challan
								@else
								Challan
								@endif
									
									<span class="panel-options">
										<a href="#" class="panel-minimize" data-original-title="" title="">
											<i class="icon ti-angle-up"></i> 
										</a>
									</span>
								</h3>
							</div>


							<div class="panel-body">
								<div class="panel-body">
									{{ Form::open(array('route' => 'save-challan', 'class'=> 'form-horizontal')) }}
									{{ Form::token() }}
									{!! Form::hidden('id',$id,array('class'=>'form-control')) !!}
									<div class="form-group">
										<div class="col-md-4">
											<label class="control-label">C.A. Number / Name</label>
											<select name="tender_id" id="tender_id" class="form-control" required="" onchange="getChallanSchList(this.value)">
												<option value="" disabled="" selected="">-- Select Tender --</option>
												@foreach($tenders as $tender)
													<option value="{{$tender->id}}">{{$tender->tender_number}} / {{$tender->tender_name}}</option>
												@endforeach
											</select>

										</div>
										<div id="scheduleDiv">
											<div class="col-md-4">
												<label class="control-label">Schedule Name</label>
													<select name="schedule_id" id="schedule_id" class="form-control" required="" onchange="getChallanItemHeadList(this.value)">
													<option value="" disabled="" selected="">-- Select Schedule --</option>
												</select>
											</div>
										</div>

										<div id="itemHeadDiv">
											<div class="col-md-4">
												<label class="control-label">Item Head</label>
												<select name="itemhead_id" id="itemhead_id" class="form-control" required="" onchange="getChallanItemListPur(this.value)">
													<option value="" disabled="" selected="">-- Select Item Head --</option>
												</select>
											</div>
										</div>

										<div id="itemsDiv">
										</div>
									</div>

									<div class="form-group">
												<div class="col-md-4">
													<label class="control-label">Order Number</label>
													{!! Form::text('order_no','',array('class'=>'form-control', 'placeholder'=>'Order Number', 'id'=>'order_no','required')) !!}
												</div>
												<div class="col-md-4">
													<label class="control-label">Date Of Challan</label>
													{!! Form::date('date_of_challan','',array('class'=>'form-control', 'placeholder'=>'Date Of Challan', 'id'=>'date_of_challan', 'required')) !!}
												</div>
												<div class="col-md-4">
													<label class="control-label">Dispatch Details</label>
													{!! Form::text('dispatch_details','',array('class'=>'form-control', 'placeholder'=>'Dispatch Details', 'id'=>'dispatch_details', 'required')) !!}
												</div>
											</div>

											<div class="form-group">
												<div class="col-md-4">
													<label class="control-label">Challan Number</label>
													{!! Form::text('challan_number','',array('class'=>'form-control', 'placeholder'=>'Challan Number', 'id'=>'challan_number', 'required')) !!}
												</div>
												<div class="col-md-4">
													<label class="control-label">Place Of Supply</label>
													{!! Form::text('place_of_supply','',array('class'=>'form-control', 'placeholder'=>'Place Of Supply', 'id'=>'place_of_supply')) !!}
												</div>
											</div>

									<hr>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="col-md-6"> {!! Form::submit('Submit', array('class'=>'btn btn-primary pull-right', 'id'=>'submitBtn')) !!} </div>
											</div>
										</div>
									</div>
									{{ Form::close() }}
								</div>
							</div>
						</div>
					</div>
				</div>

		    
			</div>
			@elseif(Request::segment(2)==='create-challan-detail')

			<div class="row">
					<div class="col-md-12">
						<div class="panel panel-piluku">
							<div class="panel-heading">
								<h3 class="panel-title">
									Challan Detail
									<span class="panel-options">
										<a href="#" class="panel-minimize" data-original-title="" title="">
											<i class="icon ti-angle-up"></i> 
										</a>
									</span>
								</h3>
							</div>

							<div class="panel-body">
								<table class="table table-bordered table-hovered">
									<thead>
										<tr>
											<th colspan="4"><strong class="text-danger text-center">Tender Information</strong></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="25%"><strong>Name Of Company</strong></td>
											<td><strong>{!! $itemtotenders->tenderCompany->name !!}</strong></td>
											<td width="25%"><strong>GSTIN</strong></td>
											<td><strong>{!! $itemtotenders->tenderCompany->gstin !!}</strong></td>
										</tr>
										<tr>
											<td><strong>State (Code)</strong></td>
											<td>
												<strong>{!! $itemtotenders->tenderCompany->state !!}
													<span class="badge badge-danger">{!! $itemtotenders->tenderCompany->statecode !!}</span></strong>
												</td>
												<td><strong>City</strong></td>
												<td><strong>{!! $itemtotenders->tenderCompany->city !!}</strong></td>
											</tr>
											<tr>
												<td>Name Of Department</td>
												<td>{!! $itemtotenders->name_of_department !!}</td>
												<td>GSTIN Of Department</td>
												<td>{!! $itemtotenders->gstin_of_department !!}</td>
											</tr>
											<tr>
												<td>State</td>
												<td>{!! $itemtotenders->state !!}</td>
												<td>State Code</td>
												<td>{!! $itemtotenders->statecode !!}</td>
											</tr>
											<tr>
												<td>City</td>
												<td>{!! $itemtotenders->city !!}</td>
												<td>Address</td>
												<td>{!! $itemtotenders->address !!}</td>
											</tr>
											<tr>
												<td>Phone Number</td>
												<td>{!! $itemtotenders->phoneNum1 !!} @if(!empty($itemtotenders->phoneNum2)), {!! $itemtotenders->phoneNum2 !!} @endif</td>
												<td>Email Address</td>
												<td>{!! $itemtotenders->emailAddress !!}</td>
											</tr>
											<tr>
												<td>Date Of Open</td>
												<td colspan="3">{!! $itemtotenders->date_of_open !!}</td>
											</tr>
											<tr>
												<th><strong>CA Number</strong></th>
												<td><strong>{!! $itemtotenders->tender_number !!}</strong></td>
												<th><strong>CA Date</strong></th>
												<td><strong>{!! $itemtotenders->caDate !!}</strong></td>
											</tr>
											<tr>
												<th><strong>LOA Number</strong></th>
												<td><strong>{!! $itemtotenders->loa_number !!}</strong></td>
												<th><strong>LOA Date</strong></th>
												<td><strong>{!! $itemtotenders->loaDate !!}</strong></td>
											</tr>
											<tr>
												<td>Tender Name</td>
												<td>{!! $itemtotenders->tender_name !!}</td>
												<td>Tender Type</td>
												<td>{!! $itemtotenders->tender_type !!}</td>
											</tr>
											<tr>
												<td>Total Basic Value</td>
												<td>{!! $itemtotenders->total_basic_value !!}</td>
												<td>Bid Percentage</td>
												<td>{!! $itemtotenders->bid_percentage !!}</td>
											</tr>
											<tr>
												<td>Accepted Value</td>
												<td>{!! $itemtotenders->accepted_value !!}</td>
												<td>Accepted Sca Value</td>
												<td>{!! $itemtotenders->accepted_sca_value !!}</td>
											</tr>
										</tbody>
									</table>


									<div class="panel-group piluku-accordion" id="accordion" role="tablist" aria-multiselectable="true">
										<?php $schC = 1; $schHead = 5555; ?>
										@foreach($itemtotenders->tenderSchedule as $tenderScheduleList)
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="heading{{$schC}}">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$schC}}" aria-expanded="true" aria-controls="collapse{{$schC}}">
														Schedule Name : <strong class="text-danger">{{$tenderScheduleList->schedule_name}}</strong>
													</a>
												</h4>
											</div>
											<div id="collapse{{$schC}}" class="panel-collapse collapse @if($schC==1) in @endif" role="tabpanel" aria-labelledby="heading{{$schC}}">
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-bordered table-hovered innerTable1">
															<thead>
																<tr>
																	<th>Schedule Name</th>
																	<th>Basic Rate</th>
																	<th>Bid Percentage</th>
																	<th>Accepted Value</th>
																	<th>Accepted Sca Value</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>{{$tenderScheduleList->schedule_name}}</td>
																	<td>{{$tenderScheduleList->sch_basic_rate}}</td>
																	<td>{{$tenderScheduleList->sch_bid_percentage}}</td>
																	<td>{{$tenderScheduleList->sch_accepted_value}}</td>
																	<td>{{$tenderScheduleList->sch_accepted_sca_value}}</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<?php $count = 1; $countH = 1; ?>
												<div class="panel-body">
													<div class="panel-group piluku-accordion piluku-accordion-two" id="accordionOne{{$schC}}" role="tablist" aria-multiselectable="true">
														@forelse($tenderScheduleList->schHeaditem as $itemhead)

														<div class="panel panel-default">
															<div class="panel-heading" role="tab" id="headingModalOne{!!$schHead!!}">
																<h4 class="panel-title">
																	<a class="collapsed" data-toggle="collapse" data-parent="#accordionOne{{$schC}}" href="#collapseModalOne{!!$schHead!!}" aria-expanded="true" aria-controls="collapseOne{!!$schHead!!}">
																		#{!!$countH!!} Item Head List : <span class="text-warning"><strong>{!!$itemhead->description!!}</strong></span>
																	</a>
																</h4>
															</div>
															<div id="collapseModalOne{!!$schHead!!}" class="panel-collapse collapse  @if($schHead==5555) in @endif" role="tabpanel" aria-labelledby="headingOne{!!$schHead!!}">
																<div class="table-responsive">
																	<table class="table table-bordered table-hovered innerTable2">
																		<thead>
																			<tr>
																				<th>Quantity</th>
																				<th>Sca Quantity</th>
																				<th>Inspection Authority</th>
																				<th>Basic Rate</th>
																				<th>Basic Amount</th>
																				<th>Sca Amount</th>
																				<th>Accepted Rate(%)</th>
																				<th>Accepted Amount</th>
																				<th>Accepted Sca Amount</th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td>{!!$itemhead->qty!!}</td>
																				<td>{!!$itemhead->sca_qty!!}</td>
																				<td>{!!$itemhead->inspection_authority!!}</td>
																				<td>{!!$itemhead->basic_rate!!}</td>
																				<td>{!!$itemhead->basic_amount!!}</td>
																				<td>{!!$itemhead->sca_amount!!}</td>
																				<td>{!!$itemhead->accepted_rate!!}</td>
																				<td>{!!$itemhead->accepted_amount!!}</td>
																				<td>{!!$itemhead->accepted_sca_amount!!}</td>
																			</tr>
																			<tr>
																				<td colspan="11">
																					<div class="table-responsive">
																						<table class="table table-bordered table-hovered innerTable4">
																							<thead>
																								<tr>
																									<th colspan="8"><strong class="text-primary text-center">Challan List</strong> </th>
																								</tr>
																								<tr>
																									<th>#</th>
																									<th>Order Number</th>
																									<th>Date Of Challan</th>
																									<th>Dispatch Details</th>
																									<th>Challan Number</th>
																									<th>Place Of Supply</th>
																									<th>Inspection Authority Call Letter No.</th>
																									<th>Inspection Authority Call Letter No. Date</th>
																								</tr>
																							</thead>
																							<?php $count = 1;
																							$challans  = App\Challan::where('tender_id', $itemtotenders->id)
																											->where('schedule_id', $tenderScheduleList->id)
																											->where('itemhead_id', $itemhead->id)
																											->groupBy('challan_number')
																											->get();
																							?>
																							@forelse($challans as $challan)
																							<tr>
																								<td>{{ ++$count }}</td>
																								<td>{{$challan->order_no}}</td>
																								<td>{{$challan->date_of_challan}}</td>
																								<td>{{$challan->dispatch_details}}</td>
																								<td>{{$challan->challan_number}}</td>
																								<td>{{$challan->place_of_supply}}</td>
																								<td>{{$challan->inspection_authority_call_letter_number}}</td>
																								<td>{{$challan->inspection_authority_call_letter_number_date}}</td>							
																							</tr>
																							<tr>
																								<td colspan="11">
																									<table class="table table-bordered innerTable1">
																										<thead>
																											<tr>
																												<th>Item Name</th>
																												<th class="text-center" width="15%">Item Qty</th>
																												<th class="text-center" width="15%">Item Send Qty</th>
																											</tr>
																										</thead>
																										<tbody>
																										<?php
																										$getChallanQtys = App\Challan::where('challan_number', $challan->challan_number)->get();
																										?>
																										@foreach($getChallanQtys as $getChallanQty)
																										<?php
																										$getItemQty = App\Itemtotender::select('qty', 'sca_qty')->where('itemhead_id', $getChallanQty->itemhead_id)
																														->where('item_id', $getChallanQty->item_id)
																									                	->first();
																										?>
																											@if(count($getItemQty)>0)
																											<tr>
																												<td>
																													@if($getChallanQty->item_id!=NULL)
																														{{$getChallanQty->getItem->name}}
																													@else
																													<strong class="text-danger">Item Head Select And No Items Found in this itemhead..</strong>
																													@endif
																												</td>
																												<td class="text-center">
																													@if($getChallanQty->item_id!=NULL)
																														<span class="badge bg-danger">{{$getItemQty->sca_qty}}</span>
																													@else
																														<strong class="text-danger">----</strong>
																													@endif
																												</td>
																												<td class="text-center">
																													<span class="badge bg-primary">{{$getChallanQty->itemQty}}</span>
																												</td>
																											</tr>
																											@endif
																										@endforeach
																										</tbody>
																									</table>
																								</td>
																							</tr>
																							@empty
																							<tr>
																								<td colspan="8">
																									<div class="alert alert-info">
																										<strong>Info !</strong> No Challan Found...
																									</div>
																								</td>
																							</tr>
																							@endforelse

																						</table>
																					</div>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>

														<?php $count++; $countH++; $schHead++;?>
														@empty
														<div class="alert alert-info">
															<strong>Info !</strong> No Items Head Found...
														</div>
														@endforelse
													</div>
												</div>
											</div>
										</div>
										<?php $schC++; ?>
										@endforeach
									</div>



								</div>
							</div>
						</div>
					</div>


			@else

			<div class="row">
				<div class="col-md-12">
					<a href="{{route('make-challan')}}" class="btn btn-primary">
						Add Challan
					</a>
					<br><br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-piluku">
						<div class="panel-heading">
							<h3 class="panel-title">
								List Challan
								<span class="panel-options">
									<a href="#" class="panel-minimize" data-original-title="" title="">
										<i class="icon ti-angle-up"></i> 
									</a>
								</span>
							</h3>
						</div>
						<div class="panel-body">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped display" id="example">
										<thead>
											<tr>
												<th>#</th>
												<th>Tender Name</th>
												<th>CA Number</th>
												<th>Name of dept</th>
												<th>State</th>
												<th>Total basic value</th>
												<th class="text-center" width="12%">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $count = 0;?>
											@foreach($challans as $challan)
											<tr>
												<td>{{ ++$count }}</td>
												<td>{{$challan->getTender->tender_name}}</td>
												<td>{{$challan->getTender->tender_number}}</td>
												<td>{{$challan->getTender->name_of_department}}</td>
												<td>{{$challan->getTender->state}}</td>
												<td>{{$challan->getTender->accepted_sca_value}}</td>
												<td class="text-center">
													<div class="btn-group btn-group-xs">
														<a href="{{ route('create-challan-detail',['id'=>$challan->id]) }}" class="btn btn-orange btn-icon-primary tooltips" data-placement="top" title="Challan Details"><i class="fa fa-list"></i></a>
														<a href="{{ route('edit-challan',['id'=>$challan->id]) }}" class="btn btn-orange btn-icon-primary tooltips" data-placement="top" title="Challan Details"><i class="fa fa-pencil"></i></a>
													</div>
												</td>						
											</tr>
											@endforeach
										</tbody>
										
									</table>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif

			@endsection
			@section('extrajs')
			<script type="text/javascript">
				$(document).ready(function () {
					$('form').each(function () {
						$(this).validate({
							rules: {
								tender_id         		: 'required',
					            schedule_id       		: 'required',
					            itemhead_id       		: 'required',
					            party_id          		: 'required',
					            order_no   				: 'required',
					            date_of_challan      	: 'required',
					            dispatch_details       	: 'required',
					            challan_number          : 'required',
					            itemQty          		: 'required'
							},
							messages: {
								tender_id         		: '',
					            schedule_id       		: '',
					            itemhead_id       		: '',
					            party_id          		: '',
					            order_no   				: '',
					            date_of_challan      	: '',
					            dispatch_details       	: '',
					            challan_number          : '',
					            itemQty          		: ''
					        },
							submitHandler: function(form) {
								form.submit();
							}
						});
					});
				});
			</script>
			@endsection
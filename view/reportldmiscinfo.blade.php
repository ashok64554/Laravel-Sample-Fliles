@extends('layouts.masters')
@section('content')
<div class="main-content">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-piluku">
				<div class="panel-heading">
					<h3 class="panel-title">
						LD. MISC payment Report
						<span class="panel-options">
							<a href="#" class="panel-minimize" data-original-title="" title="">
								<i class="icon ti-angle-up"></i> 
							</a>
						</span>
					</h3>
				</div>


				<div class="panel-body">
					<div class="form-group">
						<div class="col-md-12">
							<label class="control-label">Tender Name</label>
							<select name="tender_id" id="tender_id" class="form-control" required="" onchange="reportGetLdMiscwise(this.value)">
								<option value="" disabled="" selected="">-- Select Tender --</option>
								@foreach($tenders as $tender)
									<option value="{{$tender->id}}">{{$tender->tender_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="text-center loading" style="display: none;"> <img src="{{url('/')}}/assets/img/ajax-loader.gif"></div>
			<div id="challanDiv"></div>
		</div>
	</div>
	@endsection
	@section('extrajs')
	@endsection
<?php
  $web_setting = App\Websitesetting::first();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
	<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon.ico') }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon.ico') }}">
	<title>{{$web_setting->website_name}}</title> 
	{!! Html::style('assets/admin/css/bootstrap.min.css') !!}
	{!! Html::style('assets/admin/css/material.css') !!}
	{!! Html::style('assets/admin/css/style.css') !!}
	{!! Html::style('assets/admin/css/signin2.css') !!}
</head>

<body >
	<div class="flip-container">
		<div class="flipper">
			<div class="front">
				<!-- front content -->
				<div class="holder">
					{!! Form::open(array('url' => 'login', 'class'=> 'form-signin')) !!}
					<h1 class="heading">{{$web_setting->website_name}}</h1>

					@if(Session::has('error'))
					<div class="alert-box success">
						<h2>{{ Session::get('error') }}</h2>
					</div>
					@endif

					{!! Form::text('email', '' , array('class'=>'form-control', 'placeholder'=>'Username')) !!}
					<p class="errors" style="color:red;">{{$errors->first('email')}}</p>
					{!! Form::text('password', '' , array('class'=>'form-control', 'placeholder'=>'Password')) !!}					
					<p class="errors" style="color:red;">{{$errors->first('password')}}</p>							
					<div class="bottom_info">
						<a href="{{url('/')}}/forgotPassword" class="pull-right">{{Lang::get('Admin.forgetPassword')}}</a>
						
					</div>		
					<div class="clearfix"></div>
					{!! Form::submit('Sign in',array('class'=>'btn btn-primary btn-block')) !!}
					
					{!! Form::close() !!}					
				</div>
			</div>			
		</div>		
	</div>
	{!! Html::script('assets/admin/js/jquery.js') !!}
	{!! Html::script('assets/admin/js/bootstrap.min.js') !!}
</body>

</html>
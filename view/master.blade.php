<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <base href="/">
    
    
  <!-- Favicons-->
  <link rel="shortcut icon" href="{{ asset('assets/images/soccer/favicons/favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/no-image-user.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/soccer/favicons/favicon-152.png') }}">

  <!-- Mobile Specific Metas-->
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

  <!-- Google Web Fonts-->
  
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CSource+Sans+Pro:400,700" rel="stylesheet">
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>
  
  <link href="{{ mix('css/all.css') }}" rel="stylesheet">

<body id="content-3">
<div class="site-wrapper clearfix">

<div>
  @yield('content')
</div>

</div>

@yield('extrajs')

<script type="text/javascript" src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ mix('js/all.js') }}"></script>

</body>
</html>


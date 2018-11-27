<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon.ico') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon.ico') }}">

<title>{{$web_setting->website_name}}</title>
<meta name="_token" content="{{ csrf_token() }}">
{!! Html::style('assets/admin/css/bootstrap.min.css') !!}
{!! Html::style('assets/admin/css/material.css') !!}
{!! Html::style('assets/admin/css/style.css') !!}
{!! Html::style('assets/admin/js/bootstrap-fileupload/bootstrap-fileupload.css') !!}
{!! Html::style('assets/admin/css/signup.css') !!}
{!! Html::style('assets/admin/css/custom.css') !!}
{!! Html::script('assets/admin/js/jquery.js') !!}
{!! Html::script('assets/admin/js/app.js') !!}
  <script>
    jQuery(window).load(function () {
      $('.piluku-preloader').addClass('hidden');
    });

    setIdleTimeout(<?= $logout_time; ?>, function() {
    window.location.href = '<?= URL::to('/admin/screenlock'); ?>/<?= time();?>/<?= $email = Auth::user()->id; ?>/<?= MD5(str_random(10)) ?>';
    }, function() {});
    
    function setIdleTimeout(millis, onIdle, onUnidle) {
        var timeout = 0;
        $(startTimer);

    function startTimer() {
        timeout = setTimeout(onExpires, millis);
        $(document).on("mousemove keypress", onActivity);
    }
    
    function onExpires() {
        timeout = 0;
        onIdle();
    }

    function onActivity() {
        if (timeout) clearTimeout(timeout);
        else onUnidle();
        $(document).off("mousemove keypress", onActivity);
        setTimeout(startTimer, 1000);
    }
}

function checkAll(source) {
    checkboxes = document.getElementsByName('boxchecked[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
  function delrec(typ)
  {
    if(typ!="")
    {
      var prod;
      prod=false;
      prod=window.confirm("Are you sure you want to "+ typ +" selected Records?")
      if (prod==true)
      {
        var checkedCount = $("input[type=checkbox][name^=boxchecked]:checked").length;
        if (checkedCount == 0) {
          alert ("You must check atleast one checkbox!");
          return false;
        }
        return true;
        submitbutton('remove')
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false; 
    }
  }

</script>





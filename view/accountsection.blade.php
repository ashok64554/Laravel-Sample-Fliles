@extends('layouts.masters')
@section('content')
<div class="main-content">
  <div class="row">
    <div class="col-md-12">
      
      @if(Session::has('message'))
      <div class="alert alert-warning login-alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {!! Session::get('message') !!} </div>
      @endif
      
      <div class="panel panel-piluku">
        <div class="panel-heading">
          <h3 class="panel-title">
            {{Lang::get('Admin.websitesetting')}}
            <span class="panel-options">
              <a href="#" class="panel-minimize">
                <i class="icon ti-angle-up"></i> 
              </a>
            </span>
          </h3>
        </div>
        <div class="panel-body">
          {!! Form::open(array('url' => 'admin/websitesettingupdate', 'class'=> 'form form-horizontal','enctype'=>'multipart/form-data', 'files'=>true)) !!}
          {!! Form::token() !!}
          {!! Form::hidden('old_logo',$websitesetting->website_logo,array('id'=>'id','class'=>'form-control')) !!}
          <div class="panel-body">
            
            <div class="form-group">
              <label for="email" class="col-lg-3 control-label">{{Lang::get('Admin.ws_website_name')}}</label>
              <div class="col-md-9">
                <div>
                  {!! Form::text('website_name',$websitesetting->website_name,array('id'=>'website_name','class'=>'form-control', 'placeholder'=>Lang::get('Admin.ws_website_name'), 'autocomplete'=>'off')) !!}
                </div>
                @if($errors->first('website_name')!='')
                <code>{{ $errors->first('website_name') }}</code>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-lg-3 control-label">{{Lang::get('Admin.ws_website_logo')}}</label>
              <div class="col-md-9">
                <div>
                  {!! Form::file('website_logo',array('id'=>'website_logo','class'=>'filestyle','data-icon'=>'false')) !!}
                </div>
                @if($errors->first('website_logo')!='')
                <code>{{ $errors->first('website_logo') }}</code>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-lg-3 control-label"></label>
              <div class="col-md-9">
                <img src="{{url('/assets/img/')}}/{!! $websitesetting->website_logo !!}" height="100px" class="img-responsive">
              </div>
            </div>

            <div class="form-group">
              <label for="pasoldpasswordsword" class="col-lg-3 control-label">{{Lang::get('Admin.ws_locktimeout')}}</label>
              <div class="col-md-9">
                <div>
                  {!! Form::number('locktimeout',$websitesetting->locktimeout,array('id'=>'locktimeout','class'=>'form-control', 'placeholder'=>Lang::get('Admin.ws_locktimeout'), 'autocomplete'=>'off')) !!}
                </div>
                @if($errors->first('locktimeout')!='')
                <code>{{ $errors->first('locktimeout') }}</code>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="col-lg-3 control-label">{{Lang::get('Admin.ws_address')}}</label>
              <div class="col-md-9">
                <div>
                  {!! Form::text('address',$websitesetting->address,array('id'=>'address','class'=>'form-control', 'placeholder'=>Lang::get('Admin.ws_address'), 'autocomplete'=>'off')) !!}
                </div>
                @if($errors->first('address')!='')
                <code>{{ $errors->first('address') }}</code>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="col-lg-3 control-label">{{Lang::get('Admin.ws_mobilenum')}}</label>
              <div class="col-md-9">
                <div>
                  {!! Form::number('mobilenum',$websitesetting->mobilenum,array('id'=>'mobilenum','class'=>'form-control', 'placeholder'=>Lang::get('Admin.ws_mobilenum'), 'autocomplete'=>'off')) !!}
                </div>
                @if($errors->first('mobilenum')!='')
                <code>{{ $errors->first('mobilenum') }}</code>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="url" class="col-lg-3 control-label">{{Lang::get('Admin.joinOurPageLink')}}</label>
              <div class="col-md-9">
                <div>
                  {!! Form::url('url',$websitesetting->url,array('id'=>'url','class'=>'form-control', 'placeholder'=>Lang::get('Admin.joinOurPageLink'), 'autocomplete'=>'off')) !!}
                </div>
                @if($errors->first('url')!='')
                <code>{{ $errors->first('url') }}</code>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="email" class="col-lg-3 control-label">{{Lang::get('Admin.contactEmail')}}</label>
              <div class="col-md-9">
                <div>
                  {!! Form::email('email',$websitesetting->email,array('id'=>'email','class'=>'form-control', 'placeholder'=>Lang::get('Admin.ws_mobilenum'), 'autocomplete'=>'off')) !!}
                </div>
                @if($errors->first('email')!='')
                <code>{{ $errors->first('email') }}</code>
                @endif
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6">
                {!! Form::submit(Lang::get('Admin.updateBtn'), array('class'=>'btn btn-primary pull-right')) !!}
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>

    </div>
  </div>
  @endsection
  @section('extrajs')
  
  @endsection
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<head>
		<meta charset="utf-8"/>
		<title>Administrator Locked</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta content="" name="description"/>
		<meta content="" name="author"/>
		<link href="{{$basesite}}assets/backend/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/pages/css/lock.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/css/plugins.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
		<link href="{{$basesite}}assets/backend/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="{{$basesite}}assets/backend/images/{{$config['logo']['icon']}}?{{uniqid()}}"/>
	</head>
	<body class="login">
	<div class="menu-toggler sidebar-toggler">
	</div>
	<div class="logo" style="margin-top: @if(isset($config['backend']['lang'])) 30px @else 60px @endif !important;">
		<a href="{{$basesite}}{{$config['backend']['aliaspage']}}">
		<img class="logo-default" src="{{$basesite}}assets/backend/admin/layout/img/{{$config['logo']['big']['png']}}?{{uniqid()}}" alt="" width="250px"/>
		</a>
	</div>
	<div class="content">
		<h3 class="form-title">{{$inv->_trans('backend.lock.headerlock')}}</h3>
		<div class="pull-left lock-avatar-block">
			<img src="{{$basesite}}assets/backend/images/userdetail/small_{{$vimage}}?{{uniqid()}}" class="lock-avatar" width="110px;" height="110px;">
		</div>
		<form class="login-form pull-left" method="post" style="padding-left: 30px;">
			<h4>{{$vname}}</h4>
			<div class="form-group">
				<div class="@if ($errorvpassword != '') has-error @endif">
					<input type="password" class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{$inv->_trans('backend.lock.pass')}}" name="vpassword" value="{{$vpassword}}">
					<span class="help-block">{{$errorvpassword}}</span>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-success uppercase" style="width: 200px !important;">{{$inv->_trans('backend.lock.buttonlogin')}}</button>
			</div>
		</form>
		<div class="form-actions" style="text-align: center; font-size: 14px !important; padding-top: 0px !important; margin-bottom: -25px;">
			<a href="{{$basesite}}{{$config['backend']['aliaspage']}}logout" class="hover">{{$inv->_trans('backend.lock.noteaccess', [ 'name' => $vname ])}}</a>
		</div>
	</div>
	<div class="copyright loginfooter">
		Admin Dashboard<br/>{{$config['project']['name']}}<br/><br/>
@if(isset($config['backend']['lang']))
	@foreach($config['backend']['lang'] as $obj)
		@if($lang['backend']['link'] == $obj['link'])
			@php $buttoncolor = "grey-cascade" @endphp
		@else
			@php $buttoncolor = "blue" @endphp
		@endif
		@if($obj['link'] == $config['backend']['lang'][0]['link'])
			@php $obj['link'] = "" @endphp
		@else
			@php $obj['link'] = $obj['link']."/" @endphp
		@endif
		<a class="btn btn-sm {{$buttoncolor}}" href="@if($buttoncolor=="grey-cascade") javascript:; @else {{$realbasesite}}{{$obj['link']}}{{$config['backend']['aliaspage']}} @endif">
		<img src="{{$basesite}}assets/backend/global/img/flags/{{$obj['flag']}}">
		{{$obj['name']}}</a>
	@endforeach
@endif
	</div>
	<!--[if lt IE 9]>
	<script src="{{$basesite}}assets/backend/global/plugins/respond.min.js"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/excanvas.min.js"></script> 
	<![endif]-->
	<script src="{{$basesite}}assets/backend/global/plugins/jquery.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/scripts/metronic.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/admin/layout/scripts/demo.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/admin/layout/scripts/layout.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function() {    
			Metronic.init();
			Layout.init();
			Demo.init();
		});
	</script>
	</body>
</html>
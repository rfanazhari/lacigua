<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<head>
		<meta charset="utf-8"/>
		<title>Administrator Login</title>
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
	<div class="logo" style="margin-top: 60px !important;">
		<a href="{{$basesite}}{{$config['backend']['aliaspage']}}">
		<img class="logo-default" src="{{$basesite}}assets/backend/admin/layout/img/{{$config['logo']['big']['png']}}?{{uniqid()}}" alt="" width="250px"/>
		</a>
	</div>
	<div class="content">
		<input id="checkform" class="display-hide" value="{{$checkform}}">
		<form class="login-form" action="{{$basesite}}{{$config['backend']['aliaspage']}}" method="post">
			{{ csrf_field() }}
			<h3 class="form-title">Login Administrator</h3>
			@if ($errormsg != '')
			<div class="alert alert-danger" style="display: block;">
				<button class="close" data-close="alert"></button>
				<span id='error'>{{$errormsg}}</span>
			</div>
			@endif
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">Username</label>
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" value="{{$username}}"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" value="{{$password}}"/>
				</div>
			</div>
			
			<div class="form-actions">
				<button type="submit" class="btn btn-success uppercase">Login</button>
				<label class="rememberme check hover">
				<input type="checkbox" name="remember" class="hover" value="1" @if ($remember != '') checked @endif />Remember
				</label>
				<a href="javascript:;" id="forget-password" class="forget-password hover">Forgot Password?</a>
			</div>
		</form>
		<form class="forget-form" action="{{$basesite}}{{$config['backend']['aliaspage']}}" method="post">
			{{ csrf_field() }}
			<h3 class="form-title">Forget Password?</h3>
			<div class="alert alert-danger display-hide" @if ($errorforget != '') style="display: block;" @endif >
				<button class="close" data-close="alert"></button>
				<span id='errorforget'>{{$errorforget}}</span>
			</div>
			<div class="alert alert-success display-hide" @if ($successforget != '') style="display: block;" @endif >
				<button class="close" data-close="alert"></button>
				<span id='successforget'>{{$successforget}}</span>
			</div>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-envelope"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{$email}}"/>
				</div>
			</div>
			<div class="form-actions">
				<button type="button" id="back-btn" class="btn btn-default">Back</button>
				<button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
			</div>
		</form>
	</div>
	<div class="copyright loginfooter">
		Admin Dashboard <br/>{{$config['project']['name']}}
	</div>
	<!--[if lt IE 9]>
	<script src="{{$basesite}}assets/backend/global/plugins/respond.min.js"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/excanvas.min.js"></script> 
	<![endif]-->
	<script src="{{$basesite}}assets/backend/global/plugins/jquery.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/global/scripts/metronic.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/admin/layout/scripts/layout.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/admin/layout/scripts/demo.js" type="text/javascript"></script>
	<script src="{{$basesite}}assets/backend/admin/pages/scripts/login.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function() {   
			Metronic.init();
			Layout.init();
			Login.init();
			Demo.init();
			
			if($('#checkform').val() == 'login-form') {
				jQuery('.login-form').show();
				jQuery('.forget-form').hide();
			} else {
				jQuery('.login-form').hide();
				jQuery('.forget-form').show();
			}
		});
	</script>
	</body>
</html>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
	<head>
		<meta charset="utf-8"/>
		<title>{{$pagename}}</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta content="" name="description"/>
		<meta content="" name="author"/>
		<!-- 
		<script src="{{$basesite}}assets/backend/global/scripts/face.js" type="text/javascript"></script>
		 -->
		<script src="{{$basesite}}assets/backend/global/plugins/pace/pace.min.js" type="text/javascript"></script>
		<link href="{{$basesite}}assets/backend/global/plugins/pace/themes/pace-theme-minimal.css" rel="stylesheet" type="text/css"/>
		
		<link href="{{$basesite}}assets/backend/global/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/css/plugins.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/layout/css/themes/light2.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/jquery-tags-input/jquery.tagsinput.css" rel="stylesheet" type="text/css"/>
		<link href="{{$basesite}}assets/backend/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css">
		<link href="{{$basesite}}assets/backend/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css">
		<link href="{{$basesite}}assets/backend/admin/pages/css/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css">
		<link href="{{$basesite}}assets/backend/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
		
		<link rel="shortcut icon" href="{{$basesite}}assets/backend/images/{{$config['logo']['icon']}}?{{uniqid()}}"/>
	</head>
	<!-- to body -->
	<!-- page-sidebar-fixed -->
	<body @if ($header['menus'] == true) class="page-header-fixed page-quick-sidebar-over-content page-sidebar-closed-hide-logo page-container-bg-solid" @else style="background-color: white;" @endif>
		@if ($header['menus'] == true)
		<div class="page-header navbar navbar-fixed-top">
			<div class="page-header-inner">
				<div class="page-logo">
					<a href="{{$basesite}}" style="padding: 0px 3px 12px 7px;">
					<img height="46px" src="{{$basesite}}assets/backend/admin/layout/img/{{$config['logo']['small']['png']}}?{{uniqid()}}" alt="logo" class="logo-default" style="margin-top:0px;"/>
					</a>
					<div class="menu-toggler sidebar-toggler"></div>
				</div>
				<div id="scroll" class="hor-menu hor-menu-light hidden-sm hidden-xs hide">
					<ul class="nav navbar-nav">
						@foreach ($menu as $key => $val)
						<li @if ($classname[0] && ($menu[$key]['permalink'] == $classname[0] || count($menu) == 1)) id="selectscroll" tabindex="-1" @endif class="classic-menu-dropdown @if ($classname[0] && ($menu[$key]['permalink'] == $classname[0] || count($menu) == 1)) active @endif">
							@if($menu[$key]['permalink'] == '')
							<a href="{{$basesite}}">
							@if ($menu[$key]['icon'])<i class="fa {{$menu[$key]['icon']}}" style="color: white;"></i> @endif{{"Frontend"}}
							@if ($menu[$key]['permalink'] == $classname[0] || count($menu) == 1)
							<!-- <span class="selected"></span> This is for selected Head Menu and there icon select -->
							@endif
							</a>
							@else
							<a href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$menu[$key]['permalink']}}">
							@if ($menu[$key]['icon'])<i class="fa {{$menu[$key]['icon']}}" style="color: white;"></i> @endif{{$menu[$key]['name']}}
							@if ($menu[$key]['permalink'] == $classname[0] || count($menu) == 1)
							<!-- <span class="selected"></span> This is for selected Head Menu and there icon select -->
							@endif
							</a>
							@endif
						</li>
						@endforeach
					</ul>
				</div>
				<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
				</a>
				<div class="top-menu">
					<ul class="nav navbar-nav pull-right">
						<input type="text" class="hide" id="langsize" value="@if(isset($config['backend']['lang'])) 305 @else 235 @endif">
						@if(isset($config['backend']['lang']))
						<li class="dropdown dropdown-language">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<img src="{{$basesite}}assets/backend/global/img/flags/{{$lang['backend']['flag']}}">
							<span class="langname"> {{$lang['backend']['alias']}}</span>
							<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-default">
								@foreach($config['backend']['lang'] as $obj)
								@if($obj['link'] != $lang['backend']['link'])
								@if($obj['link'] == $config['backend']['lang'][0]['link'])
									@php $obj['link'] = "" @endphp
								@else
									@php $obj['link'] = $obj['link']."/" @endphp
								@endif
								<li>
									<a href="{{$realbasesite}}{{$obj['link']}}{{$config['backend']['aliaspage']}}{{$extlink}}">
									<img src="{{$basesite}}assets/backend/global/img/flags/{{$obj['flag']}}">{{$obj['name']}} </a>
								</li>
								@endif
								@endforeach
							</ul>
						</li>
						@endif
						<li class="dropdown dropdown-user">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<img class="img-circle" src="{{$basesite}}assets/backend/images/userdetail/{{$userdata['uimage']}}?{{uniqid()}}"/>
							<span class="username username-hide-on-mobile">{{$userdata['uname']}} </span>
							<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-default">
								<li>
									<a href="{{$basesite}}{{$config['backend']['aliaspage']}}profile">
									<i class="icon-user"></i> {{$inv->_trans('backend.header1.profile')}} </a>
								</li>
								<li class="divider"></li>
								@if (isset($config['backend']['autolock']) && $config['backend']['autolock'] != false)
								<input type="text" class="hide" id="sessiontitle" value="{{$inv->_trans('backend.lock.sessiontitle')}}">
								<input type="text" class="hide" id="sessionwarning" value="{!!$inv->_trans('backend.lock.sessionwarning')!!}">
								<input type="text" class="hide" id="sessionquestion" value="{{$inv->_trans('backend.lock.sessionquestion')}}">
								<input type="text" class="hide" id="sessionno" value="{{$inv->_trans('backend.lock.sessionno')}}">
								<input type="text" class="hide" id="sessionyes" value="{{$inv->_trans('backend.lock.sessionyes')}}">
								<li>
									<a href="{{$basesite}}{{$config['backend']['aliaspage']}}lock">
									<i class="icon-lock"></i> {{$inv->_trans('backend.header1.lock')}} </a>
								</li>
								@endif
								<li>
									<a href="{{$basesite}}{{$config['backend']['aliaspage']}}logout">
									<i class="icon-key"></i> {{$inv->_trans('backend.header1.logout')}} </a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		@endif
		<div class="page-container">
			@if ($header['menus'] == true)
			<div class="page-sidebar-wrapper">
				<div class="page-sidebar navbar-collapse collapse">
					@if ($classname[0])
					<ul class="page-sidebar-menu hidden-sm hidden-xs page-sidebar-menu-light" data-auto-scroll="true" data-slide-speed="200">
						@foreach ($menu[$classname[0]][$menu[$classname[0]]['permalink']] as $items)
							<li @if (isset($classname[1]) && $items['permalink'] == $classname[1]) class="start active" @endif >
								<a href=" @if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']])) javascript:; @else {{$basesite}}{{$config['backend']['aliaspage']}}{{$classname[0]}}/{{$items['permalink']}} @endif ">
									<i class="fa @if (isset($items['icon']) && $items['icon']) {{$items['icon']}} @else @if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']])) fa-th-list @else fa-star @endif @endif "></i>
									<span class="title">{{$items['name']}}</span>
									@if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']]))
									<span class="arrow @if (isset($classname[1]) && $items['permalink'] == $classname[1]) open @endif "></span>
									@endif
								</a>
								@if (isset($items[$items['permalink']]) && is_array($items[$items['permalink']]))
								<ul class="sub-menu">
									@include('littlemenu', ['parents' => [
										'values' => $items[$items['permalink']],
										'prefix' => ''
									]])
								</ul>
								@endif
							</li>
						@endforeach
					</ul>
					@endif
					<ul class="page-sidebar-menu visible-sm visible-xs" data-slide-speed="200" data-auto-scroll="true">
						@foreach ($menu as $key => $val)
							<li class="start @if ($classname[0] && ($menu[$key]['permalink'] == $classname[0] || count($menu) == 1)) active open @endif">
								@if($menu[$key]['permalink'] == '')
								<a href="{{$basesite}}">
									@if ($menu[$key]['icon'])<i class="fa {{$menu[$key]['icon']}}" style="color: white;"></i> @endif {{$menu[$key]['name']}}
								</a>
								@else
								<a href="@if (isset($menu[$key][$menu[$key]['permalink']]) && is_array($menu[$key][$menu[$key]['permalink']])) @if ($classname[0]) javascript:; @else {{$basesite}}{{$config['backend']['aliaspage']}}{{$menu[$key]['permalink']}} @endif @else {{$basesite}}{{$config['backend']['aliaspage']}}{{$classname[0]}}/{{$menu[$key]['permalink']}} @endif">
									@if ($menu[$key]['icon'])<i class="fa {{$menu[$key]['icon']}}" style="color: white;"></i> @endif {{$menu[$key]['name']}}
									@if ($classname[0] && ($menu[$key]['permalink'] == $classname[0] || count($menu[$key]) == 1))
									<span class="selected"></span>
									<span class="arrow open"></span>
									@elseif ($classname[0])
									<span class="arrow"></span>
									@endif
								</a>
								@if ($classname[0] && (isset($menu[$key][$menu[$key]['permalink']]) && is_array($menu[$key][$menu[$key]['permalink']])))
								<ul class="sub-menu">
									@include('littlemenumini', ['parents' => $menu[$key][$menu[$key]['permalink']]])
								</ul>
								@endif
								@endif
							</li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif
			<div class="@if ($header['menus'] == true) page-content-wrapper @endif">
				<div class="page-content indexbody">
				@if (isset($alias['titlepage']) && $alias['titlepage'][0] != '' && $alias['titlepage'][1])
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li class="fwbold unhover">
							<i class="fa fa-list-alt"></i>
							<span class="unhover">{{$alias['titlepage'][0]}}</span>
						</li>
					</ul>
				</div>
				<hr style='margin-top: @if ($header['menus'] == true) 0px; @else -25px; @endif margin-bottom: 8px;' />
				@endif
				@if (isset($header['check']) && $header['check'] == true)
				<form action="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}" method='post'>
					@if ($header['search'] == true)
					<div class="col-md-3 input-group fleft pright">
						<span class="input-group-addon" style="background-color: #6DCBDC; border: none; color: white;">{{$inv->_trans('backend.header2.searchby')}}</span>
						<select name='searchby_' class="form-control input-sm hover" onchange='searchbychange();'>
							@foreach ($alias as $key => $val)
							@if (is_array($val) && isset($val[1]) && $val[1] == true && $key != 'titlepage')
							<option value='{{$key}}' @if (isset($getsearchby) && $key == $getsearchby) selected @endif >{{$val[0]}}</option>
							@endif
							@endforeach
						</select>
					</div>
					<div id="fordatefirst" class="fleft pright col-md-3 marlm15">
						<input class="hide" type="text" id="inputsearch" value='{{$inv->_trans('backend.header2.search')}}'/>
						<input class="input-sm form-control" type="text" placeholder="{{$inv->_trans('backend.header2.search')}}..." name='search_' value='@if(isset($getsearch)){{$getsearch}}@endif'/>
					</div>
					<input id="fordatelastval" class="hidden" value='@if(isset($getsearchlast)){{$getsearchlast}}@endif'/>
					<input class="hide" type="text" id="inputdate1" value='{{$inv->_trans('backend.header2.inputdate1')}}'/>
					<input class="hide" type="text" id="inputdate2" value='{{$inv->_trans('backend.header2.inputdate2')}}'/>
					<div id="fordatelast" class='fleft pright'></div>
					<div class="fleft pright">
						<button class="btn btn-sm green-haze" type="submit">
							{{$inv->_trans('backend.header2.buttonsearch')}} <i class="fa fa-search"></i>
						</button>
					</div>
					@endif
					@if ($header['addnew'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default green-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/addnew">
						{{$inv->_trans('backend.header2.buttonaddnew')}} <i class="fa fa-file-o"></i>
						</a>
					</div>
					@endif
					@if ($header['refresh'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default blue-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}">
						{{$inv->_trans('backend.header2.buttonrefresh')}} <i class="fa fa-refresh"></i>
						</a>
					</div>
					@endif
					@if ((isset($header['downloadbulkproductregulerbeauty']) && $header['downloadbulkproductregulerbeauty'] == true && isset($header['downloadbulkproductregulerfashion']) && $header['downloadbulkproductregulerfashion'] == true && isset($header['updatebulkproductreguler']) && $header['updatebulkproductreguler'] == true) || (isset($header['downloadbulkproductsalebeauty']) && $header['downloadbulkproductsalebeauty'] == true && isset($header['downloadbulkproductsalefashion']) && $header['downloadbulkproductsalefashion'] == true && isset($header['updatebulkproductsale']) && $header['updatebulkproductsale'] == true) || (isset($header['downloadbulksizevariant']) && $header['downloadbulksizevariant'] == true && isset($header['uploadbulksizevariant']) && $header['uploadbulksizevariant'] == true))
					<br style="clear:both;"/>
					@endif
					@if (isset($header['uploadbulkproduct']) && $header['uploadbulkproduct'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default purple-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/uploadbulkproduct">
						{{$inv->_trans('backend.header2.buttonuploadbulkproduct')}} <i class="fa fa-cloud-download"></i>
						</a>
					</div>
					@endif
					@if (isset($header['uploadbulkimage']) && $header['uploadbulkimage'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default yellow-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/uploadbulkimage">
						{{$inv->_trans('backend.header2.buttonuploadbulkimage')}} <i class="fa fa-cloud-upload"></i>
						</a>
					</div>
					@endif
					@if (isset($header['downloadbulkproductregulerfashion']) && $header['downloadbulkproductregulerfashion'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default red-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadbulkproductregulerfashion">
						{{$inv->_trans('backend.header2.buttondownloadbulkproductregulerfashion')}} <i class="fa fa-cloud-download"></i>
						</a>
					</div>
					@endif
					@if (isset($header['downloadbulkproductregulerbeauty']) && $header['downloadbulkproductregulerbeauty'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default purple-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadbulkproductregulerbeauty">
						{{$inv->_trans('backend.header2.buttondownloadbulkproductregulerbeauty')}} <i class="fa fa-cloud-download"></i>
						</a>
					</div>
					@endif
					@if (isset($header['updatebulkproductreguler']) && $header['updatebulkproductreguler'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default yellow-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/updatebulkproductreguler">
						{{$inv->_trans('backend.header2.buttonupdatebulkproductreguler')}} <i class="fa fa-cloud-upload"></i>
						</a>
					</div>
					@endif
					@if (isset($header['downloadbulkproductsalefashion']) && $header['downloadbulkproductsalefashion'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default red-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadbulkproductsalefashion">
						{{$inv->_trans('backend.header2.buttondownloadbulkproductsalefashion')}} <i class="fa fa-cloud-download"></i>
						</a>
					</div>
					@endif
					@if (isset($header['downloadbulkproductsalebeauty']) && $header['downloadbulkproductsalebeauty'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default purple-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadbulkproductsalebeauty">
						{{$inv->_trans('backend.header2.buttondownloadbulkproductsalebeauty')}} <i class="fa fa-cloud-download"></i>
						</a>
					</div>
					@endif
					@if (isset($header['updatebulkproductsale']) && $header['updatebulkproductsale'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default yellow-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/updatebulkproductsale">
						{{$inv->_trans('backend.header2.buttonupdatebulkproductsale')}} <i class="fa fa-cloud-upload"></i>
						</a>
					</div>
					@endif
					@if (isset($header['downloadbulksizevariant']) && $header['downloadbulksizevariant'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default purple-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/downloadbulksizevariant">
						{{$inv->_trans('backend.header2.buttondownloadbulksizevariant')}} <i class="fa fa-cloud-download"></i>
						</a>
					</div>
					@endif
					@if (isset($header['uploadbulksizevariant']) && $header['uploadbulksizevariant'] == true)
					<div class="fleft pright">
						<a class="btn btn-sm default yellow-stripe" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/uploadbulksizevariant">
						{{$inv->_trans('backend.header2.buttonuploadbulksizevariant')}} <i class="fa fa-cloud-upload"></i>
						</a>
					</div>
					@endif
				</form>
				<div class='ptop10 clearf'></div>
				<hr style='margin-top: 0px; margin-bottom: 8px;'/>
				@endif
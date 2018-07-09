<div style="margin-left:-20px;">
	<div class="profile-sidebar" style="margin-right:0px;">
		<div class="portlet light profile-sidebar-portlet">
			<div class="profile-userpic">
				<img src="{{$basesite}}assets/backend/images/userdetail/{{$vimage}}?{{uniqid()}}" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">
					{{$vname}}
				</div>
				<div class="profile-usertitle-job">
					{{$groupname}}
				</div>
			</div>
		</div>
	</div>
	<div class="profile-content">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title tabbable-line">
						<div class="caption caption-md">
							<i class="icon-globe theme-font hide"></i>
							<span class="caption-subject font-blue-madison bold uppercase">{{$inv->_trans('backend.profile.headerprofile')}}</span>
						</div>
						<ul class="nav nav-tabs">
							<li id="tab_1_1_1" class="active">
								<a href="#tab_1_1" data-toggle="tab">{{$inv->_trans('backend.profile.info')}}</a>
							</li>
							<li id="tab_1_2_2" >
								<a href="#tab_1_2" data-toggle="tab">{{$inv->_trans('backend.profile.access')}}</a>
							</li>
						</ul>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1_1">
								<form role="form" method="post" enctype="multipart/form-data">
								<div class="form-body">
									<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<div class="@if ($errorvname != '') has-error @endif">
												<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vname')}} <span class="red">*</span></label>
												<input type="text" class="form-control input-sm" name="vname" value="{{$vname}}">
												<span class="help-block">{{$errorvname}}</span>
											</div>
											<div class="@if ($errorvmobile != '') has-error @endif">
												<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vmobile')}} <span class="red">*</span></label>
												<input type="text" class="form-control input-sm numberonly" name="vmobile" value="{{$vmobile}}">
												<span class="help-block">{{$errorvmobile}}</span>
											</div>
											<div class="@if ($errorvemail != '') has-error @endif">
												<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vemail')}} <span class="red">*</span></label>
												<input type="text" class="form-control input-sm" name="vemail" value="{{$vemail}}">
												<span class="help-block">{{$errorvemail}}</span>
											</div>
											<div class="@if ($errorvphone != '') has-error @endif">
												<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vphone')}}</label>
												<input type="text" class="form-control input-sm numberonly" name="vphone" value="{{$vphone}}">
												<span class="help-block">{{$errorvphone}}</span>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<div>
												<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vaddress')}}</label>
												<textarea type="text" class="form-control input-sm" name="vaddress" rows='3'>{{$vaddress}}</textarea>
											</div>
											<div class="@if ($errorvimage != '' ) has-error @endif">
												<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vimage')}}</label>
												<div id="showimage">
												@if ($vimage != '' && $vimage != 'nouser.jpg')
													<div style='clear:both;'></div>
													<img id="image" src='{{$basesite}}assets/backend/images/userdetail/small_{{$vimage}}?{{uniqid()}}'/>
													<div style='clear:both;'></div>
													<a id="deleteimage" class="btn btn-sm red" onclick="deleteimage();" value="Are you sure to remove image?">
													{{$inv->_trans('backend.profile.deleteimage', [
														'image' => $inv->_trans('backend.profile.vimage')
													])}} <i class="fa fa-trash-o"></i>
													</a>
												@endif
												</div>
												<div style='clear:both;'></div>
												<span id="selectimage" class="btn btn-sm green btn-file">
													<span class="fileinput-new">{{$inv->_trans('backend.profile.selectimage', [
														'image' => $inv->_trans('backend.profile.vimage')
													])}} <i class="fa fa-plus"></i></span>
													<input type="file" id="vimage" name="vimage">
												</span>
												<span id="showvimage"></span>
												<div style='clear:both;'></div>
												<span class="red">{{$inv->_trans('backend.profile.captionimage')}}</span>
												<div style='clear:both;'></div>
												<span class="help-block">{{$errorvimage}}</span>
											</div>
										</div>
									</div>
									</div>
								</div>
									@if (isset($messagepersonalinfo) && $messagepersonalinfo != '')
									<span class='green bold'>{!!$messagepersonalinfo!!}</span><br/><br/>
									@endif
									<div class="margiv-top-10">
										<button type="submit" class="btn btn-sm blue" name="personalinfo">{{$inv->_trans('backend.profile.buttonpersonal')}} <i class="fa fa-arrow-circle-right"></i></button>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="tab_1_2">
								<form role="form" method="post">
									<div class="form-group">
										<div class="@if ($errorvusername != '') has-error @endif">
											<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vusername')}} <span class="red">*</span></label>
											<input type="text" class="form-control input-sm" name="vusername" value="{{$vusername}}" disabled >
											<input type="text" class="hide" name="vusername" value="{{$vusername}}" >
											<span class="help-block">{{$errorvusername}}</span>
										</div>
										<div class="@if ($errorvpassword != '') has-error @endif">
											<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.vpassword')}} <sup class="red">{{$inv->_trans('backend.profile.suppass', [
												'pass' => $inv->_trans('backend.profile.vpassword')
											])}}</sup></label>
											<input type="password" class="form-control input-sm" name="vpassword" value="{{$vpassword}}">
											<span class="help-block">{{$errorvpassword}}</span>
										</div>
										<div class="@if ($errorrepassword != '') has-error @endif">
											<label class="control-label input-sm marlm10">{{$inv->_trans('backend.profile.repassword')}}</label>
											<input type="password" class="form-control input-sm" name="repassword" value="{{$repassword}}">
											<span class="help-block">{{$errorrepassword}}</span>
										</div>
									</div>
									@if (isset($messagepersonalaccess) && $messagepersonalaccess != '')
									<span class='green bold'>{!!$messagepersonalaccess!!}</span><br/><br/>
									@endif
									<div class="margiv-top-10">
										<button type="submit" class="btn btn-sm blue" name="personalaccess">{{$inv->_trans('backend.profile.buttonaccess')}} <i class="fa fa-arrow-circle-right"></i></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">	
	function deleteimage() {
		bootbox.confirm($('#deleteimage').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}profile/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteimage"},
					success		: function(data) {
						if(!data) {
							$('#showimage').html('');
							$('.profile-userpic').find('img').attr('src', '{{$basesite}}/assets/backend/images/userdetail/nouser.jpg?{{uniqid()}}');
						}
					}
				});
			}
		});
	}
	
	window.onload = (function() {
		$('#deleteimage').css('width', $('#image').css('width'));
		$('#selectimage').css('width', $('#image').css('width'));

		var action = "{{$pageprofile}}";
		if(action) {
			var tabli = $('#' + action);
			tabli.find('a').click();
		}

		var fileToRead = document.getElementById("vimage");
		fileToRead.addEventListener("change", function(event) {
			var files	= fileToRead.files;
			var len		= files.length;
			// we should read just one file
			if (len) {
				$('#showvimage').html(files[0].name);
			}
		}, false);
	});
</script>
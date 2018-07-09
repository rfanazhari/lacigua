@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<form method="post" class="horizontal-form" enctype="multipart/form-data">
	<div class="form-body">
		<div class="row">
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Access</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorgroupname != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['groupname'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="groupname" onchange="getaccess(this.value, '{{$action}}');">
								<option value="">Select {{$alias['groupname'][0]}}</option>
								@foreach ($arrgroup as $groupval)
									<option value="{{$groupval['permalink']}}" @if ($groupval['permalink'] == $groupname) selected @endif>{{$groupval[$flip['groupname']]}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorgroupname}}</span>
						</div>
						<div class="@if ($errorvusername != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['vusername'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="vusername" value="{{$vusername}}">
							<span class="help-block">{{$errorvusername}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorvpassword != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['vpassword'][0]}} @if ($action == 'addnew')<span class="red">*</span>@else<sup class="red">Insert Password for Update new Password</sup>@endif</label>
							<input type="password" class="form-control input-sm" name="vpassword" value="{{$vpassword}}">
							<span class="help-block">{{$errorvpassword}}</span>
						</div>
						<div class="@if ($errorrepassword != '') has-error @endif">
							<label class="control-label input-sm marlm10">Re-type New {{$alias['vpassword'][0]}} @if ($action == 'addnew')<span class="red">*</span>@endif</label>
							<input type="password" class="form-control input-sm" name="repassword" value="{{$repassword}}">
							<span class="help-block">{{$errorrepassword}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Information</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">{{$alias['userstatus'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="userstatus">
								@foreach ($arrstatus as $statusval)
									<option value="{{$statusval}}" @if ($statusval == $userstatus) selected @endif>{{$statusval}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>
						<div class="@if ($errorvname != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['vname'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="vname" value="{{$vname}}">
							<span class="help-block">{{$errorvname}}</span>
						</div>
						<div class="@if ($errorvmobile != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['vmobile'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="vmobile" value="{{$vmobile}}">
							<span class="help-block">{{$errorvmobile}}</span>
						</div>
						<div class="@if ($errorvemail != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['vemail'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="vemail" value="{{$vemail}}">
							<span class="help-block">{{$errorvemail}}</span>
						</div>
						<div class="@if ($errorvphone != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['vphone'][0]}}</label>
							<input type="text" class="form-control input-sm numberonly" name="vphone" value="{{$vphone}}">
							<span class="help-block">{{$errorvphone}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">{{$alias['vaddress'][0]}}</label>
							<textarea type="text" class="form-control input-sm" name="vaddress">{{$vaddress}}</textarea>
							<span class="help-block"></span>
						</div>
						<div class="fileinput fileinput-new @if ($errorvimage != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['vimage'][0]}} </label>
							<div id="showimage">
							@if (($action == 'edit' || $action == 'detail') && $vimage != '')
								<div style='clear:both;'></div>
								<img id="image" src='{{$vimage}}?{{uniqid()}}'/>
								<div style='clear:both;'></div>
								<a id="deleteimage" class="btn btn-sm red" onclick="deleteimage();" value="Are you sure to remove image?">
								Delete {{$alias['vimage'][0]}} <i class="fa fa-trash-o"></i>
								</a>
							@endif
							</div>
							<div class="input-group">
								<div class="form-control uneditable-input input-sm" data-trigger="fileinput">
									<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
									</span>
								</div>
								<span class="input-group-addon btn btn-sm default btn-file">
								<span class="fileinput-new">
								Select file </span>
								<span class="fileinput-exists">
								Change </span>
								<input type="file" name="vimage">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorvimage}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorsignatureimage != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['signatureimage'][0]}} </label>
							<div id="showsignature">
							@if (($action == 'edit' || $action == 'detail') && $signatureimage != '')
								<div style='clear:both;'></div>
								<img id="signature" src='{{$signatureimage}}?{{uniqid()}}'/>
								<div style='clear:both;'></div>
								<a id="deletesignature" class="btn btn-sm red" onclick="deletesignature();" value="Are you sure to remove signature?">
								Delete {{$alias['signatureimage'][0]}} <i class="fa fa-trash-o"></i>
								</a>
							@endif
							</div>
							<div class="input-group">
								<div class="form-control uneditable-input input-sm" data-trigger="fileinput">
									<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
									</span>
								</div>
								<span class="input-group-addon btn btn-sm default btn-file">
								<span class="fileinput-new">
								Select file </span>
								<span class="fileinput-exists">
								Change </span>
								<input type="file" name="signatureimage">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorsignatureimage}}</span>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<div class="form-actions right">
		<input type="text" class="hide" name="action" value="{{$action}}">
		<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}">Cancel</a>
		@if ($action == 'edit')
		<button type="submit" class="btn btn-sm blue" name="edit">Edit <i class="fa fa-arrow-circle-right"></i></button>
		@else
		<button type="submit" class="btn btn-sm blue" name="addnew">Save <i class="fa fa-arrow-circle-right"></i></button>
		@endif
	</div>
	<br/>
	<div class="form-body">
		<div class="row">
			<input type="text" class="hide" id="listoptmenu" value="{{json_encode($optmenu, JSON_FORCE_OBJECT)}}">
			<div id='listmenu'></div>
		</div>
	</div>	
</form>
<script type="text/javascript">
	window.onload = (function() {
		$('#deleteimage').css('width', $('#image').css('width'));
		$('#deletesignature').css('width', $('#signature').css('width'));
		@if (isset($groupname) && $groupname != '')
		getaccess('{{$groupname}}', '{{$action}}');
		@endif
	});
	
	function getaccess(value, action) {
		if(value) {
			$.ajax({
				url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
				type		: 'POST',
				data		: {'ajaxpost':"getaccess",'value':value,'action':action,'optmenu':$('#listoptmenu').val()},
				success		: function(data) {
					$('#listmenu').html(data);
				}
			});
		} else {
			$('#listmenu').html('');
		}
	}
	
	@if ($action == 'edit')
	function deleteimage() {
		bootbox.confirm($('#deleteimage').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteimage",'id':'{{$getid}}'},
					success		: function(data) {
						if(!data) $('#showimage').html('');
					}
				});
			}
		});
	}
	@endif
	
	@if ($action == 'edit')
	function deletesignature() {
		bootbox.confirm($('#deletesignature').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deletesignature",'id':'{{$getid}}'},
					success		: function(data) {
						if(!data) $('#showsignature').html('');
					}
				});
			}
		});
	}
	@endif
</script>
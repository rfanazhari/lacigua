@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<form method="post" class="horizontal-form" enctype="multipart/form-data">
	<div class="form-body">
		<div class="row">
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Information</legend>
				<div class="col-md-6">
					<div class="@if ($errorSellerID != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['SellerID'][0]}} <span class="red">*</span></label>
						<select class="form-control input-sm select2me" name="SellerID" onchange="GetMode(this.value)">
							<option value=''>Select {{$alias['SellerID'][0]}}</option>
							@foreach ($arrSeller as $obj)
							<option value="{{$obj['ID']}}" @if ($obj['ID'] == $SellerID) selected @endif>{{$obj['FullName']}}</option>
							@endforeach
						</select>
						<span class="help-block">{{$errorSellerID}}</span>
					</div>
					<div class="@if ($errorName != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['Name'][0]}} <span class="red">*</span></label>
						<input type="text" class="form-control input-sm" name="Name" value="{{$Name}}">
						<span class="help-block">{{$errorName}}</span>
					</div>	
					<div class="@if ($errorAbout != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['About'][0]}}</label>
						<textarea type="text" class="form-control input-sm" name="About">{{$About}}</textarea>
						<span class="help-block">{{$errorAbout}}</span>
					</div>
					<div class="@if ($errorShowOnHeader != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['ShowOnHeader'][0]}} <span class="red">*</span></label>
						<select class="form-control input-sm select2me" name="ShowOnHeader">
							@foreach ($arrShowOnHeader as $key => $value)
							<option value="{{$key}}" @if ($key == $ShowOnHeader) selected @endif>{{$value}}</option>
							@endforeach
						</select>
						<span class="help-block">{{$errorShowOnHeader}}</span>
					</div>
					<div class="fileinput fileinput-new @if ($errorLogo != '') has-error @endif" data-provides="fileinput">
						<label class="control-label input-sm marlm10">{{$alias['Logo'][0]}} <span class="red">*</span></label>
						<div id="Logo">
							@if (($action == 'edit' || $action == 'detail') && $Logo != '')
							<div class="contentimage">
								<img src='{{$Logo}}?{{uniqid()}}'/>
								<a id="deleteLogo" class="btn btn-sm red" onclick="deleteLogo();" value="Are you sure to remove {{$alias['Logo'][0]}} ?"><i class="fa fa-trash-o"></i></a>
							</div>
							@endif
						</div>
						<div class="input-group">
							<div class="form-control uneditable-input input-sm" data-trigger="fileinput">
								<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
								</span>
							</div>
							<span class="input-group-addon btn btn-sm default btn-file">
								<span class="fileinput-new">
								Select {{$alias['Logo'][0]}} </span>
								<span class="fileinput-exists">
								Change {{$alias['Logo'][0]}} </span>
								<input type="file" name="Logo">
							</span>
							<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
							Remove </a>
						</div>
						<span class="help-block">{{$errorLogo}}</span>
					</div>
					<div class="fileinput fileinput-new @if ($errorBanner != '') has-error @endif" data-provides="fileinput">
						<label class="control-label input-sm marlm10">{{$alias['Banner'][0]}} <span class="red">*</span></label>
						<div id="Banner">
							@if (($action == 'edit' || $action == 'detail') && $Banner != '')
							<div class="contentimage">
								<img src='{{$Banner}}?{{uniqid()}}'/>
								<a id="deleteBanner" class="btn btn-sm red" onclick="deleteBanner();" value="Are you sure to remove {{$alias['Banner'][0]}} ?"><i class="fa fa-trash-o"></i></a>
							</div>
							@endif
						</div>
						<div class="input-group">
							<div class="form-control uneditable-input input-sm" data-trigger="fileinput">
								<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
								</span>
							</div>
							<span class="input-group-addon btn btn-sm default btn-file">
								<span class="fileinput-new">
								Select {{$alias['Banner'][0]}} </span>
								<span class="fileinput-exists">
								Change {{$alias['Banner'][0]}} </span>
								<input type="file" name="Banner">
							</span>
							<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
							Remove </a>
						</div>
						<span class="help-block">{{$errorBanner}}</span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorMode != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Mode'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="Mode">
								@foreach ($arrMode as $key => $value)
								<option value="{{$key}}" @if ($key == $Mode) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorMode}}</span>
						</div>
						<div class="@if ($errorTitleUnFeature != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['TitleUnFeature'][0]}}</label>
							<input type="text" class="form-control input-sm" name="TitleUnFeature" value="{{$TitleUnFeature}}">
							<span class="help-block">{{$errorTitleUnFeature}}</span>
						</div>
						<div class="@if ($errorNote != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Note'][0]}}</label>
							<textarea type="text" class="form-control input-sm" name="Note">{{$Note}}</textarea>
							<span class="help-block">{{$errorNote}}</span>
						</div>
						<div class="@if ($errorHolidayMode != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['HolidayMode'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="HolidayMode">
								@foreach ($arrHolidayMode as $key => $value)
								<option value="{{$key}}" @if ($key == $HolidayMode) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorHolidayMode}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorIcon != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Icon'][0]}} <span class="red">*</span></label>
							<div id="Icon">
								@if (($action == 'edit' || $action == 'detail') && $Icon != '')
								<div class="contentimage">
									<img src='{{$Icon}}?{{uniqid()}}'/>
									<a id="deleteIcon" class="btn btn-sm red" onclick="deleteIcon();" value="Are you sure to remove {{$alias['Icon'][0]}} ?"><i class="fa fa-trash-o"></i></a>
								</div>
								@endif
							</div>
							<div class="input-group">
								<div class="form-control uneditable-input input-sm" data-trigger="fileinput">
									<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
									</span>
								</div>
								<span class="input-group-addon btn btn-sm default btn-file">
									<span class="fileinput-new">
									Select {{$alias['Icon'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['Icon'][0]}} </span>
									<input type="file" name="Icon">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorIcon}}</span>
						</div>
					</div>
				</div>
			</fieldset>

			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Information Others</legend>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorMainCategory != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['MainCategory'][0]}} <span class="red">*</span>
							</label>
							<div style="margin-left: -10px !important;">
								@foreach ($arrMainCategory as $value)
								<label class="hover input-sm">
									<input type="checkbox" name="MainCategory[]" value="{{ $value }}" @if($MainCategory && in_array($value, $MainCategory)) checked @endif >
									{{ $value }}
								</label>
								@endforeach
							</div>
							<span class="help-block">{{$errorMainCategory}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorLicenseSell != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['LicenseSell'][0]}}</label>
							<div style="margin-left: -10px !important;">
								<label class="hover input-sm">
									<input type="checkbox" id="license" name="LicenseSell" value="1" @if($LicenseSell) checked @endif >
									Yes
								</label>
							</div>
							<span class="help-block">{{$errorLicenseSell}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div id="error" class="fileinput fileinput-new @if ($errorLicenseFile != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['LicenseFile'][0]}} <span id="mandatori" class="red">@if ($errorLicenseFile != '') * @endif</span></label>
							<div id="LicenseFile">
								@if (($action == 'edit' || $action == 'detail') && $LicenseFile != '')
								<a href="{{$LicenseFile}}" class="btn btn-sm blue">
									{{$alias['LicenseFile'][0]}}
								</a>
								<a id="deleteLicenseFile" class="btn btn-sm red" onclick="deleteLicenseFile();" value="Are you sure to remove {{$alias['LicenseFile'][0]}} ?">
									Delete {{$alias['LicenseFile'][0]}} <i class="fa fa-trash-o"></i>
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
									Select {{$alias['LicenseFile'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['LicenseFile'][0]}} </span>
									<input type="file" name="LicenseFile">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span id="help" class="help-block">{{$errorLicenseFile}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<div class="@if ($errorStyleList != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['StyleList'][0]}} <span class="red">*</span>
							</label>
							<div style="margin-left: -10px !important;">
								@foreach ($arrStyle as $value)
								<label class="hover input-sm" style="width:200px;">
									<input type="checkbox" name="StyleList[]" value="{{ $value['ID'] }}" @if($StyleList && in_array($value['ID'], $StyleList)) checked @endif >
									{{ $value['Name'] }}
								</label>
								@endforeach
							</div>
							<span class="help-block">{{$errorStyleList}}</span>
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
</form>

<script type="text/javascript">
	window.onload = (function() {
		$('#deleteLogo').css('width', $('#showImage').css('width'));
		$('#deleteIcon').css('width', $('#deleteIcon').css('width'));
		$('#deleteLicenseFile').css('width', $('#deleteLicenseFile').css('width'));

		$('#license').on('change', function(){ // on change of state
		   if(this.checked) // if changed state is "CHECKED"
		    {
		         $('#mandatori').text('*');
		    }
		    else{
		    	
		    	$('#mandatori').text('');
				$('#help').empty();	
				$('#error').removeClass('has-error');
		    }
		})
	});
	
	function GetMode(val) {
		$.ajax({
			url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
			type		: 'POST',
			data		: {'ajaxpost':"GetMode",'value':val},
			success		: function(data) {
				var data = JSON.parse(data);

				if(data['response'] == 'OK') {
					var listmode = '';
					$.each(data['data'], function(key, value) {
						listmode = listmode + '<option value="'+key+'">'+value+'</option>';
					});
					$('[name="Mode"]').html(listmode);
					$('[name="Mode"]').select2("val", $('[name="Mode"] option:first').val());
            	}
			}
		});
	}

	@if ($action == 'edit')
	function deleteLogo() {
		bootbox.confirm($('#deleteLogo').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteLogo",'value':'{{$BrandID}}'},
					success		: function(data) {
						if(!data) $('#Logo').html('');
					}
				});
			}
		});
	}
	function deleteBanner() {
		bootbox.confirm($('#deleteBanner').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteBanner",'value':'{{$BrandID}}'},
					success		: function(data) {
						if(!data) $('#Banner').html('');
					}
				});
			}
		});
	}
	function deleteIcon() {
		bootbox.confirm($('#deleteIcon').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteIcon",'value':'{{$BrandID}}'},
					success		: function(data) {
						if(!data) $('#Icon').html('');
					}
				});
			}
		});
	}
	function deleteLicenseFile() {
		bootbox.confirm($('#deleteLicenseFile').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteLicenseFile",'value':'{{$BrandID}}'},
					success		: function(data) {
						if(!data) $('#LicenseFile').html('');
					}
				});
			}
		});
	}
	@endif
</script>
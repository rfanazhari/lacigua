@if (isset($messageerror) && $messageerror != '')
<span class='red bold'>{!!$messageerror!!}</span><br/><br/>
@endif
@if (isset($messagesuccess) && $messagesuccess != '')
<span class='green bold'>{!!$messagesuccess!!}</span><br/><br/>
@endif
<form method="post" class="horizontal-form" enctype="multipart/form-data">
	<div class="form-body">
		<div class="row">
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} Banner</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div class="fileinput fileinput-new @if ($errorBannerWomen != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['BannerWomen'][0]}} <span class="red">* <sup>Width 1200px, Height 340px</sup></span></label>
							<div id="BannerWomen">
								@if ($BannerWomen != '')
								<div class="contentimage">
									<img src='{{$BannerWomen}}?{{uniqid()}}'/>
									<a id="deleteBannerWomen" class="btn btn-sm red" onclick="deleteBannerWomen();" value="Are you sure to remove {{$alias['BannerWomen'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['BannerWomen'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['BannerWomen'][0]}} </span>
									<input type="file" name="BannerWomen">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorBannerWomen}}</span>
						</div>
						<div class="@if ($errorTextWomen != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['TextWomen'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="TextWomen" value="{{$TextWomen}}">
							<span class="help-block">{{$errorTextWomen}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorBannerMen != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['BannerMen'][0]}} <span class="red">* <sup>Width 1200px, Height 340px</sup></span></label>
							<div id="BannerMen">
								@if ($BannerMen != '')
								<div class="contentimage">
									<img src='{{$BannerMen}}?{{uniqid()}}'/>
									<a id="deleteBannerMen" class="btn btn-sm red" onclick="deleteBannerMen();" value="Are you sure to remove {{$alias['BannerMen'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['BannerMen'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['BannerMen'][0]}} </span>
									<input type="file" name="BannerMen">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorBannerMen}}</span>
						</div>
						<div class="@if ($errorTextMen != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['TextMen'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="TextMen" value="{{$TextMen}}">
							<span class="help-block">{{$errorTextMen}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="fileinput fileinput-new @if ($errorBannerKids != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['BannerKids'][0]}} <span class="red">* <sup>Width 1200px, Height 340px</sup></span></label>
							<div id="BannerKids">
								@if ($BannerKids != '')
								<div class="contentimage">
									<img src='{{$BannerKids}}?{{uniqid()}}'/>
									<a id="deleteBannerKids" class="btn btn-sm red" onclick="deleteBannerKids();" value="Are you sure to remove {{$alias['BannerKids'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['BannerKids'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['BannerKids'][0]}} </span>
									<input type="file" name="BannerKids">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorBannerKids}}</span>
						</div>
						<div class="@if ($errorTextKids != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['TextKids'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="TextKids" value="{{$TextKids}}">
							<span class="help-block">{{$errorTextKids}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorBannerLabels != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['BannerLabels'][0]}} <span class="red">* <sup>Width 1200px, Height 340px</sup></span></label>
							<div id="BannerLabels">
								@if ($BannerLabels != '')
								<div class="contentimage">
									<img src='{{$BannerLabels}}?{{uniqid()}}'/>
									<a id="deleteBannerLabels" class="btn btn-sm red" onclick="deleteBannerLabels();" value="Are you sure to remove {{$alias['BannerLabels'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
									Select {{$alias['BannerLabels'][0]}} </span>
									<span class="fileinput-exists">
									Change {{$alias['BannerLabels'][0]}} </span>
									<input type="file" name="BannerLabels">
								</span>
								<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
							<span class="help-block">{{$errorBannerLabels}}</span>
						</div>
						<div class="@if ($errorTextLabels != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['TextLabels'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="TextLabels" value="{{$TextLabels}}">
							<span class="help-block">{{$errorTextLabels}}</span>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">{{explode(' / ', $pagename)[count(explode(' / ', $pagename)) - 1]}} System</legend>
				<div class="col-md-12">
					<div class="form-group">
						<div class="@if ($errorSubscribeAmount != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SubscribeAmount'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm numberonly" name="SubscribeAmount" value="{{$SubscribeAmount}}">
							<span class="help-block">{{$errorSubscribeAmount}}</span>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<div class="form-actions right">
		<input type="text" class="hide" name="action" value="{{$action}}">
		<a class="btn btn-sm default" href="{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}">Cancel</a>
		<button type="submit" class="btn btn-sm blue" name="edit">Edit <i class="fa fa-arrow-circle-right"></i></button>
	</div>
</form>

<script type="text/javascript">
	function deleteBannerWomen() {
		bootbox.confirm($('#deleteBannerWomen').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteBannerWomen",'value':'1'},
					success		: function(data) {
						if(!data) $('#BannerWomen').html('');
					}
				});
			}
		});
	}
	function deleteBannerMen() {
		bootbox.confirm($('#deleteBannerMen').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteBannerMen",'value':'1'},
					success		: function(data) {
						if(!data) $('#BannerMen').html('');
					}
				});
			}
		});
	}
	function deleteBannerKids() {
		bootbox.confirm($('#deleteBannerKids').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteBannerKids",'value':'1'},
					success		: function(data) {
						if(!data) $('#BannerKids').html('');
					}
				});
			}
		});
	}
	function deleteBannerLabels() {
		bootbox.confirm($('#deleteBannerLabels').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteBannerLabels",'value':'1'},
					success		: function(data) {
						if(!data) $('#BannerLabels').html('');
					}
				});
			}
		});
	}
</script>
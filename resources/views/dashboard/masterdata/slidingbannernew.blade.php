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
				<div class="col-md-12">
					<div class="form-group">
						<div class="fileinput fileinput-new @if ($errorBanner != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Banner'][0]}} <span class="red">* <sup>Width 1920px, Height 878px</sup></span></label>
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
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div>
							<label class="control-label input-sm marlm10">{{$alias['BannerURL'][0]}}</label>
							<input type="text" class="form-control input-sm" name="BannerURL" value="{{$BannerURL}}">
							<span class="help-block"></span>
						</div>
						<div class="@if ($errorBannerStart != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BannerStart'][0]}} </label>
							<input type="text" class="form-control datetime input-sm" name="BannerStart" value="{{$BannerStart}}">
							<span class="help-block">{{$errorBannerStart}}</span>
						</div>
						<div class="@if ($errorBannerEnd != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BannerEnd'][0]}} </label>
							<input type="text" class="form-control input-sm datetime" name="BannerEnd" value="{{$BannerEnd}}">
							<span class="help-block">{{$errorBannerEnd}}</span>
						</div>
						<div class="@if ($errorShowTime != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ShowTime'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ShowTime" onchange="changebannerdate(this.value)">
								@foreach ($arrShowTime as $key => $value)
								<option value="{{$key}}" @if ($key == $ShowTime) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorShowTime}}</span>
						</div>
						<div class="@if ($errorTitle != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Title'][0]}}</label>
							<input type="text" class="form-control input-sm" name="Title" value="{{$Title}}">
							<span class="help-block">{{$errorTitle}}</span>
						</div>
						<div class="@if ($errorText1 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Text1'][0]}}</label>
							<input type="text" class="form-control input-sm" name="Text1" value="{{$Text1}}">
							<span class="help-block">{{$errorText1}}</span>
						</div>
						<div class="@if ($errorSubTitle1 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SubTitle1'][0]}}</label>
							<input type="text" class="form-control input-sm" name="SubTitle1" value="{{$SubTitle1}}">
							<span class="help-block">{{$errorSubTitle1}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorText2 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Text2'][0]}}</label>
							<input type="text" class="form-control input-sm" name="Text2" value="{{$Text2}}">
							<span class="help-block">{{$errorText2}}</span>
						</div>
						<div class="@if ($errorSubTitle2 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['SubTitle2'][0]}}</label>
							<input type="text" class="form-control input-sm" name="SubTitle2" value="{{$SubTitle2}}">
							<span class="help-block">{{$errorSubTitle2}}</span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['BgColorNote'][0]}}</label>
							<div class="input-group">
								<input type="text" class="colorpicker-default form-control input-sm" id="BgColorNote" name="BgColorNote" value="{{$BgColorNote}}" readonly />
								<span class="input-group-btn">
								<button class="btn btn-sm default" type="button" onclick='$("#BgColorNote").val("")'><i class="fa fa-eraser"></i></button>
								</span>
							</div>
							<span class="help-block"></span>
						</div>
						<div class="@if ($errorBrandName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BrandName'][0]}}</label>
							<input type="text" class="form-control input-sm" name="BrandName" value="{{$BrandName}}">
							<span class="help-block">{{$errorBrandName}}</span>
						</div>
						<div class="@if ($errorBrandBy != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['BrandBy'][0]}}</label>
							<input type="text" class="form-control input-sm" name="BrandBy" value="{{$BrandBy}}">
							<span class="help-block">{{$errorBrandBy}}</span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['BgColorNote2'][0]}}</label>
							<div class="input-group">
								<input type="text" class="colorpicker-default form-control input-sm" id="BgColorNote2" name="BgColorNote2" value="{{$BgColorNote2}}" readonly />
								<span class="input-group-btn">
								<button class="btn btn-sm default" type="button" onclick='$("#BgColorNote2").val("")'><i class="fa fa-eraser"></i></button>
								</span>
							</div>
							<span class="help-block"></span>
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
		changebannerdate({{$ShowTime}});
	});
	
	@if ($action == 'edit')
	function deleteBanner() {
		bootbox.confirm($('#deleteBanner').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteBanner",'value':'{{$getid}}'},
					success		: function(data) {
						if(!data) $('#Banner').html('');
					}
				});
			}
		});
	}
	@endif

	function changebannerdate(val) {
		var checkspanred = $('[name="BannerStart"],[name="BannerEnd"]').parent().find('label');
		if(val == 0) {
			checkspanred.find('span.red').remove();
		} else if(val == 1) {
			var checkspanredcount = 0
			checkspanred.find('span.red').each(function(key,val) {
				checkspanredcount = checkspanredcount + 1;
			});
			if(checkspanredcount == 0) {
				checkspanred.append('<span class="red">*</span>');
			}
		}
	}
</script>
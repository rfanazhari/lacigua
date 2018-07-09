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
					<div class="form-group">
						<div class="@if ($errorTitle != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Title'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Title" value="{{$Title}}">
							<span class="help-block">{{$errorTitle}}</span>
						</div>
						<div class="@if ($errorDescription != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Description'][0]}} </label>
							<input type="text" class="form-control input-sm" name="Description" value="{{$Description}}">
							<span class="help-block">{{$errorDescription}}</span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['TextColor'][0]}}</label>
							<div class="input-group">
								<input type="text" class="colorpicker-default form-control input-sm" id="TextColor" name="TextColor" value="{{$TextColor}}" readonly />
								<span class="input-group-btn">
								<button class="btn btn-sm default" type="button" onclick='$("#TextColor").val("")'><i class="fa fa-eraser"></i></button>
								</span>
							</div>
							<span class="help-block"></span>
						</div>
						<div class="fileinput fileinput-new @if ($errorBanner != '') has-error @endif" data-provides="fileinput">
							<label class="control-label input-sm marlm10">{{$alias['Banner'][0]}} <span class="red"><sup>Width 1200px, Height 278px</sup></span></label>
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
						<div>
							<label class="control-label input-sm marlm10">{{$alias['BannerColor'][0]}}</label>
							<div class="input-group">
								<input type="text" class="colorpicker-default form-control input-sm" id="BannerColor" name="BannerColor" value="{{$BannerColor}}" readonly />
								<span class="input-group-btn">
								<button class="btn btn-sm default" type="button" onclick='$("#BannerColor").val("")'><i class="fa fa-eraser"></i></button>
								</span>
							</div>
							<span class="help-block"></span>
						</div>
						<div class="@if ($errorNoteTitle != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['NoteTitle'][0]}} </label>
							<input type="text" class="form-control input-sm" name="NoteTitle" value="{{$NoteTitle}}">
							<span class="help-block">{{$errorNoteTitle}}</span>
						</div>
						<div>
							<label class="control-label input-sm marlm10">{{$alias['NoteColor'][0]}}</label>
							<div class="input-group">
								<input type="text" class="colorpicker-default form-control input-sm" id="NoteColor" name="NoteColor" value="{{$NoteColor}}" readonly />
								<span class="input-group-btn">
								<button class="btn btn-sm default" type="button" onclick='$("#NoteColor").val("")'><i class="fa fa-eraser"></i></button>
								</span>
							</div>
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorNoteDescription != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['NoteDescription'][0]}} </label>
							<textarea type="text" class="ckeditor form-control input-sm" name="NoteDescription">{{$NoteDescription}}</textarea>
							<span class="help-block">{{$errorNoteDescription}}</span>
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
</script>
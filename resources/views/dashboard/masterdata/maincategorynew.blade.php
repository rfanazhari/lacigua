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
					<div class="@if ($errorModelType != '') has-error @endif">
						<label class="control-label input-sm marlm10">{{$alias['ModelType'][0]}} <span class="red">*</span></label>
						<select class="form-control input-sm select2me" name="ModelType">
							@foreach ($arrModelType as $key => $value)
							<option value="{{$key}}" @if ($key == $ModelType) selected @endif>{{$value}}</option>
							@endforeach
						</select>
						<span class="help-block">{{$errorModelType}}</span>
					</div>
					<div class="form-group">
						<div class="@if ($errorTitle != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Title'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Title" value="{{$Title}}">
							<span class="help-block">{{$errorTitle}}</span>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="fileinput fileinput-new @if ($errorImage != '') has-error @endif" data-provides="fileinput">
						<label class="control-label input-sm marlm10">{{$alias['Image'][0]}} <span class="red">*</span></label>
						<div id="Image">
							@if (($action == 'edit' || $action == 'detail') && $Image != '')
							<div class="contentimage">
								<img src='{{$Image}}?{{uniqid()}}'/>
								<a id="deleteImage" class="btn btn-sm red" onclick="deleteImage();" value="Are you sure to remove {{$alias['Image'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
								Select {{$alias['Image'][0]}} </span>
								<span class="fileinput-exists">
								Change {{$alias['Image'][0]}} </span>
								<input type="file" name="Image">
							</span>
							<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
							Remove </a>
						</div>
						<span class="help-block">{{$errorImage}}</span>
					</div>
						<div class="@if ($errorURL != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['URL'][0]}}</label>
							<input type="text" class="form-control input-sm" name="URL" value="{{$URL}}">
							<span class="help-block">{{$errorURL}}</span>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<div class="@if ($errorNote != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Note'][0]}}</label>
							<textarea type="text" class="form-control input-sm" name="Note">{{$Note}}</textarea>
							<span class="help-block">{{$errorNote}}</span>
						</div>
					</div>
				</div>
				
			</fieldset>

			<fieldset class='fieldset'><legend class='legend' rel="stylesheet">Notes</legend>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorText1 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Text1'][0]}} </label>
							<textarea type="text" class="form-control input-sm" name="Text1">{{$Text1}}</textarea>
							<span class="help-block">{{$errorText1}}</span>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorText2 != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Text2'][0]}} </label>
							<textarea type="text" class="form-control input-sm" name="Text2">{{$Text2}}</textarea>
							<span class="help-block">{{$errorText2}}</span>
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
		$('#deleteImage').css('width', $('#showImage').css('width'));
	});
	
	@if ($action == 'edit')
	function deleteImage() {
		bootbox.confirm($('#deleteImage').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteImage",'value':'{{$getid}}'},
					success		: function(data) {
						if(!data) $('#Image').html('');
					}
				});
			}
		});
	}
	@endif
</script>
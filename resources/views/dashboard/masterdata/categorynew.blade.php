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
						<div class="@if ($errorModelType != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ModelType'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ModelType">
								@foreach ($arrModelType as $key => $value)
								<option value="{{$key}}" @if ($key == $ModelType) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorModelType}}</span>
						</div>
						<div class="fileinput fileinput-new @if ($errorCategoryImage != '') has-error @endif" data-provides="fileinput">
								<label class="control-label input-sm marlm10">{{$alias['CategoryImage'][0]}} <span class="red">*</span></label>
								<div id="CategoryImage">
									@if (($action == 'edit' || $action == 'detail') && $CategoryImage != '')
									<div class="contentimage">
										<img src='{{$CategoryImage}}?{{uniqid()}}'/>
										<a id="deleteCategoryImage" class="btn btn-sm red" onclick="deleteCategoryImage();" value="Are you sure to remove {{$alias['CategoryImage'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
										Select {{$alias['CategoryImage'][0]}} </span>
										<span class="fileinput-exists">
										Change {{$alias['CategoryImage'][0]}} </span>
										<input type="file" name="CategoryImage">
									</span>
									<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
									Remove </a>
								</div>
								<span class="help-block">{{$errorCategoryImage}}</span>
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
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="@if ($errorName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Name'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Name" value="{{$Name}}">
							<span class="help-block">{{$errorName}}</span>
						</div>
						<div class="@if ($errorColumnMode != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ColumnMode'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ColumnMode">
								@foreach ($arrColumnMode as $key => $value)
								<option value="{{$key}}" @if ($key == $ColumnMode) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorColumnMode}}</span>
						</div>
						<div class="@if ($errorShowOnSubHeader != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['ShowOnSubHeader'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="ShowOnSubHeader">
								@foreach ($arrShowOnHeader as $key => $value)
								<option value="{{$key}}" @if ($key == $ShowOnSubHeader) selected @endif>{{$value}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorShowOnSubHeader}}</span>
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
		$('#deleteCategoryImage').css('width', $('#showImage').css('width'));
	});
	
	@if ($action == 'edit')
	function deleteCategoryImage() {
		bootbox.confirm($('#deleteCategoryImage').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteCategoryImage",'value':'{{$CategoryID}}'},
					success		: function(data) {
						if(!data) $('#CategoryImage').html('');
					}
				});
			}
		});
	}
	@endif
</script>
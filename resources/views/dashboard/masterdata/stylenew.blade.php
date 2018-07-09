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
						<div class="@if ($errorStyleName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['StyleName'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="StyleName" value="{{$StyleName}}">
							<span class="help-block">{{$errorStyleName}}</span>
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
						<div class="fileinput fileinput-new @if ($errorStyleImage != '') has-error @endif" data-provides="fileinput">
						<label class="control-label input-sm marlm10">{{$alias['StyleImage'][0]}} <span class="red">* <sup>Width 280px, Height 400px</sup></span></label>
						<div id="StyleImage">
							@if (($action == 'edit' || $action == 'detail') && $StyleImage != '')
							<div class="contentimage">
								<img src='{{$StyleImage}}?{{uniqid()}}'/>
								<a id="deleteStyleImage" class="btn btn-sm red" onclick="deleteStyleImage();" value="Are you sure to remove {{$alias['StyleImage'][0]}} ?"><i class="fa fa-trash-o"></i></a>
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
								Select {{$alias['StyleImage'][0]}} </span>
								<span class="fileinput-exists">
								Change {{$alias['StyleImage'][0]}} </span>
								<input type="file" name="StyleImage">
							</span>
							<a href="#" class="input-group-addon btn btn-sm red fileinput-exists" data-dismiss="fileinput">
							Remove </a>
						</div>
						<span class="help-block">{{$errorStyleImage}}</span>
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
	function deleteStyleImage() {
		bootbox.confirm($('#deleteStyleImage').attr('value'), function(result) {
			if(result) {
				$.ajax({
					url			: '{{$basesite}}{{$config['backend']['aliaspage']}}{{$extlink}}/ajaxpost',
					type		: 'POST',
					data		: {'ajaxpost':"deleteImage",'value':'{{$StyleID}}'},
					success		: function(data) {
						if(!data) $('#StyleImage').html('');
					}
				});
			}
		});
	}
	@endif
</script>
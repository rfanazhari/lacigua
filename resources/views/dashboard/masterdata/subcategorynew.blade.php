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
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorIDCategory != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['IDCategory'][0]}} <span class="red">*</span></label>
							<select class="form-control input-sm select2me" name="IDCategory">
								<option value=''>Select {{$alias['IDCategory'][0]}}</option>
								@foreach ($arrCategory as $obj)
								<option value="{{$obj['ID']}}" @if ($obj['ID'] == $IDCategory) selected @endif> {{$obj['ModelType']}} - {{$obj['Name']}}
								</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorIDCategory}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
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
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Name'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Name" value="{{$Name}}">
							<span class="help-block">{{$errorName}}</span>
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
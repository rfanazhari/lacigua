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
						<div class="@if ($errorName != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Name'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Name" value="{{$Name}}">
							<span class="help-block">{{$errorName}}</span>
						</div>
					</div>				
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorIconSocialMediaID != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['IconSocialMediaID'][0]}} <span class="red">*</span></label>
							<select class="bs-select form-control input-sm select2me" name="IconSocialMediaID">
								<option value=''>Select {{$alias['IconSocialMediaID'][0]}}</option>
								@foreach ($ArrIconSocialMedia as $obj)
									<option value="{{$obj['ID']}}" @if ($obj['ID'] == $IconSocialMediaID) selected @endif>{{$obj['Name']}}</option>
								@endforeach
							</select>
							<span class="help-block">{{$errorIconSocialMediaID}}</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="@if ($errorLink != '') has-error @endif">
							<label class="control-label input-sm marlm10">{{$alias['Link'][0]}} <span class="red">*</span></label>
							<input type="text" class="form-control input-sm" name="Link" value="{{$Link}}">
							<span class="help-block">{{$errorLink}}</span>
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